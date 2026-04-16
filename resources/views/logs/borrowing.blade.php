@extends('layouts.app')

@section('header_title', 'Borrowing Logs')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="relative w-80">
        <input type="text" placeholder="Search borrow records..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all bg-white shadow-sm">
        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-x-auto">
    <table class="w-full min-w-max text-left text-sm whitespace-nowrap">
        <thead class="bg-slate-50 text-slate-500 border-b border-slate-100">
            <tr>
                <th class="px-5 py-4 font-medium tracking-wider">Borrow ID</th>
                <th class="px-5 py-4 font-medium tracking-wider">Date Borrowed</th>
                <th class="px-5 py-4 font-medium tracking-wider">Student Name</th>
                <th class="px-5 py-4 font-medium tracking-wider">Clinical Instructor</th>
                <th class="px-5 py-4 font-medium tracking-wider">Procedure</th>
                <th class="px-5 py-4 font-medium tracking-wider">Equipment</th>
                <th class="px-5 py-4 font-medium tracking-wider text-center">Qty</th>
                <th class="px-5 py-4 font-medium tracking-wider">Expected Return</th>
                <th class="px-5 py-4 font-medium tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($logs as $log)
            <tr class="hover:bg-slate-50/80 transition-colors group">
                <td class="px-5 py-4">
                    <span class="font-mono text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md border border-amber-200">{{ $log->formatted_id }}</span>
                </td>
                <td class="px-5 py-4 text-slate-600">
                    {{ $log->date_borrowed ? $log->date_borrowed->format('M d, Y') : '-' }}
                </td>
                <td class="px-5 py-4 font-semibold text-slate-800">{{ $log->student_name }}</td>
                <td class="px-5 py-4 text-slate-600">{{ $log->clinical_instructor }}</td>
                <td class="px-5 py-4 text-slate-600">{{ $log->procedure }}</td>
                <td class="px-5 py-4 font-medium text-green-700">{{ $log->equipment }}</td>
                <td class="px-5 py-4 text-center font-bold text-slate-700">{{ $log->quantity }}</td>
                <td class="px-5 py-4 text-slate-600 font-medium">
                    {{ $log->expected_returned_date ? $log->expected_returned_date->format('M d, Y') : '-' }}
                </td>
                <td class="px-5 py-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                        {{ $log->status === 'Pending' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $log->status === 'Returned' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $log->status === 'Overdue' ? 'bg-rose-100 text-rose-700' : '' }}
                        {{ !in_array($log->status, ['Pending', 'Returned', 'Overdue']) ? 'bg-slate-100 text-slate-600' : '' }}
                    ">
                        {{ $log->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                    <svg class="w-16 h-16 mx-auto text-slate-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-lg font-medium text-slate-600 mb-1">No borrowing logs found.</p>
                    <p class="text-sm">Records will appear here automatically when items are borrowed via QR.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
