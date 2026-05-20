<x-layouts.app>
    <x-slot:title>Post a New Position — TalentFlow</x-slot:title>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Back Navigation -->
        <div>
            <a href="/jobs" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
                Cancel and Return
            </a>
        </div>

        <!-- Create Card -->
        <div class="glass-card rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-white tracking-tight">
                    Post a job listing
                </h1>
                <p class="mt-2 text-slate-400 text-sm">
                    Fill in the details below to publish your open role and start receiving applicants.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="/jobs" class="space-y-6">
                @csrf

                <!-- Job Title -->
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Job Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="e.g. Senior Laravel Engineer">
                    @error('title')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Annual Salary -->
                <div>
                    <label for="salary" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Salary Package</label>
                    <input type="text" name="salary" id="salary" value="{{ old('salary') }}" required
                           class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="e.g. $110,000 USD">
                    @error('salary')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Note about automatic Employer -->
                <div class="p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-2xl">
                    <p class="text-xs text-indigo-300 leading-relaxed">
                        <strong>Notice:</strong> This job will be posted under your company's profile. If your profile isn't fully set up yet, a default company page will be automatically initialized for you.
                    </p>
                </div>

                <!-- Submit Buttons -->
                <div class="pt-4 flex items-center justify-end gap-4">
                    <a href="/jobs" class="px-5 py-3 text-sm font-semibold text-slate-400 hover:text-white transition duration-150">
                        Cancel
                    </a>
                    <button type="submit" class="glow-btn bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Publish Position
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
