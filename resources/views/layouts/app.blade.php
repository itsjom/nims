<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MIIS - Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f3f4f6; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 4px; }
        
        @media print {
            aside, header { display: none !important; }
            .print\:hidden { display: none !important; }
            body, .flex, main, .flex-1, .flex-col { 
                height: auto !important; 
                min-height: 0 !important;
                overflow: visible !important; 
                display: block !important; 
                background: white !important;
            }
            .max-w-7xl { max-width: none !important; margin: 0 !important; }
            .p-8 { padding: 0 !important; }
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="antialiased text-slate-800">
    <div class="flex h-screen overflow-hidden bg-slate-50 print:block print:h-auto print:overflow-visible print:bg-white">
        <aside class="w-72 bg-white border-r border-slate-200 flex flex-col transition-all duration-300 z-20 shadow-sm relative print:hidden">
            <div class="h-20 flex items-center px-8 border-b border-slate-100">
                <img src="{{ asset('images/ncf-logo.png') }}" alt="NCF Logo" class="w-12 h-12 object-contain drop-shadow-sm">
                <span class="ml-4 text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-slate-800">MIIS</span>
            </div>
            <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 space-y-1.5">
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-4 inline-block">Overview</p>
                <a href="/" class="flex items-center px-4 py-3 {{ request()->is('/') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-200 group relative">
                    @if(request()->is('/'))
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-green-600 rounded-r-full"></div>
                    @endif
                    <svg class="w-5 h-5 mr-3 {{ request()->is('/') ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <div class="space-y-1">
                    @php 
                        $isInventory = request()->routeIs('master-equipment.*') || request()->routeIs('csr-ncon-t1.*') || request()->routeIs('csr-con-t1.*'); 
                    @endphp
                    <button id="inventory-btn" class="w-full flex items-center justify-between px-4 py-3 {{ $isInventory ? 'text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-300 group">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 {{ $isInventory ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            Inventory
                        </div>
                        <svg id="inventory-icon" class="w-4 h-4 {{ $isInventory ? 'text-green-600 rotate-180' : 'text-slate-400' }} transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="inventory-submenu" class="pl-11 pr-4 space-y-1 overflow-hidden transition-all duration-300 {{ $isInventory ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                        <div class="py-1">
                            <a href="{{ route('master-equipment.index') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('master-equipment.*') ? 'text-green-700 bg-green-50' : 'text-slate-500 hover:text-green-600' }} rounded-lg transition-colors">Master Equipment</a>
                            <a href="{{ route('csr-ncon-t1.index') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('csr-ncon-t1.*') ? 'text-green-700 bg-green-50' : 'text-slate-500 hover:text-green-600' }} rounded-lg transition-colors">CSR-NCON</a>
                            <a href="{{ route('csr-con-t1.index') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('csr-con-t1.*') ? 'text-green-700 bg-green-50' : 'text-slate-500 hover:text-green-600' }} rounded-lg transition-colors">CSR-CON</a>
                        </div>
                    </div>
                </div>

                <!-- Logs Menu -->
                <div class="space-y-1 mt-2">
                    @php 
                        $isLogs = request()->routeIs('logs.*'); 
                    @endphp
                    <button id="logs-btn" class="w-full flex items-center justify-between px-4 py-3 {{ $isLogs ? 'text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-300 group">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 {{ $isLogs ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4h4m-4-8a8 8 0 110 16 8 8 0 010-16z"></path></svg>
                            Logs
                        </div>
                        <svg id="logs-icon" class="w-4 h-4 {{ $isLogs ? 'text-green-600 rotate-180' : 'text-slate-400' }} transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="logs-submenu" class="pl-11 pr-4 space-y-1 overflow-hidden transition-all duration-300 {{ $isLogs ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}">
                        <div class="py-1">
                            <a href="{{ route('logs.borrowing') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('logs.borrowing') ? 'text-green-700 bg-green-50' : 'text-slate-500 hover:text-green-600' }} rounded-lg transition-colors">Borrowing Log</a>
                            <a href="{{ route('logs.returned') }}" class="block px-3 py-2 text-sm font-medium {{ request()->routeIs('logs.returned') ? 'text-green-700 bg-green-50' : 'text-slate-500 hover:text-green-600' }} rounded-lg transition-colors">Return Log</a>
                        </div>
                    </div>
                </div>
                
                <!-- CI Monitoring Menu -->
                <a href="{{ route('ci-monitoring.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('ci-monitoring.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-200 group relative mt-2">
                    @if(request()->routeIs('ci-monitoring.*'))
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-green-600 rounded-r-full"></div>
                    @endif
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('ci-monitoring.*') ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    CI Monitoring
                </a>

                <!-- Administration Menu -->
                @role('System Admin')
                <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 mt-6 inline-block">Administration</p>
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('users.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-200 group relative mb-1">
                    @if(request()->routeIs('users.*'))
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-green-600 rounded-r-full"></div>
                    @endif
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('users.*') ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    User Management
                </a>
                <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('roles.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600' }} rounded-xl font-medium transition-all duration-200 group relative">
                    @if(request()->routeIs('roles.*'))
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-green-600 rounded-r-full"></div>
                    @endif
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('roles.*') ? 'text-green-600' : 'text-slate-400 group-hover:text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                    Roles & Permissions
                </a>
                @endrole
            </nav>
            <div class="p-6 border-t border-slate-100">
                <div class="flex items-center gap-3 w-full group">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin User') }}&background=16a34a&color=fff" alt="User Avatar" class="w-10 h-10 rounded-full shadow-sm group-hover:ring-2 ring-green-200 transition-all">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@MIIS.com' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col relative overflow-hidden print:overflow-visible">
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-8 z-10 sticky top-0 print:hidden">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold text-slate-800 leading-tight">@yield('header_title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center space-x-6">
                    <button class="relative p-2 text-slate-400 hover:text-green-600 transition-colors rounded-full hover:bg-green-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full"></span>
                    </button>
                </div>
            </header>
            
            <div class="flex-1 overflow-auto p-8 bg-slate-50/50 print:overflow-visible print:p-0 print:bg-white">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const invBtn = document.getElementById("inventory-btn");
            const invMenu = document.getElementById("inventory-submenu");
            const invIcon = document.getElementById("inventory-icon");

            invBtn.addEventListener("click", () => {
                const isExpanded = invMenu.classList.contains("max-h-96");
                if (isExpanded) {
                    invMenu.classList.remove("max-h-96", "opacity-100");
                    invMenu.classList.add("max-h-0", "opacity-0");
                    invIcon.classList.remove("rotate-180");
                } else {
                    invMenu.classList.remove("max-h-0", "opacity-0");
                    invMenu.classList.add("max-h-96", "opacity-100");
                    invIcon.classList.add("rotate-180");
                }
            });

            // Logs Menu Toggle
            const logsBtn = document.getElementById("logs-btn");
            const logsMenu = document.getElementById("logs-submenu");
            const logsIcon = document.getElementById("logs-icon");

            logsBtn.addEventListener("click", () => {
                const isExpanded = logsMenu.classList.contains("max-h-96");
                if (isExpanded) {
                    logsMenu.classList.remove("max-h-96", "opacity-100");
                    logsMenu.classList.add("max-h-0", "opacity-0");
                    logsIcon.classList.remove("rotate-180");
                } else {
                    logsMenu.classList.remove("max-h-0", "opacity-0");
                    logsMenu.classList.add("max-h-96", "opacity-100");
                    logsIcon.classList.add("rotate-180");
                }
            });
        });
    </script>
</body>
</html>
