<x-layouts.app>
    <x-slot:title>Join TalentFlow — Create Account</x-slot:title>

    <div class="flex flex-col items-center justify-center py-10">
        <!-- Register Card -->
        <div class="glass-card w-full max-w-lg rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
            <!-- Decorative Light Flare -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-extrabold text-white tracking-tight sm:text-4xl">
                    Create your account
                </h1>
                <p class="mt-3 text-slate-400 text-sm">
                    Join TalentFlow and discover top employment opportunities today.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="/register" class="space-y-6">
                @csrf

                <!-- First & Last Name Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                               class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               placeholder="John">
                        @error('first_name')
                            <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                               class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               placeholder="Demo">
                        @error('last_name')
                            <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="john@example.com">
                    @error('email')
                        <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               placeholder="••••••••">
                        @error('password')
                            <p class="text-xs text-rose-400 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full bg-slate-900/50 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" class="glow-btn w-full bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/35 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Account
                    </button>
                </div>
            </form>

            <!-- Redirect Link -->
            <div class="mt-8 pt-6 border-t border-slate-900 text-center">
                <p class="text-sm text-slate-400">
                    Already have an account? 
                    <a href="/login" class="font-semibold text-indigo-400 hover:text-indigo-300 hover:underline transition duration-150">
                        Log In
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
