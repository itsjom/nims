@extends('layouts.app')

@section('header_title', 'HA Materials')

@section('content')
    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-72">
            <input type="text" placeholder="Search equipment..."
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all bg-white shadow-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <button onclick="document.getElementById('addHaModal').classList.remove('hidden')"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-md shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Equipment
        </button>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
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
                    <th class="px-6 py-4 font-medium tracking-wider">ID</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Equipment Name</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Department</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Quantity</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Condition</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Storage</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Used in Procedure</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-right">Added On</th>
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
                        <td class="px-6 py-4 text-center">
                            <span class="font-medium text-slate-700">{{ $material->total_quantity }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($material->condition == 'New')
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">New</span>
                            @elseif($material->condition == 'Good')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Good</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">Damage</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $material->storage_location ?? '-' }}</td>
                        <td class="px-6 py-4 text-slate-600 truncate max-w-xs">{{ $material->used_in_procedure ?? '-' }}</td>
                        <td class="px-6 py-4 text-right text-slate-400 text-xs">{{ $material->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <p>No equipment found. Click "Add Equipment" to get started.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="addHaModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Add New Equipment</h3>
                <button onclick="document.getElementById('addHaModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('ha-materials.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Equipment Name *</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Department *</label>
                        <select name="department" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                            <option value="" disabled selected>Select Department</option>
                            <option value="FNP">FNP</option>
                            <option value="HA">HA</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Quantity *</label>
                            <input type="number" name="total_quantity" required min="0" value="0"
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Condition *</label>
                            <select name="condition" required
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                <option value="New" selected>New</option>
                                <option value="Good">Good</option>
                                <option value="Damage">Damage</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Storage Location</label>
                        <input type="text" name="storage_location" placeholder="e.g. Cabinet A"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Used in Procedure</label>
                        <div class="max-h-32 overflow-y-auto bg-slate-50 border border-slate-200 rounded-xl p-2 space-y-1">
                            @forelse($procedures as $procedure)
                                <label
                                    class="flex items-center p-2 rounded-lg hover:bg-slate-100 cursor-pointer transition-colors group">
                                    <input type="checkbox" name="used_in_procedure[]" value="{{ $procedure->name }}"
                                        class="w-4 h-4 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer transition-colors">
                                    <span
                                        class="ml-3 text-sm font-medium text-slate-700 group-hover:text-indigo-700 transition-colors">{{ $procedure->name }}</span>
                                </label>
                            @empty
                                <p class="text-xs text-slate-400 p-2 italic">No procedures available.</p>
                            @endforelse
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Click any procedure to select it</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addHaModal').classList.add('hidden')"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all hover:-translate-y-0.5">Save
                        Equipment</button>
                </div>
            </form>
        </div>
    </div>
@endsection