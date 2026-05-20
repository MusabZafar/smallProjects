<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TalentFlow — Premium Job Board' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                              radial-gradient(circle at 0% 100%, rgba(139, 92, 246, 0.08) 0%, transparent 40%);
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .glow-btn {
            position: relative;
            transition: all 0.3s ease;
        }
        .glow-btn::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(45deg, #6366f1, #8b5cf6);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .glow-btn:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans antialiased">

    <!-- Premium Glass Navigation -->
    <nav class="glass-nav sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <a href="/jobs" class="flex items-center gap-2 group">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-200 via-slate-100 to-indigo-100 bg-clip-text text-transparent group-hover:from-indigo-300 group-hover:to-white transition-all duration-300">
                            Talent<span class="text-indigo-400">Flow</span>
                        </span>
                    </a>
                </div>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="/jobs" class="text-sm font-medium transition-colors duration-200 {{ request()->is('jobs') ? 'text-indigo-400' : 'text-slate-300 hover:text-white' }}">
                        Explore Jobs
                    </a>
                    @auth
                        <a href="/jobs/create" class="text-sm font-medium transition-colors duration-200 {{ request()->is('jobs/create') ? 'text-indigo-400' : 'text-slate-300 hover:text-white' }}">
                            Post a Job
                        </a>
                    @endauth
                </div>

                <!-- Auth Section -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="hidden sm:flex flex-col items-end mr-2">
                            <span class="text-xs text-slate-400">Signed in as</span>
                            <span class="text-sm font-semibold text-slate-200">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                        </div>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-slate-300 hover:text-white glass-card rounded-xl hover:bg-slate-900/80 transition-all duration-200">
                                Log Out
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">
                            Log In
                        </a>
                        <a href="/register" class="glow-btn bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all duration-300">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{ $slot }}
    </main>

    <!-- Beautiful Footer -->
    <footer class="mt-auto border-t border-slate-900 bg-slate-950/60 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">&copy; {{ date('Y') }} TalentFlow Inc. All rights reserved.</p>
            <div class="flex gap-6 text-sm text-slate-400">
                <span class="hover:text-indigo-400 transition-colors cursor-pointer">PT10 Part 1 Authentication Lab</span>
                <span class="text-slate-700">|</span>
                <span class="text-slate-500">Built with Antigravity AI</span>
            </div>
        </div>
    </footer>

</body>
</html>
