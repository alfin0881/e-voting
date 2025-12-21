<div class="min-h-screen flex flex-col items-center justify-center px-4 bg-white">
    <div class="w-full max-w-md">
        {{-- Header --}}
        <div class="text-center mb-5 animate-fade-in">
            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-600 to-slate-700 bg-clip-text text-transparent">
                Kasya E-Voting
            </h1>
            <p class="text-gray-600 mt-2">Silakan masuk untuk melanjutkan</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 animate-scale-up">
            <form wire:submit="login" class="space-y-6">
                <!-- NIS Input -->
                <div>
                    <label for="nis" class="block text-sm font-semibold text-gray-700 mb-2">
                        NIS / Username
                    </label>
                    <input 
                        type="text" 
                        id="nis" 
                        wire:model="nis"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition duration-200"
                        placeholder="Masukkan NIS Anda"
                        autofocus
                    >
                </div>
                 @error('nis') 
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        wire:model="password"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none transition duration-200"
                        placeholder="Masukkan password Anda"
                    >
                    @error('password') 
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-3 px-6 bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-xl font-semibold hover:shadow-xl hover:scale-101 transition duration-300 transform"
                >
                    Masuk
                </button>
            </form>

            {{-- Info --}}
            <div class="mt-6 p-4 bg-indigo-50 rounded-xl">
                <p class="text-xs text-indigo-700 text-center">
                    <b>Info:</b> NIS digunakan sebagai username dan password.                    
                    {{-- <br><span class="text-gray-600">Jika ada pertanyaan atau kendala, hubungi (Admin MalfinZ).</span>  --}}
                </p>
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-center text-gray-500 text-sm mt-8">
            © 2025 Kasya E-Voting. All rights reserved.
        </p>
    </div>
</div>
 