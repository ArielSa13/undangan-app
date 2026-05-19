<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Authentication' }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Decorative -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-600 via-amber-500 to-yellow-400"></div>
            <!-- Animated floating shapes -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-2xl animate-pulse"></div>
                <div class="absolute bottom-1/3 right-1/4 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-2/3 left-1/3 w-48 h-48 bg-white/5 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>
            <!-- Dot pattern overlay -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                            <circle cx="20" cy="20" r="1.5" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="400" height="400" fill="url(#pattern)"/>
                </svg>
            </div>
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                <div class="mb-8">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-amber-900/10">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl xl:text-5xl font-bold text-white mb-4" style="font-family: 'Playfair Display', serif;">Undangan Digital Premium</h1>
                    <p class="text-lg text-white/80 leading-relaxed">Buat undangan pernikahan digital yang elegan, modern, dan berkesan. Platform terbaik untuk momen terbaik Anda.</p>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-white/90">Template premium yang menawan</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-white/90">RSVP & manajemen tamu</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-white/90">Musik, galeri, & countdown</span>
                    </div>
                </div>

                <!-- Trust badge -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <p class="text-white/60 text-sm">Dipercaya oleh 10,000+ pasangan di Indonesia</p>
                    <div class="flex items-center mt-3 space-x-1">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                        <span class="text-white/70 text-sm ml-2">4.9/5 Rating</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex-1 flex items-center justify-center p-6 lg:p-12 relative">
            <!-- Subtle background decoration for right side -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-amber-100/30 rounded-full blur-3xl -z-10"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-rose-100/20 rounded-full blur-3xl -z-10"></div>

            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex items-center space-x-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">Undangan<span class="text-amber-500">Pro</span></span>
                    </div>
                </div>

                @yield('auth-content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
