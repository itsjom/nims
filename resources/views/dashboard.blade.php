@extends('layouts.app')

@section('header_title', 'Inventory Overview')

@section('content')
<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    
    <!-- 1. Total Equipments -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalEquipments) }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-1 mt-1">Total Equipments</p>
                </div>
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-xl shadow-inner shadow-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-xs">
                <span class="text-indigo-600 font-medium">FNP & HA Total</span>
            </div>
        </div>
    </div>

    <!-- 2. Total Borrowed -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalBorrowed) }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-1 mt-1">Total Borrowed</p>
                </div>
                <div class="p-3 bg-amber-100 text-amber-600 rounded-xl shadow-inner shadow-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-xs">
                <span class="text-amber-600 font-medium">Active loans</span>
            </div>
        </div>
    </div>

    <!-- 3. Total Returned -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($totalReturned) }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-1 mt-1">Total Returned</p>
                </div>
                <div class="p-3 bg-emerald-100 text-emerald-600 rounded-xl shadow-inner shadow-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-xs">
                <span class="text-emerald-600 font-medium">Successfully returned</span>
            </div>
        </div>
    </div>

    <!-- 4. Missing Items -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($missingItems) }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-1 mt-1">Missing Items</p>
                </div>
                <div class="p-3 bg-purple-100 text-purple-600 rounded-xl shadow-inner shadow-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-xs">
                <span class="text-purple-600 font-medium">> 2 Days Overdue</span>
            </div>
        </div>
    </div>

    <!-- 5. Damaged Items -->
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:-translate-y-1 transition-transform duration-300 relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-rose-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ number_format($damagedItems) }}</h3>
                    <p class="text-sm font-medium text-slate-500 mb-1 mt-1">Damaged Items</p>
                </div>
                <div class="p-3 bg-rose-100 text-rose-600 rounded-xl shadow-inner shadow-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="flex items-center text-xs">
                <span class="text-rose-600 font-medium">Requires repair</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & QR Code -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm col-span-1 lg:col-span-1 flex flex-col items-center text-center">
        <h3 class="text-xl font-bold text-slate-800 mb-2">Borrow Equipment</h3>
        <p class="text-sm text-slate-500 mb-6 max-w-xs">Scan the QR code below using your mobile device to easily fill up the borrowing form.</p>
        
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6 inline-block" id="print-qrcode">
            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->style('round')->generate(rtrim(config('app.url'), '/') . '/borrow-equipment') !!}
        </div>
        
        <div class="flex gap-3 w-full">
            <a href="{{ route('borrow.create') }}" class="flex-1 py-2.5 px-4 bg-slate-50 hover:bg-slate-100 text-slate-600 font-medium rounded-xl border border-slate-200 transition-all text-sm">
                Open Link
            </a>
            <button onclick="printQr()" class="flex-1 py-2.5 px-4 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-medium rounded-xl border border-indigo-100 transition-all flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print QR
            </button>
        </div>
    </div>
</div>

<script>
    function printQr() {
        var printContents = document.getElementById('print-qrcode').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; font-family: sans-serif;">' +
            '<h1 style="margin-bottom: 2rem;">Scan to Borrow Equipment</h1>' +
            printContents + 
            '</div>';

        window.print();

        document.body.innerHTML = originalContents;
        window.location.reload(); // Reload to restore event listeners
    }
</script>

@endsection
