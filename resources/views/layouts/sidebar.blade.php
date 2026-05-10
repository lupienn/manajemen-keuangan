<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{ request()->routeIs('dashboard') ? 'bg-gray-100' : '' }}">
               <x-lucide-layout-dashboard class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-corporate dark:group-hover:text-white" />
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         
         <li class="pt-4 pb-2">
            <span class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Manajemen</span>
         </li>

         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <x-lucide-arrow-down-circle class="w-5 h-5 text-income transition duration-75 group-hover:text-income" />
               <span class="flex-1 ms-3 whitespace-nowrap">Pemasukan</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <x-lucide-arrow-up-circle class="w-5 h-5 text-expense transition duration-75 group-hover:text-expense" />
               <span class="flex-1 ms-3 whitespace-nowrap">Pengeluaran</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <x-lucide-pie-chart class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-corporate dark:group-hover:text-white" />
               <span class="flex-1 ms-3 whitespace-nowrap">Anggaran</span>
            </a>
         </li>

         <li class="pt-4 pb-2">
            <span class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Laporan</span>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <x-lucide-file-text class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-corporate dark:group-hover:text-white" />
               <span class="flex-1 ms-3 whitespace-nowrap">Laporan Keuangan</span>
            </a>
         </li>
         <li>
            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <x-lucide-history class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-corporate dark:group-hover:text-white" />
               <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Audit</span>
            </a>
         </li>
      </ul>
   </div>
</aside>
