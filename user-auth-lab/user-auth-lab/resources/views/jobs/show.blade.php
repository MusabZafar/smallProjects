<x-layouts.app>
    <x-slot:title>{{ $job->title }} at {{ $job->employer->name }} — TalentFlow</x-slot:title>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div>
            <a href="/jobs" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to All Jobs
            </a>
        </div>

        <!-- Job Card Details -->
        <div class="glass-card rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-24 -left-24 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                <!-- Header: Employer & Badge -->
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-900 pb-6">
                    <div class="space-y-1">
                        <span class="text-sm font-semibold uppercase tracking-wider text-indigo-400">
                            {{ $job->employer->name }}
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                            {{ $job->title }}
                        </h1>
                    </div>
                    <span class="px-4 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        Active Opening
                    </span>
                </div>

                <!-- Salary Info Box -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-slate-950/40 border border-slate-900 rounded-2xl p-6">
                    <div>
                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Salary Package</span>
                        <p class="text-xl font-bold text-white mt-1">{{ $job->salary }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Job Type</span>
                        <p class="text-xl font-bold text-white mt-1">Full-time / Remote</p>
                    </div>
                </div>

                <!-- Job Description (Mocked beautifully) -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-slate-200">About the Role</h3>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        We are looking for a highly skilled, motivated professional to join our expanding team. In this position, you will collaborate with cross-functional teams to design, develop, and implement scalable, secure systems. You will play a key role in setting technical standards, mentoring junior engineers, and driving engineering best practices.
                    </p>
                    <p class="text-slate-400 leading-relaxed text-sm">
                        The ideal candidate has hands-on experience in modern backend frameworks (specifically Laravel), is comfortable operating in cloud ecosystems (AWS, SQLite/PostgreSQL), and values clean, elegant, and maintainable code architectures.
                    </p>
                </div>

                <!-- Authorized Actions (Edit / Delete) -->
                <div class="border-t border-slate-900 pt-6 mt-8 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <!-- Public Contact Button -->
                        <a href="mailto:careers@example.com?subject=Application%20for%20{{ urlencode($job->title) }}" 
                           class="glow-btn inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-600/25 transition-all duration-300">
                            Apply for Job
                        </a>
                    </div>

                    @can('edit-job', $job)
                        <div class="flex items-center gap-3">
                            <!-- Edit Button -->
                            <a href="/jobs/{{ $job->id }}/edit" 
                               class="px-5 py-2.5 text-sm font-semibold text-slate-200 hover:text-white glass-card hover:bg-slate-900/80 rounded-xl transition duration-150">
                                Edit Listing
                            </a>

                            <!-- Delete Form -->
                            <form method="POST" action="/jobs/{{ $job->id }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this job listing? This action is permanent.')"
                                        class="px-5 py-2.5 text-sm font-semibold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-xl transition duration-150">
                                    Delete Job
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>
