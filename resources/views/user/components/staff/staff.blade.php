@extends('layouts.user-section')

@section('title', 'Staff dan Ahli - Laboratorium Fisika Medis')

@section('breadcrumb')
    <li class="text-white/60">•</li>
    <li class="text-white font-medium">Staff dan Ahli</li>
@endsection

@section('page-title', 'Staff & Tenaga Ahli')

@section('page-description', 'Tim kami terdiri dari para profesional berdedikasi dengan keahlian mendalam di bidangnya masing-masing, siap mendukung riset dan inovasi.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <section class="py-16 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="absolute top-10 right-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-40 h-40 bg-emerald-600/10 rounded-full blur-3xl"></div>

        <div class="container mx-auto px-4 relative z-10" x-data="{
            filter: 'all',
            staff: [
                @foreach(\App\Models\BiodataPengurus::all() as $member)
                { 
                    name: '{{ $member->nama }}', 
                    role: '{{ $member->jabatan }}', 
                    image: '{{ $member->image_url }}', 
                    type: '{{ str_contains(strtolower($member->jabatan), 'dosen') ? 'dosen' : (str_contains(strtolower($member->jabatan), 'kepala') ? 'kepala-lab' : '') }}'
                },
                @endforeach
            ],
            get filteredStaff() {
                if (this.filter === 'all') return this.staff;
                return this.staff.filter(s => s.type === this.filter);
            }
        }">
            
            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-4 mb-16" data-aos="fade-up" data-aos-delay="100">
                <button @click="filter = 'all'" :class="{ 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg': filter === 'all', 'bg-white/80 backdrop-blur-sm text-primary hover:bg-white': filter !== 'all' }" class="px-6 py-3 rounded-full font-bold border border-primary text-sm transition-all duration-300 shadow-md">Semua</button>
                <button @click="filter = 'kepala-lab'" :class="{ 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg': filter === 'kepala-lab', 'bg-white/80 backdrop-blur-sm text-primary hover:bg-white': filter !== 'kepala-lab' }" class="px-6 py-3 rounded-full font-bold border border-primary text-sm transition-all duration-300 shadow-md">Kepala Laboratorium</button>
                <button @click="filter = 'dosen'" :class="{ 'bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-lg': filter === 'dosen', 'bg-white/80 backdrop-blur-sm text-primary hover:bg-white': filter !== 'dosen' }" class="px-6 py-3 rounded-full font-bold border border-primary text-sm transition-all duration-300 shadow-md">Dosen</button>
            </div>

            <!-- Staff Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <template x-for="(person, index) in filteredStaff" :key="person.name">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl group transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20 hover:-translate-y-2 bg-white/0" data-aos="fade-up" :data-aos-delay="200 + (index * 50)">
                        <!-- Profile Picture - Full Card -->
                        <img :src="person.image" alt="Foto Staff" class="w-full h-96 object-cover transition-transform duration-500 group-hover:scale-105">
                        <!-- Overlay Gradient Bottom -->
                        <div class="absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        <!-- Info Section Overlayed -->
                        <div class="absolute bottom-0 left-0 w-full px-6 pb-6 z-10 text-left">
                            <h3 class="text-lg font-bold text-white mb-1 drop-shadow" x-text="person.name"></h3>
                            <p class="text-emerald-300 font-semibold mb-1 text-sm drop-shadow" x-text="person.role"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredStaff.length === 0" class="text-center py-12">
                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada staff</h3>
                <p class="text-gray-500">Belum ada data staff untuk kategori yang dipilih.</p>
            </div>
        </div>
    </section>
</div>
@endsection