<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-black text-white tracking-tight">Profil Saya</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        <div class="space-y-6">
            {{-- Update Profile --}}
            <div id="update-profile" class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-8">
                <h2 class="text-lg font-black text-white tracking-tight mb-6 flex items-center gap-3">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-xl">
                        <x-lucide-user class="w-5 h-5" />
                    </div>
                    Informasi Profil
                </h2>
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div id="update-password" class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl p-8">
                <h2 class="text-lg font-black text-white tracking-tight mb-6 flex items-center gap-3">
                    <div class="p-2 bg-blue-500/10 text-blue-400 rounded-xl">
                        <x-lucide-lock class="w-5 h-5" />
                    </div>
                    Perbarui Kata Sandi
                </h2>
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div id="delete-account" class="bg-slate-900 border border-rose-900/30 rounded-3xl shadow-2xl p-8">
                <h2 class="text-lg font-black text-rose-400 tracking-tight mb-6 flex items-center gap-3">
                    <div class="p-2 bg-rose-500/10 text-rose-400 rounded-xl">
                        <x-lucide-trash-2 class="w-5 h-5" />
                    </div>
                    Hapus Akun
                </h2>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>