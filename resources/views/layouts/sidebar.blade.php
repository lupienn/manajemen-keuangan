<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-[#0f172a] sm:translate-x-0 border-r border-slate-800/50" aria-label="Sidebar">
   <div class="h-full px-4 pb-4 overflow-y-auto flex flex-col justify-between">
      <ul class="space-y-1.5 font-medium">
         {{-- Dashboard --}}
         <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-layout-dashboard class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-slate-300' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Dashboard</span>
            </a>
         </li>
         
         <li class="pt-8 pb-2 px-3">
            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Finansial</span>
         </li>

         {{-- Pemasukan --}}
         <li>
            <a href="{{ route('transactions.index', ['jenis' => 'pemasukan']) }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pemasukan' ? 'bg-emerald-600/10 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-arrow-down-circle class="w-5 h-5 {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pemasukan' ? 'text-emerald-400' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Pemasukan</span>
            </a>
         </li>
         {{-- Pengeluaran --}}
         <li>
            <a href="{{ route('transactions.index', ['jenis' => 'pengeluaran']) }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pengeluaran' ? 'bg-rose-600/10 text-rose-400 border border-rose-500/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-arrow-up-circle class="w-5 h-5 {{ request()->routeIs('transactions.*') && request()->get('jenis') === 'pengeluaran' ? 'text-rose-400' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Pengeluaran</span>
            </a>
         </li>
         {{-- Semua Transaksi --}}
         <li>
            <a href="{{ route('transactions.index') }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('transactions.*') && !request()->get('jenis') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-list class="w-5 h-5 {{ request()->routeIs('transactions.*') && !request()->get('jenis') ? 'text-white' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Semua Data</span>
            </a>
         </li>
         {{-- Anggaran --}}
         <li>
            <a href="{{ route('budgets.index') }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('budgets.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-pie-chart class="w-5 h-5 {{ request()->routeIs('budgets.*') ? 'text-white' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Anggaran</span>
            </a>
         </li>

         <li class="pt-8 pb-2 px-3">
            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Analitik</span>
         </li>
         {{-- Laporan Keuangan --}}
         <li>
            <a href="{{ route('reports.index') }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-file-bar-chart class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Laporan Keuangan</span>
            </a>
         </li>

         <li class="pt-8 pb-2 px-3">
            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Sistem</span>
         </li>
         <li>
            <a href="{{ route('profile.edit') }}" class="flex items-center p-3 rounded-xl group transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}">
               <x-lucide-user-circle class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-500' }}" />
               <span class="ms-3 text-sm font-bold tracking-tight">Profil</span>
            </a>
         </li>
      </ul>

      <div class="pt-6 mt-6 border-t border-slate-800/50">
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center p-3 text-slate-400 rounded-xl hover:bg-rose-600/10 hover:text-rose-400 transition-all duration-200 group">
               <x-lucide-log-out class="w-5 h-5 text-slate-500 group-hover:text-rose-400" />
               <span class="ms-3 text-sm font-bold tracking-tight">Logout Sistem</span>
            </button>
         </form>
      </div>
   </div>
</aside>
