<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Borrow Equipment - MIIS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>

<body class="antialiased text-slate-800 min-h-screen py-10 px-4 flex justify-center items-start">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 p-8 relative">

        <div class="absolute top-4 right-4 z-20">
            <a href="{{ route('dashboard') }}"
                class="p-2 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-full transition-colors flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </a>
        </div>
        <div class="text-center mb-8">
            <img src="{{ asset('images/ncf-logo.png') }}" alt="NCF Logo"
                class="w-16 h-16 mx-auto object-contain drop-shadow-sm mb-4">
            <h1 class="text-3xl font-bold text-slate-800">Borrow Equipment</h1>
            <p class="text-sm text-slate-500 mt-2">Please fill out the form accurately to borrow items.</p>
        </div>

        @if(session('success'))
            <div
                class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-medium border border-green-100 flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 text-rose-700 p-4 rounded-xl mb-6 font-medium border border-rose-100">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/borrow-equipment" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Borrower ID</label>
                    <input type="text" value="(Auto Generated)" disabled
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-400 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Date Borrowed</label>
                    <input type="date" name="date_borrowed" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        readonly
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Student Name</label>
                <input type="text" name="student_name" required placeholder="Juan Dela Cruz"
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contact Info (CP No. / Email)</label>
                <input type="text" name="contact_info" required placeholder="09123456789 or juan@mail.com"
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Clinical Instructor</label>
                <select name="clinical_instructor" required
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all bg-white">
                    <option value="" disabled selected>Select Instructor</option>
                    @foreach($clinicalInstructors as $ci)
                        <option value="{{ $ci->name }}">{{ $ci->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Equipment Details</h3>
                    <button type="button" id="add_item_btn" class="text-xs font-semibold text-green-600 hover:text-green-700 bg-green-100 hover:bg-green-200 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Item
                    </button>
                </div>

                <div id="items_container" class="space-y-4">
                    <div class="item-row relative bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-slate-500 mb-1">Equipment</label>
                                <select name="items[0][equipment_composite]" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all bg-slate-50 hover:bg-white cursor-pointer">
                                    <option value="" disabled selected>Select Equipment...</option>
                                    <optgroup label="CSR-NCON Materials">
                                        @foreach($nconMaterials as $ncon)
                                            @php $availableNcon = $ncon->supply_on_hand; @endphp
                                            <option value="NCON_{{ $ncon->id }}" {{ $availableNcon <= 0 ? 'disabled' : '' }}
                                                class="{{ $availableNcon <= 0 ? 'text-slate-300' : '' }}">
                                                {{ $ncon->item_name }} (Available: {{ $availableNcon }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="CSR-CON Materials">
                                        @foreach($conMaterials as $con)
                                            @php $availableCon = $con->supply_on_hand; @endphp
                                            <option value="CON_{{ $con->id }}" {{ $availableCon <= 0 ? 'disabled' : '' }}
                                                class="{{ $availableCon <= 0 ? 'text-slate-300' : '' }}">
                                                {{ $con->item_name }} (Available: {{ $availableCon }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Quantity</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="items[0][quantity]" required min="1" value="1"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all bg-slate-50 focus:bg-white">
                                    <button type="button" class="remove-item-btn text-rose-400 hover:text-rose-600 p-2 opacity-0 cursor-default" disabled title="Remove Item">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Expected Return Date</label>
                    <input type="date" name="expected_returned_date" required
                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <input type="text" name="status" value="Borrowed" readonly
                        class="w-full px-4 py-2 bg-green-50 text-green-700 font-medium border border-green-100 cursor-not-allowed rounded-xl text-sm transition-all focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg shadow-green-200 hover:-translate-y-0.5 transition-all duration-200 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Submit Borrow Request
                </button>
            </div>
        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1;
            const container = document.getElementById('items_container');
            const addBtn = document.getElementById('add_item_btn');

            addBtn.addEventListener('click', function() {
                // Get the first row to clone
                const firstRow = container.querySelector('.item-row');
                const newRow = firstRow.cloneNode(true);

                // Update names
                const select = newRow.querySelector('select');
                select.name = `items[${itemIndex}][equipment_composite]`;
                select.value = '';

                const input = newRow.querySelector('input[type="number"]');
                input.name = `items[${itemIndex}][quantity]`;
                input.value = '1';

                // Enable and style remove button
                const removeBtn = newRow.querySelector('.remove-item-btn');
                removeBtn.disabled = false;
                removeBtn.classList.remove('opacity-0', 'cursor-default');
                removeBtn.classList.add('cursor-pointer');
                
                removeBtn.addEventListener('click', function() {
                    newRow.remove();
                });

                container.appendChild(newRow);
                itemIndex++;
            });
        });
    </script>
</body>
</html>