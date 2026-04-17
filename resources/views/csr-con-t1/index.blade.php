@extends('layouts.app')

@section('header_title', 'CSR-CON Materials')

@section('content')
    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-6">
        <div class="relative w-72">
            <input type="text" id="searchInput" placeholder="Search equipment..."
                class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all bg-white shadow-sm">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <button onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-md shadow-green-200 transition-all hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Item
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
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap min-w-max">
            <thead class="bg-slate-50/50 text-slate-500">
                <tr>
                    <th class="px-6 py-4 font-medium tracking-wider">Image</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Item Code</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Item Name</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Unit</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Ideal Stocks</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Total Stock</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-center">Supply On Hand</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Location</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Dates</th>
                    <th class="px-6 py-4 font-medium tracking-wider">Condition</th>
                    <th class="px-6 py-4 font-medium tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="dataTable" class="divide-y divide-slate-100">
                @forelse($items as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="Item image"
                                    class="w-12 h-12 rounded object-cover border border-slate-200 cursor-pointer hover:opacity-75 transition-opacity"
                                    onclick="previewImage('{{ asset('storage/' . $item->image) }}')">
                            @else
                                <div class="w-12 h-12 bg-slate-100 rounded flex items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span
                                onclick="openDetailsModalCon('{{ $item->item_code }}', '{{ addslashes($item->item_name) }}', '{{ $item->unit }}', '{{ $item->ideal_stocks }}', '{{ $item->total_stock }}', '{{ $item->supply_on_hand }}', '{{ $item->location }}', '{{ $item->expiration_date ?? 'N/A' }}', '{{ $item->last_restock_date ?? 'N/A' }}', '{{ $item->item_condition }}')"
                                class="font-mono text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-md cursor-pointer hover:bg-green-100 transition-colors">{{ $item->item_code }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $item->item_name }}</p>
                        </td>
                        <td class="px-6 py-4"><span class="text-slate-600">{{ $item->unit }}</span></td>
                        <td class="px-6 py-4 text-center"><span
                                class="font-medium text-slate-700">{{ $item->ideal_stocks }}</span></td>
                        <td class="px-6 py-4 text-center"><span
                                class="font-medium text-slate-700">{{ $item->total_stock }}</span></td>
                        <td class="px-6 py-4 text-center"><span
                                class="font-medium text-slate-700">{{ $item->supply_on_hand }}</span></td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $item->location }}</td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-slate-500">Exp: <span
                                    class="font-medium {{ $item->expiration_date ? 'text-amber-600' : 'text-slate-400' }}">{{ $item->expiration_date ?? 'N/A' }}</span>
                            </p>
                            <p class="text-xs text-slate-500">Restock: <span
                                    class="font-medium text-slate-600">{{ $item->last_restock_date ?? 'N/A' }}</span></p>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->item_condition == 'New')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">New</span>
                            @elseif($item->item_condition == 'Good')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Good</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-700">Damage</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button
                                    onclick="openEditModalCon({{ $item->id }}, '{{ addslashes($item->item_name) }}', '{{ $item->unit }}', '{{ $item->ideal_stocks }}', '{{ $item->total_stock }}', '{{ $item->supply_on_hand }}', '{{ $item->location }}', '{{ $item->item_condition }}', '{{ $item->expiration_date }}', '{{ $item->last_restock_date }}')"
                                    class="p-1.5 text-slate-400 hover:text-green-600 transition-colors bg-white hover:bg-green-50 rounded-lg border border-slate-200 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <form action="{{ route('csr-con-t1.destroy', $item->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors bg-white hover:bg-rose-50 rounded-lg border border-slate-200 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="px-6 py-8 text-center text-slate-400">
                            <svg class="w-12 h-12 mx-auto text-slate-200 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p>No items found. Click "Add Item" to get started.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Item Details Modal -->
    <div id="detailsModalCon"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden my-8">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Item Details</h3>
                <button onclick="document.getElementById('detailsModalCon').classList.add('hidden')"
                    class="text-slate-400 hover:text-green-500 transition-colors bg-white hover:bg-green-50 rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Item
                            Code</span>
                        <span id="detail_code"
                            class="font-mono font-medium text-slate-800 bg-slate-50 px-2 py-1 rounded-md border border-slate-100"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Unit</span>
                        <span id="detail_unit" class="text-slate-800 font-medium"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Item
                            Name</span>
                        <span id="detail_name" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Ideal
                            Stocks</span>
                        <span id="detail_ideal" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Total
                            Stock</span>
                        <span id="detail_total" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Supply On
                            Hand</span>
                        <span id="detail_onhand" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span
                            class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Condition</span>
                        <span id="detail_condition" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Expiration
                            Date</span>
                        <span id="detail_exp" class="text-slate-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Last Restock
                            Date</span>
                        <span id="detail_restock" class="text-slate-800 font-medium"></span>
                    </div>
                    <div class="col-span-2">
                        <span
                            class="block text-slate-500 mb-1 text-xs uppercase tracking-wider font-semibold">Location</span>
                        <span id="detail_location" class="text-slate-800 font-medium"></span>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                <button onclick="document.getElementById('detailsModalCon').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">Close</button>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300"
        onclick="closePreviewImage()">
        <div class="relative max-w-4xl mx-auto p-4" onclick="event.stopPropagation()">
            <button onclick="closePreviewImage()"
                class="absolute -top-12 right-0 text-white hover:text-slate-200 transition-colors p-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImageSrc" src="" class="max-h-[85vh] object-contain rounded-xl shadow-2xl bg-white">
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-xl overflow-hidden my-8">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Edit CSR-CON-T1 Item</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Item Name *</label>
                        <input type="text" name="item_name" id="edit_item_name" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Unit *</label>
                        <select name="unit" id="edit_unit" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer">
                            <option value="pc">pc</option>
                            <option value="pcs">pcs</option>
                            <option value="set">set</option>
                            <option value="box">box</option>
                            <option value="pairs">pairs</option>
                            <option value="unit">unit</option>
                            <option value="pack">pack</option>
                            <option value="sachet">sachet</option>
                            <option value="bottle">bottle</option>
                            <option value="vial">vial</option>
                            <option value="tablet">tablet</option>
                            <option value="gallon">gallon</option>
                            <option value="bag">bag</option>
                            <option value="tray">tray</option>
                            <option value="capsule">capsule</option>
                            <option value="1cc">1cc</option>
                            <option value="5cc">5cc</option>
                            <option value="3cc">3cc</option>
                            <option value="10cc">10cc</option>
                            <option value="roll">roll</option>
                            <option value="ampule">ampule</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Location *</label>
                        <select name="location" id="edit_location" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer">
                            <option value="CSR CABINET 1A">CSR CABINET 1A</option>
                            <option value="CSR CABINET 2A">CSR CABINET 2A</option>
                            <option value="CSR CABINET 2B">CSR CABINET 2B</option>
                            <option value="CSR CABINET 3A">CSR CABINET 3A</option>
                            <option value="CSR CABINET 3B">CSR CABINET 3B</option>
                            <option value="CSR CABINET 4A">CSR CABINET 4A</option>
                            <option value="CSR CABINET 4B">CSR CABINET 4B</option>
                            <option value="CSR CABINET 5A">CSR CABINET 5A</option>
                            <option value="CSR CABINET 5B">CSR CABINET 5B</option>
                            <option value="CSR CABINET 6A">CSR CABINET 6A</option>
                            <option value="CSR CABINET 6B">CSR CABINET 6B</option>
                            <option value="CSR CABINET 7">CSR CABINET 7</option>
                            <option value="CSR CABINET 8">CSR CABINET 8</option>
                            <option value="CSR CABINET 9">CSR CABINET 9</option>
                            <option value="CSR CABINET 10">CSR CABINET 10</option>
                            <option value="CSR CABINET 11">CSR CABINET 11</option>
                            <option value="CSR CABINET 12">CSR CABINET 12</option>
                            <option value="CSR CABINET RW">CSR CABINET RW</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ideal Stocks *</label>
                        <input type="number" name="ideal_stocks" id="edit_ideal_stocks" required min="0"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Stock *</label>
                        <input type="number" name="total_stock" id="edit_total_stock" required min="0"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Supply On Hand *</label>
                        <input type="number" name="supply_on_hand" id="edit_supply_on_hand" required min="0"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Condition *</label>
                        <select name="item_condition" id="edit_condition_select" required
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer"
                            onchange="if(this.value=='Others') { this.name=''; document.getElementById('edit_condition_other').name='item_condition'; document.getElementById('edit_condition_other').classList.remove('hidden'); document.getElementById('edit_condition_other').required=true; } else { this.name='item_condition'; document.getElementById('edit_condition_other').name=''; document.getElementById('edit_condition_other').classList.add('hidden'); document.getElementById('edit_condition_other').required=false; }">
                            <option value="New">New</option>
                            <option value="Good">Good</option>
                            <option value="Damage">Damage</option>
                            <option value="Others">Others (Please specify)</option>
                        </select>
                        <input type="text" id="edit_condition_other" placeholder="Specify condition"
                            class="mt-2 hidden w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Expiration Date</label>
                        <input type="date" name="expiration_date" id="edit_expiration_date"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Last Restock Date</label>
                        <input type="date" name="last_restock_date" id="edit_last_restock_date"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Image <span
                                class="text-xs text-slate-400 font-normal">(Leave blank to keep current)</span></label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 shadow-md shadow-green-200 transition-all hover:-translate-y-0.5">Update
                        Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal"
        class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center transition-all duration-300">
        <div class="relative w-full max-w-xl bg-white rounded-2xl shadow-xl overflow-hidden my-8">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Add New CSR-CON-T1 Item</h3>
                <button onclick="document.getElementById('addModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-rose-500 transition-colors bg-white hover:bg-rose-50 rounded-full p-1.5 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('csr-con-t1.store') }}" method="POST" enctype="multipart/form-data" class="p-6"
                id="addFormCon">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Item Name *</label>
                        <input type="text" name="item_name" required
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Unit *</label>
                        <select name="unit" required
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer">
                            <option value="" disabled selected>Select Unit</option>
                            <option value="pc">pc</option>
                            <option value="pcs">pcs</option>
                            <option value="set">set</option>
                            <option value="box">box</option>
                            <option value="pairs">pairs</option>
                            <option value="unit">unit</option>
                            <option value="pack">pack</option>
                            <option value="sachet">sachet</option>
                            <option value="bottle">bottle</option>
                            <option value="vial">vial</option>
                            <option value="tablet">tablet</option>
                            <option value="gallon">gallon</option>
                            <option value="bag">bag</option>
                            <option value="tray">tray</option>
                            <option value="capsule">capsule</option>
                            <option value="1cc">1cc</option>
                            <option value="5cc">5cc</option>
                            <option value="3cc">3cc</option>
                            <option value="10cc">10cc</option>
                            <option value="roll">roll</option>
                            <option value="ampule">ampule</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Location *</label>
                        <select name="location" required
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer">
                            <option value="" disabled selected>Select Location</option>
                            <option value="CSR CABINET 1A">CSR CABINET 1A</option>
                            <option value="CSR CABINET 2A">CSR CABINET 2A</option>
                            <option value="CSR CABINET 2B">CSR CABINET 2B</option>
                            <option value="CSR CABINET 3A">CSR CABINET 3A</option>
                            <option value="CSR CABINET 3B">CSR CABINET 3B</option>
                            <option value="CSR CABINET 4A">CSR CABINET 4A</option>
                            <option value="CSR CABINET 4B">CSR CABINET 4B</option>
                            <option value="CSR CABINET 5A">CSR CABINET 5A</option>
                            <option value="CSR CABINET 5B">CSR CABINET 5B</option>
                            <option value="CSR CABINET 6A">CSR CABINET 6A</option>
                            <option value="CSR CABINET 6B">CSR CABINET 6B</option>
                            <option value="CSR CABINET 7">CSR CABINET 7</option>
                            <option value="CSR CABINET 8">CSR CABINET 8</option>
                            <option value="CSR CABINET 9">CSR CABINET 9</option>
                            <option value="CSR CABINET 10">CSR CABINET 10</option>
                            <option value="CSR CABINET 11">CSR CABINET 11</option>
                            <option value="CSR CABINET 12">CSR CABINET 12</option>
                            <option value="CSR CABINET RW">CSR CABINET RW</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ideal Stocks *</label>
                        <input type="number" name="ideal_stocks" required min="0" value="0"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Total Stock *</label>
                        <input type="number" name="total_stock" required min="0" value="0"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Supply On Hand *</label>
                        <input type="number" name="supply_on_hand" required min="0" value="0"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Condition *</label>
                        <select name="item_condition" required id="conditionSelectCon"
                            onchange="if(this.value=='Others') { this.name=''; document.getElementById('conditionOtherCon').name='item_condition'; document.getElementById('conditionOtherCon').classList.remove('hidden'); document.getElementById('conditionOtherCon').required=true; } else { this.name='item_condition'; document.getElementById('conditionOtherCon').name=''; document.getElementById('conditionOtherCon').classList.add('hidden'); document.getElementById('conditionOtherCon').required=false; }"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors cursor-pointer">
                            <option value="New" selected>New</option>
                            <option value="Good">Good</option>
                            <option value="Damage">Damage</option>
                            <option value="Others">Others (Please specify)</option>
                        </select>
                        <input type="text" id="conditionOtherCon" placeholder="Specify condition"
                            class="mt-2 w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors hidden">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Expiration Date</label>
                        <input type="date" name="expiration_date"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Last Restock Date</label>
                        <input type="date" name="last_restock_date"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Image</label>
                        <input type="file" name="image" accept="image/*"
                            class="seq-input-con w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')"
                        class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 shadow-md shadow-green-200 transition-all hover:-translate-y-0.5">Save
                        Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#dataTable tr.group');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
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

        const form = document.getElementById('addFormCon');
        if (!form) return;

        const elements = Array.from(form.querySelectorAll('.seq-input-con'));

        elements.forEach((el, index) => {
            if (index > 0) el.disabled = true;

            const enableNext = () => {
                if (el.value.trim() !== '') {
                    if (index + 1 < elements.length) {
                        elements[index + 1].disabled = false;
                    }
                } else {
                    for (let i = index + 1; i < elements.length; i++) {
                        elements[i].disabled = true;
                    }
                }
            };

            el.addEventListener('input', enableNext);
            el.addEventListener('change', enableNext);
        });
    });

    function previewImage(src) {
        document.getElementById('previewImageSrc').src = src;
        document.getElementById('imagePreviewModal').classList.remove('hidden');
    }

    function closePreviewImage() {
        document.getElementById('imagePreviewModal').classList.add('hidden');
        document.getElementById('previewImageSrc').src = '';
    }

    function openEditModalCon(id, name, unit, ideal, total, on_hand, location, condition, exp, restock) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        // Setup action route
        form.action = `/csr-con-t1/${id}`;

        // Populate inputs
        document.getElementById('edit_item_name').value = name;
        document.getElementById('edit_unit').value = unit;
        document.getElementById('edit_ideal_stocks').value = ideal;
        document.getElementById('edit_total_stock').value = total;
        document.getElementById('edit_supply_on_hand').value = on_hand;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_expiration_date').value = exp || '';
        document.getElementById('edit_last_restock_date').value = restock || '';

        const condSelect = document.getElementById('edit_condition_select');
        const condOther = document.getElementById('edit_condition_other');

        // Check if condition is basic or other
        let isBasic = false;
        Array.from(condSelect.options).forEach(opt => {
            if (opt.value === condition && condition !== 'Others') isBasic = true;
        });

        if (isBasic) {
            condSelect.value = condition;
            condSelect.name = 'item_condition';
            condOther.name = '';
            condOther.classList.add('hidden');
            condOther.required = false;
        } else {
            condSelect.value = 'Others';
            condSelect.name = '';
            condOther.name = 'item_condition';
            condOther.value = condition;
            condOther.classList.remove('hidden');
            condOther.required = true;
        }

        modal.classList.remove('hidden');
    }
    function openDetailsModalCon(code, name, unit, ideal, total, on_hand, location, exp, restock, condition) {
        document.getElementById('detail_code').textContent = code;
        document.getElementById('detail_name').textContent = name;
        document.getElementById('detail_unit').textContent = unit;
        document.getElementById('detail_ideal').textContent = ideal;
        document.getElementById('detail_total').textContent = total;
        document.getElementById('detail_onhand').textContent = on_hand;
        document.getElementById('detail_exp').textContent = exp;
        document.getElementById('detail_restock').textContent = restock;
        document.getElementById('detail_location').textContent = location;
        document.getElementById('detail_condition').textContent = condition;

        document.getElementById('detailsModalCon').classList.remove('hidden');
    }
</script>