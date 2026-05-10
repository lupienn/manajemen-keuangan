<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800 flex flex-col justify-between">
      <ul class="space-y-1 font-medium">
         {{-- Dashboard --}}
         <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-layout-dashboard class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-primary-700' : 'text-gray-500' }}" />
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         
         <li class="pt-5 pb-1 px-2">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Manajemen Keuangan</span>
         </li>

         {{-- Pemasukan --}}
         <li>
            <a href="{{ route('transactions.index', ['jenis' => 'pemasukan']) }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pemasukan' ? 'bg-emerald-50 text-emerald-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-arrow-down-circle class="w-5 h-5 text-emerald-500" />
               <span class="flex-1 ms-3 whitespace-nowrap">Pemasukan</span>
            </a>
         </li>
         {{-- Pengeluaran --}}
         <li>
            <a href="{{ route('transactions.index', ['jenis' => 'pengeluaran']) }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pengeluaran' ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-arrow-up-circle class="w-5 h-5 text-rose-500" />
               <span class="flex-1 ms-3 whitespace-nowrap">Pengeluaran</span>
            </a>
         </li>
         {{-- Semua Transaksi --}}
         <li>
            <a href="{{ route('transactions.index') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('transactions.*') && !request()->get('jenis') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-list class="w-5 h-5 text-gray-500" />
               <span class="flex-1 ms-3 whitespace-nowrap">Semua Transaksi</span>
            </a>
         </li>
         {{-- Anggaran --}}
         <li>
            <a href="{{ route('budgets.index') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('budgets.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-pie-chart class="w-5 h-5 {{ request()->routeIs('budgets.*') ? 'text-primary-700' : 'text-gray-500' }}" />
               <span class="flex-1 ms-3 whitespace-nowrap">Anggaran</span>
            </a>
         </li>

         <li class="pt-5 pb-1 px-2">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Laporan</span>
         </li>
         {{-- Laporan Keuangan --}}
         <li>
            <a href="{{ route('reports.index') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('reports.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-file-bar-chart class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-primary-700' : 'text-gray-500' }}" />
               <span class="flex-1 ms-3 whitespace-nowrap">Laporan Keuangan</span>
            </a>
         </li>

         <li class="pt-5 pb-1 px-2">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Akun</span>
         </li>
         <li>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-gray-100' }}">
               <x-lucide-user-circle class="w-5 h-5 text-gray-500" />
               <span class="flex-1 ms-3 whitespace-nowrap">Profil Saya</span>
            </a>
         </li>
      </ul>

      <div class="pt-4 border-t border-gray-200">
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center p-2 text-gray-700 rounded-lg hover:bg-red-50 hover:text-red-700 group">
               <x-lucide-log-out class="w-5 h-5 text-gray-500 group-hover:text-red-500" />
               <span class="flex-1 ms-3 text-left whitespace-nowrap">Keluar</span>
            </button>
         </form>
      </div>
   </div>
</aside>
