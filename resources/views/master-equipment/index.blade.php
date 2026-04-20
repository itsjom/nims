@extends('layouts.app')

@section('header_title', 'Master Equipment')

    @section('content')

    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-6 w-full gap-4">
        <div class="relative w-72 flex-shrink-0">
            <input type="text" id="searchInput" placeholder="Search master equipment..."
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white shadow-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        
        <a href="{{ route('master-equipment.print') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors shadow-sm text-sm font-medium whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Print Master Equipment
        </a>
    </div>

    <!-- Data Table -->
    <div id="printableTable" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-medium tracking-wider">ID</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Equipment Name</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Total Qty</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Borrowed</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Returned</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Available</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Condition</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Storage Loc.</th>
                </tr>
            </thead>
            <tbody id="dataTable" class="divide-y divide-slate-100">
                @forelse($materials as $material)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-md">{{ $material->item_code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $material->item_name }}</p>
                        </td>
                        <td class="px-6 py-4 text-center font-medium">{{ $material->total_stock }}</td>
                        <td class="px-6 py-4 text-center text-rose-600 font-medium">{{ max(0, $material->total_stock - $material->supply_on_hand) }}</td>
                        <td class="px-6 py-4 text-center text-green-600 font-medium">-</td>
                        <td class="px-6 py-4 text-center text-green-600 font-bold bg-green-50/30">
                            {{ max(0, $material->supply_on_hand) }}
                        </td>
                        <td class="px-6 py-4">
                            @if(in_array($material->item_condition, ['New', 'Good', 'Good Condition']))
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600 border border-green-100">Good</span>
                            @elseif(in_array($material->item_condition, ['Fair', 'Fair Condition']))
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">Fair</span>
                            @else
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600 border border-rose-100">{{ $material->item_condition ?? 'Damage' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $material->location ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <p>No equipment found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#dataTable tr.group'); // Only the data rows

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const filter = searchInput.value.toLowerCase();

                    tableRows.forEach(row => {
                        const text = row.textContent || row.innerText;
                        if (text.toLowerCase().indexOf(filter) > -1) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>

@endsection
