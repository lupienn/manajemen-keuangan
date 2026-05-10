<x-app-layout>
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        <div class="space-y-6">
            {{-- Update Profile --}}
            <div id="update-profile" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <x-lucide-user class="w-5 h-5 text-corporate" />
                    Informasi Profil
                </h2>
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div id="update-password" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-base font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                    <x-lucide-lock class="w-5 h-5 text-corporate" />
                    Perbarui Kata Sandi
                </h2>
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete Account --}}
            <div id="delete-account" class="bg-white border border-rose-200 rounded-xl shadow-sm p-6 dark:bg-gray-800 dark:border-rose-900/50">
                <h2 class="text-base font-bold text-rose-700 dark:text-rose-400 mb-5 flex items-center gap-2">
                    <x-lucide-trash-2 class="w-5 h-5" />
                    Hapus Akun
                </h2>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>