<x-layouts.app>
    <x-slot:title>Explore Career Opportunities — TalentFlow</x-slot:title>

    <div class="space-y-10">
        <!-- Hero Section / Header -->
        <div class="relative overflow-hidden rounded-3xl p-8 sm:p-12 glass-card border border-slate-800/80 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-6">
            <!-- Background lights -->
            <div class="absolute -top-24 -left-24 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-violet-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="space-y-4 max-w-2xl relative z-10">
                <h1 class="text-4xl font-extrabold sm:text-5xl tracking-tight text-white">
                    Find your next <span class="bg-gradient-to-r from-indigo-400 to-violet-400 bg-clip-text text-transparent">career move</span>
                </h1>
                <p class="text-slate-400 text-lg sm:text-xl">
                    Discover high-paying, verified jobs at elite tech companies and startups worldwide.
                </p>
            </div>

            <div class="shrink-0 relative z-10">
                @auth
                    <a href="/jobs/create" class="glow-btn inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Post a Job Listing
                    </a>
                @else
                    <a href="/login" class="glow-btn inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-300">
                        Sign In to Post Jobs
                    </a>
                @endauth
            </div>
        </div>

        <!-- Jobs Listing Section -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-100 tracking-tight flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Latest Positions
                </h2>
                <span class="text-sm font-medium text-slate-400">Total: {{ $jobs->count() }} openings</span>
            </div>

            @if ($jobs->isEmpty())
                <!-- Empty State -->
                <div class="glass-card text-center rounded-3xl p-12 border border-slate-900 shadow-xl">
                    <div class="h-16 w-16 mx-auto mb-6 bg-slate-900 rounded-2xl flex items-center justify-center border border-slate-800 text-slate-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-200">No Job Listings Available</h3>
                    <p class="text-slate-400 mt-2 max-w-sm mx-auto">Be the first to list an open position and hire your next team member!</p>
                    <div class="mt-6">
                        <a href="/jobs/create" class="inline-flex items-center gap-2 text-indigo-400 hover:text-indigo-300 font-semibold transition duration-150">
                            Create Job Listing &rarr;
                        </a>
                    </div>
                </div>
            @else
                <!-- Jobs Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($jobs as $job)
                        <a href="/jobs/{{ $job->id }}" class="group block glass-card rounded-2xl p-6 sm:p-8 hover:scale-[1.01] hover:border-slate-700/80 transition-all duration-300 shadow-lg relative overflow-hidden">
                            <!-- Subtle border glow effect -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/0 via-indigo-500/0 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <div class="flex flex-col h-full justify-between gap-6 relative z-10">
                                <div>
                                    <!-- Company Tag -->
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400">
                                            {{ $job->employer->name }}
                                        </span>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                                            Full-time
                                        </span>
                                    </div>

                                    <!-- Job Title -->
                                    <h3 class="text-xl font-bold text-white group-hover:text-indigo-300 transition-colors duration-200">
                                        {{ $job->title }}
                                    </h3>
                                </div>

                                <!-- Salary & Detail Button -->
                                <div class="flex items-center justify-between border-t border-slate-900 pt-4 mt-auto">
                                    <div class="space-y-0.5">
                                        <span class="text-xs text-slate-500 font-medium">Annual Salary</span>
                                        <p class="text-sm font-semibold text-slate-200">{{ $job->salary }}</p>
                                    </div>
                                    <span class="text-sm font-bold text-indigo-400 group-hover:translate-x-1.5 transition-transform duration-200 flex items-center gap-1">
                                        View Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
