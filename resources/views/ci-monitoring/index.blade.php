@extends('layouts.app')

@section('header_title', 'CI Monitoring')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl">
        <ul class="list-disc pl-5 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="flex flex-col lg:flex-row gap-8">
    
    <!-- Add CI Form -->
    <div class="w-full lg:w-1/3">
        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Clinical Instructor
            </h3>
            <form action="{{ route('ci-monitoring.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Instructor Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-slate-50 focus:bg-white" placeholder="e.g. John Doe">
                </div>
                <button type="submit" class="w-full py-2.5 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors shadow-sm shadow-green-600/20">
                    Add Instructor
                </button>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="w-full lg:w-2/3">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-slate-50/50 text-slate-500">
                    <tr>
                        <th class="px-6 py-4 font-medium tracking-wider">Clinical Instructor</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-center">Total Borrowed</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-center">Total Returned</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-center">Missing</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-center">Damaged</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-center">Overdue</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($monitoringData as $data)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-800">{{ $data->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-center font-medium">{{ $data->total_borrowed }}</td>
                            <td class="px-6 py-4 text-center text-green-600 font-medium">{{ $data->total_returned }}</td>
                            <td class="px-6 py-4 text-center text-rose-600 font-medium">{{ $data->missing_equipment }}</td>
                            <td class="px-6 py-4 text-center text-rose-600 font-medium">{{ $data->damaged_equipment }}</td>
                            <td class="px-6 py-4 text-center font-medium {{ $data->overdue_items > 0 ? 'text-amber-500' : 'text-slate-400' }}">{{ $data->overdue_items }}</td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('ci-monitoring.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this Clinical Instructor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition-colors" title="Remove Instructor">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                <p>No Clinical Instructors added yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
