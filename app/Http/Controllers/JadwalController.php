<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $currentMonth = request('month', now()->format('Y-m'));
        return view('admin.components.tabs.schedule', compact('currentMonth'));
    }

    public function getCalendarData(Request $request)
    {
        \Log::info('Calendar data requested', [
            'month' => $request->input('month'),
            'user' => auth()->user()->id ?? 'guest'
        ]);

        $month = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($month . '-01');
        $endDate = $startDate->copy()->endOfMonth();

        \Log::info('Date range for calendar', [
            'start' => $startDate->format('Y-m-d'),
            'end' => $endDate->format('Y-m-d')
        ]);

        // Get all schedules for the month
        $schedules = Jadwal::whereBetween('tanggal', [$startDate, $endDate])
            ->with('kunjungan')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal->format('Y-m-d');
            });

        // Auto-create default schedules for future dates that don't have any schedules
        $today = Carbon::today();
        for ($date = $today->copy(); $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            if (!$schedules->has($dateStr)) {
                // Create default schedules for this date
                $defaultSchedules = collect(Jadwal::createDefaultSchedule($dateStr));
                $schedules->put($dateStr, $defaultSchedules);
                \Log::info('Created default schedule for date', ['date' => $dateStr]);
            }
        }

        \Log::info('Schedules found', [
            'total_schedules' => $schedules->count(),
            'dates_with_schedules' => $schedules->keys()->toArray()
        ]);

        $calendarData = [];
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $daySchedules = $schedules->get($dateStr, collect());
            
            $dayInfo = [
                'date' => $dateStr,
                'day' => $date->day,
                'isToday' => $date->isToday(),
                'isPast' => $date->isPast(),
                'schedules' => $daySchedules->map(function($schedule) {
                    return [
                        'id' => $schedule->id,
                        'timeLabel' => $schedule->time_label,
                        'isActive' => $schedule->isActive,
                        'isBooked' => $schedule->is_booked,
                        'kunjungan' => $schedule->kunjungan ? [
                            'nama' => $schedule->kunjungan->namaPengunjung,
                            'status' => $schedule->kunjungan->status,
                            'isCompleted' => $schedule->kunjungan->status === 'COMPLETED',
                            'namaInstansi' => $schedule->kunjungan->namaInstansi,
                            'jumlahPengunjung' => $schedule->kunjungan->jumlahPengunjung
                        ] : null
                    ];
                })->toArray(),
                'hasBookings' => $daySchedules->whereNotNull('kunjunganId')->count() > 0,
                'bookingInfo' => $daySchedules->whereNotNull('kunjunganId')->map(function($schedule) {
                    $status = $schedule->kunjungan && $schedule->kunjungan->status === 'COMPLETED' ? '✓' : '';
                    return $status . ' ' . ($schedule->kunjungan ? $schedule->kunjungan->namaPengunjung : 'Unknown') . ' (' . $schedule->time_label . ')';
                })->implode(', ')
            ];
            
            $calendarData[] = $dayInfo;
        }

        \Log::info('Calendar data prepared', [
            'total_days' => count($calendarData),
            'days_with_schedules' => array_filter($calendarData, function($day) {
                return !empty($day['schedules']);
            })
        ]);

        return response()->json($calendarData);
    }

    public function getScheduleSettings(Request $request)
    {
        try {
            $date = $request->input('date');
            
            if (!$date) {
                return response()->json([
                    'success' => false,
                    'message' => 'Date parameter is required'
                ], 400);
            }

            \Log::info('Getting schedule settings for date', ['date' => $date]);

            $schedules = Jadwal::where('tanggal', $date)
                ->with('kunjungan')
                ->orderBy('waktuKunjungan')
                ->get();

            if ($schedules->isEmpty()) {
                // Create default schedule for this date
                \Log::info('No schedules found, creating default', ['date' => $date]);
                $schedules = collect(Jadwal::createDefaultSchedule($date));
            }

            $scheduleData = $schedules->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'waktuKunjungan' => $schedule->waktuKunjungan,
                    'timeLabel' => $schedule->time_label,
                    'isActive' => $schedule->isActive,
                    'isBooked' => $schedule->is_booked,
                    'kunjungan' => $schedule->kunjungan ? [
                        'nama' => $schedule->kunjungan->namaPengunjung,
                        'status' => $schedule->kunjungan->status,
                        'isCompleted' => $schedule->kunjungan->status === 'COMPLETED'
                    ] : null
                ];
            });

            return response()->json([
                'success' => true,
                'date' => $date,
                'schedules' => $scheduleData
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getScheduleSettings', [
                'date' => $request->input('date'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error loading schedule settings: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleAvailability(Request $request)
    {
        $request->validate([
            'scheduleId' => 'required|uuid',
            'isActive' => 'required|boolean'
        ]);

        $schedule = Jadwal::findOrFail($request->scheduleId);
        
        // Don't allow changing status if there's an approved or completed booking
        if ($schedule->is_booked && $schedule->kunjungan) {
            $status = $schedule->kunjungan->status;
            if (in_array($status, ['PROCESSING', 'COMPLETED'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengubah jadwal yang sudah disetujui atau selesai'
                ]);
            }
        }
        
        // Don't allow disabling if there's any active booking (even pending)
        if ($schedule->is_booked && !$request->isActive) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menonaktifkan jadwal yang sudah dibooking'
            ]);
        }

        $schedule->update(['isActive' => $request->isActive]);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui'
        ]);
    }

    public function getAvailableSessions(Request $request)
    {
        $date = $request->input('date');
        
        // Check if schedules exist for this date, if not create default ones
        $existingSchedules = Jadwal::where('tanggal', $date)->count();
        if ($existingSchedules === 0) {
            Jadwal::createDefaultSchedule($date);
        }
        
        // Get all available time slots using new waktuKunjungan format
        $availableSessions = [];
        $defaultSlots = Jadwal::getDefaultSlots();
        
        foreach ($defaultSlots as $waktuKunjungan) {
            // Check if this slot is available
            $schedule = Jadwal::where('tanggal', $date)
                ->where('waktuKunjungan', $waktuKunjungan)
                ->with('kunjungan')
                ->first();
            
            $isAvailable = false;
            
            if ($schedule) {
                if ($schedule->isActive) {
                    if (!$schedule->kunjunganId) {
                        // No booking at all
                        $isAvailable = true;
                    } else if ($schedule->kunjungan && 
                               in_array($schedule->kunjungan->status, ['CANCELLED'])) {
                        // Booking is cancelled, so slot is available again
                        $isAvailable = true;
                    }
                    // For PENDING, PROCESSING, COMPLETED - slot is NOT available
                }
            }
            
            if ($isAvailable) {
                $times = explode('-', $waktuKunjungan);
                $availableSessions[] = [
                    'jamMulai' => trim($times[0]),
                    'jamSelesai' => trim($times[1]),
                    'time' => str_replace('-', ' - ', $waktuKunjungan),
                    'waktuKunjungan' => $waktuKunjungan
                ];
            }
        }

        return response()->json([
            'available_sessions' => $availableSessions
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'isActive' => 'required|boolean'
        ]);

        $schedule = Jadwal::findOrFail($id);
        
        // Don't allow changing status if there's an approved or completed booking
        if ($schedule->is_booked && $schedule->kunjungan) {
            $status = $schedule->kunjungan->status;
            if (in_array($status, ['PROCESSING', 'COMPLETED'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengubah jadwal yang sudah disetujui atau selesai'
                ]);
            }
        }
        
        if ($schedule->is_booked && !$request->isActive) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menonaktifkan jadwal yang sudah dibooking'
            ]);
        }

        $schedule->update(['isActive' => $request->isActive]);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $schedule = Jadwal::findOrFail($id);
        
        if ($schedule->is_booked) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus jadwal yang sudah dibooking'
            ]);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus'
        ]);
    }
} 