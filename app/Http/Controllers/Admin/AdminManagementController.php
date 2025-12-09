<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    public function index()
    {
        // Check if user is super admin
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Access denied. Only super admin can manage administrators.');
        }

        $admins = User::whereIn('role', ['admin', 'super_admin'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $adminStats = [
            'super_admin' => User::where('role', 'super_admin')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'total' => User::whereIn('role', ['admin', 'super_admin'])->count()
        ];

        return view('admin.admin-management.index', compact('admins', 'adminStats'));
    }

    public function store(Request $request)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat menambah admin.'
                ], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:admin,super_admin'
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['email_verified_at'] = now();

            User::create($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin berhasil ditambahkan'
                ]);
            }

            return redirect()->route('admin.admin-management.index')
                ->with('success', 'Admin berhasil ditambahkan');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan admin: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menambahkan admin: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(User $admin)
    {
        return view('admin.admin-management.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        return view('admin.admin-management.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat mengubah admin.'
                ], 403);
            }

            $rules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $admin->id,
                'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
                'role' => 'required|in:admin,super_admin'
            ];

            // Only validate password if provided
            if ($request->filled('password')) {
                $rules['password'] = 'required|string|min:6|confirmed';
            }

            $validated = $request->validate($rules);

            // Hash password if provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $admin->update($validated);

            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin berhasil diupdate'
                ]);
            }

            return redirect()->route('admin.admin-management.index')
                ->with('success', 'Admin berhasil diupdate');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate admin: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => 'Gagal mengupdate admin: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(User $admin)
    {
        try {
            // Check if user is super admin
            if (!auth()->user()->isSuperAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya super admin yang dapat menghapus admin.'
                ], 403);
            }

            // Prevent deleting self
            if ($admin->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus akun sendiri.'
                ], 400);
            }

            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus admin: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request, User $admin)
    {
        try {
            $validated = $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);

            $admin->update([
                'password' => Hash::make($validated['password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password admin berhasil direset'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset password: ' . $e->getMessage()
            ], 500);
        }
    }
}
