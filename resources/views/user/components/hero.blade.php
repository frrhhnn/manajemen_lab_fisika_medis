<section
    id="home"
    class="relative h-screen flex items-center justify-center overflow-hidden"
    data-aos="fade-in"
>
    <div class="absolute inset-0">
        <img
            src="{{ asset('images/hero/background.jpg') }}"
            alt="Laboratorium Fisika Medis"
            class="w-full h-full object-cover object-center scale-105 blur-sm brightness-80"
        />
        <div class="absolute inset-0 bg-black/60"></div>
        <!-- Pattern overlay -->
        <div class="absolute inset-0 opacity-30 pointer-events-none"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'0.07\'%3E%3Ccircle cx=\'5\' cy=\'5\' r=\'2\'/%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3Ccircle cx=\'55\' cy=\'55\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
        ></div>
    </div>
    <div class="relative z-10 flex flex-col items-center w-full px-4 sm:px-6 lg:px-8">
        <p class="text-white text-lg md:text-2xl mb-10 font-light tracking-wide opacity-0 animate-fadein-delay1 text-center">
            Selamat Datang di
        </p>
        <h1 class="flex flex-col items-center gap-2 font-roboto font-bold text-center text-5xl md:text-8xl mb-4 drop-shadow-lg">
            <span class="block text-white opacity-0 animate-fadein-delay2">Laboratorium</span>
            <span class="text-white animate-fadein-delay3 typing-animation">Fisika Medis dan Aplikasi Nuklir</span>
        </h1>
        <div class="mt-6 sm:mt-8 md:mt-10 mb-4 opacity-0 animate-fadein-delay4 w-full max-w-4xl">
            <span class="inline-flex flex-col sm:flex-row items-center text-center gap-2 bg-white/20 text-white px-4 sm:px-6 py-3 sm:py-2 rounded-full shadow-md text-sm sm:text-base md:text-lg backdrop-blur-md border border-white/30">
                <i class="fas fa-university text-secondary text-lg sm:text-xl hidden md:block"></i>
                <span class="leading-relaxed">
                    Departemen Fisika - Fakultas Matematika dan Ilmu Pengetahuan
                    Alam - Universitas Syiah Kuala
                </span>
            </span>
        </div>
    </div>
    <style>
        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadein-delay1 {
            animation: fadein 1s cubic-bezier(0.4, 0, 0.2, 1) both;
            animation-delay: 0.2s;
        }
        .animate-fadein-delay2 {
            animation: fadein 1s cubic-bezier(0.4, 0, 0.2, 1) both;
            animation-delay: 0.8s;
        }
        .animate-fadein-delay3 {
            animation: fadein 1s cubic-bezier(0.4, 0, 0.2, 1) both;
            animation-delay: 1.2s;
        }
        .animate-fadein-delay4 {
            animation: fadein 1s cubic-bezier(0.4, 0, 0.2, 1) both;
            animation-delay: 1.6s;
        }

        .typing-animation {
            /* This will allow text to wrap naturally */
            word-break: break-word;
            text-align: center;
            position: relative; /* Needed for cursor positioning */
        }

        .typing-cursor {
            display: inline-block;
            width: 3px; /* Width of the cursor */
            height: 1.1em; /* Height relative to the font-size */
            background-color: #10b981;
            margin-left: 4px;
            vertical-align: bottom; /* Aligns cursor with the bottom of the text */
            animation: blink-cursor 0.8s infinite;
        }

        @keyframes blink-cursor {
            50% {
                background-color: transparent;
            }
        }

        /* Add horizontal padding on mobile to prevent text touching the edges */
        @media (max-width: 768px) {
            h1 {
                padding: 0 1rem;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.querySelector('.typing-animation');
            if (!el) return;

            const textToType = el.textContent.trim();
            const cursorHTML = `<span class="typing-cursor"></span>`;
            el.innerHTML = cursorHTML; // Start with just the cursor

            let i = 0;
            let isDeleting = false;
            let loopTimeout;

            const typeDeleteLoop = () => {
                const typingSpeed = 120;
                const deletingSpeed = 60;
                const pauseDuration = 2000;

                // Set text with the cursor at the end
                el.innerHTML = textToType.substring(0, i) + cursorHTML;

                // Determine next action
                if (!isDeleting && i === textToType.length) {
                    // Pause at end, then start deleting
                    isDeleting = true;
                    loopTimeout = setTimeout(typeDeleteLoop, pauseDuration);
                } else if (isDeleting && i === 0) {
                    // Pause at start, then start typing
                    isDeleting = false;
                    loopTimeout = setTimeout(typeDeleteLoop, 500);
                } else {
                    // Continue typing or deleting
                    i += isDeleting ? -1 : 1;
                    const currentSpeed = isDeleting ? deletingSpeed : typingSpeed;
                    loopTimeout = setTimeout(typeDeleteLoop, currentSpeed);
                }
            };

            // Delay the start to sync with the initial fade-in animation
            setTimeout(typeDeleteLoop, 1600);
        });
    </script>
</section>
