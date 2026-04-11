@extends('layouts.app')

@section('header_title', 'Master Equipment')

@section('content')
    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-72">
            <input type="text" placeholder="Search master equipment..."
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white shadow-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-medium tracking-wider">ID</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Equipment Name</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Department</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Total Qty</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Borrowed</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Returned</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Available</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Condition</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Storage Loc.</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($materials as $material)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md">{{ $material->formatted_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $material->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ $material->department }}</span>
                        </td>
                        <td class="px-6 py-4 text-center font-medium">{{ $material->total_quantity }}</td>
                        <td class="px-6 py-4 text-center text-rose-600 font-medium">{{ $material->borrowed }}</td>
                        <td class="px-6 py-4 text-center text-emerald-600 font-medium">{{ $material->returned }}</td>
                        <td class="px-6 py-4 text-center text-indigo-600 font-bold bg-indigo-50/30">
                            {{ max(0, $material->total_quantity - $material->borrowed) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($material->condition === 'New')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 border border-blue-100">New</span>
                            @elseif($material->condition === 'Good')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">Good</span>
                            @else
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600 border border-rose-100">Damage</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $material->storage_location ?? '-' }}</td>
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
                            <p>No equipment found across all departments.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection