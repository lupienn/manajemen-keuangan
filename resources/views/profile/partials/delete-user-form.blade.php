<section class="space-y-6" x-data="{ showModal: false }">
    <header class="border-b border-slate-800 pb-6 mb-8">
        <h2 class="text-sm font-black uppercase tracking-widest text-slate-500">
            Hapus Akun
        </h2>

        <p class="mt-2 text-xs text-slate-400 font-medium">
            Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, silakan unduh data atau informasi apa pun yang ingin Anda simpan.
        </p>
    </header>

    <button @click="showModal = true" type="button" class="px-6 py-3 bg-rose-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-rose-500 transition shadow-xl shadow-rose-900/20">
        Hapus Akun
    </button>

    <!-- Delete Confirmation Modal -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" 
         style="display: none;">
        <div @click.away="showModal = false" 
             x-show="showModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl max-w-lg w-full">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <h2 class="text-lg font-black text-white tracking-tight mb-4">
                    Apakah Anda yakin ingin menghapus akun Anda?
                </h2>

                <p class="mt-1 text-sm text-slate-400 font-medium">
                    Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                </p>

                <div class="mt-6">
                    <label for="password_delete" class="sr-only">Password</label>
                    <input id="password_delete" name="password" type="password" class="w-full border-0 bg-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-blue-500 font-bold" placeholder="Password" />
                    @error('password', 'userDeletion')
                        <p class="mt-2 text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-8 flex justify-end gap-3">
                     <button type="button" @click="showModal = false" class="px-6 py-3 border border-slate-800 text-slate-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-800 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-rose-500 transition shadow-xl shadow-rose-900/20">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>