@extends('layouts.app')

@section('header_title', 'Procedures')

@section('content')
    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-72">
            <input type="text" placeholder="Search procedures..."
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white shadow-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <button onclick="document.getElementById('addProcedureModal').classList.remove('hidden')"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-md shadow-green-200 transition-all hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Procedure
        </button>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50/50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-medium tracking-wider">Procedure ID</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Procedure Name</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Department</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-right">Added On</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($procedures as $procedure)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span
                                class="font-mono text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-md">{{ $procedure->formatted_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $procedure->name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ $procedure->department }}</span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-400 text-xs">{{ $procedure->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <p>No procedures found. Click "Add Procedure" to get started.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="addProcedureModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Add New Procedure</h3>
                <button onclick="document.getElementById('addProcedureModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('procedures.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Procedure Name *</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors"
                            placeholder="e.g. General Checkup">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Department *</label>
                        <select name="department" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                            <option value="" disabled selected>Select Department</option>
                            <option value="FNP">FNP</option>
                            <option value="HA">HA</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addProcedureModal').classList.add('hidden')"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 shadow-md shadow-green-200 transition-all hover:-translate-y-0.5">Save
                        Procedure</button>
                </div>
            </form>
        </div>
    </div>
@endsection
