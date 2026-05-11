<section>
    <header class="border-b border-slate-800 pb-6 mb-8">
        <h2 class="text-sm font-black uppercase tracking-widest text-slate-500">
            Perbarui Password
        </h2>

        <p class="mt-2 text-xs text-slate-400 font-medium">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p>
           @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Password Baru</label>
            <input id="update_password_password" name="password" type="password" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p>
           @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p>
           @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 transition shadow-xl shadow-blue-900/20">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[10px] font-black uppercase tracking-widest text-emerald-400"
                >Tersimpan.</p>
            @endif
        </div>
    </form>
</section>