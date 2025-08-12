<section id="about" class="relative py-24 bg-gradient-to-br from-gray-50 via-white to-gray-100 overflow-hidden scroll-mt-20">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #10B981 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-emerald-600/10 rounded-full blur-3xl"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Header -->
        <div class="text-center mb-10" data-aos="fade-down">
            <h2 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-6 font-inter">
                <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 bg-clip-text text-transparent">
                    Tentang
                </span>
                <span class="text-gray-800"> Laboratorium</span>
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 mx-auto mb-8"></div>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
            Laboratorium Fisika Medis dan Aplikasi Nuklir berfokus pada penerapan ilmu fisika dalam bidang kesehatan, khususnya untuk diagnostik dan terapi medis berbasis radiasi serta pengembangan riset di bidang dosimetri, pencitraan medis, dan radioterapi.
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Laboratory Image -->
            <div class="relative" data-aos="fade-right" data-aos-delay="200">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/facilities/fasilitas.jpg') }}" alt="Laboratorium Fisika Medis" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-800/80 via-gray-800/20 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 to-emerald-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-6 border border-white/20">
                            <h3 class="text-white text-2xl font-bold mb-3 flex items-center">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></span>
                                Fasilitas Modern
                            </h3>
                            <p class="text-gray-200 text-sm leading-relaxed">Dilengkapi dengan peralatan terkini untuk mendukung penelitian dan pembelajaran berkualitas tinggi</p>
                        </div>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl opacity-20 rotate-12"></div>
                <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-gradient-to-br from-emerald-600 to-emerald-500 rounded-2xl opacity-30 -rotate-12"></div>
            </div>
            
            <!-- Content Cards -->
            <div class="space-y-8" data-aos="fade-left" data-aos-delay="300">
                @php
                    $visionMission = \App\Models\VisionMission::getLatest();
                @endphp
                
                @if($visionMission)
                    <!-- Vision Card -->
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20">
                        <div class="flex flex-col items-start">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-emerald-500 transition-colors">Visi</h3>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-600 leading-relaxed">{{ $visionMission->vision }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mission Card -->
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20">
                        <div class="flex flex-col items-start">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-emerald-500 transition-colors">Misi</h3>
                            </div>
                            <div class="flex-1">
                                <ul class="space-y-4">
                                    @php
                                        $missions = explode("\n", $visionMission->mission);
                                    @endphp
                                    @foreach($missions as $mission)
                                        @if(trim($mission) !== '')
                                            <li class="flex items-start space-x-3 text-gray-600">
                                                <span class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-2"></span>
                                                <span class="leading-relaxed">{{ trim($mission) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Fallback Content -->
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20">
                        <div class="flex flex-col items-start">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-emerald-500 transition-colors">Visi</h3>
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-600 leading-relaxed">Menjadi pusat unggulan dalam pengembangan dan aplikasi teknologi fisika medis dan nuklir yang berkontribusi pada kemajuan ilmu pengetahuan dan kesehatan masyarakat.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border border-gray-100/50 hover:border-emerald-500/20">
                        <div class="flex flex-col items-start">
                            <div class="flex items-center space-x-4 mb-6">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-emerald-600 to-emerald-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800 group-hover:text-emerald-500 transition-colors">Misi</h3>
                            </div>
                            <div class="flex-1">
                                <ul class="space-y-4">
                                    <li class="flex items-start space-x-3 text-gray-600">
                                        <span class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-2"></span>
                                        <span class="leading-relaxed">Menyelenggarakan pendidikan dan pelatihan berkualitas dalam bidang fisika medis dan aplikasi nuklir</span>
                                    </li>
                                    <li class="flex items-start space-x-3 text-gray-600">
                                        <span class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-2"></span>
                                        <span class="leading-relaxed">Melakukan penelitian inovatif yang bermanfaat bagi perkembangan ilmu pengetahuan dan teknologi</span>
                                    </li>
                                    <li class="flex items-start space-x-3 text-gray-600">
                                        <span class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-2"></span>
                                        <span class="leading-relaxed">Memberikan layanan profesional kepada masyarakat dalam bidang fisika medis dan aplikasi nuklir</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>