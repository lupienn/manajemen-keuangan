<section>
    <header class="border-b border-slate-800 pb-6 mb-8">
        <h2 class="text-sm font-black uppercase tracking-widest text-slate-500">
            Informasi Profil
        </h2>

        <p class="mt-2 text-xs text-slate-400 font-medium">
            Perbarui informasi profil akun Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="nama" class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Nama</label>
            <input id="nama" name="nama" type="text" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold" value="{{ old('nama', $user->nama) }}" required autofocus autocomplete="name" />
            @error('nama', 'updateProfileInformation')
                <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-blue-500 transition shadow-xl shadow-blue-900/20">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
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