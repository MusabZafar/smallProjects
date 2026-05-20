<x-layouts.app>
    <x-slot:title>Log In — TalentFlow</x-slot:title>

    <div class="flex flex-col items-center justify-center py-10">
        <!-- Login Card -->
        <div class="glass-card w-full max-w-md rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Light Flare -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-violet-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    Welcome Back
                </h1>
                <p class="mt-3 text-slate-400 text-sm">
                    Enter your credentials to manage your job listings.
                </p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-semibold text-rose-200">Authentication Failed</h4>
                        <ul class="text-xs text-rose-300/95 mt-1 list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="john@example.com">
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">Password</label>
                    </div>
                    <input type="password" name="password" id="password" required
                           class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="••••••••">
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit" class="glow-btn w-full bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Log In
                    </button>
                </div>
            </form>

            <!-- Redirect Link -->
            <div class="mt-8 pt-6 border-t border-slate-900 text-center">
                <p class="text-sm text-slate-400">
                    New to TalentFlow? 
                    <a href="/register" class="font-semibold text-indigo-400 hover:text-indigo-300 hover:underline transition duration-150">
                        Register Account
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
