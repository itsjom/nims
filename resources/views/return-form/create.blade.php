<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Return Equipment - MIIS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f3f4f6;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 20px 20px;
        }
    </style>
</head>

<body class="antialiased text-slate-800 min-h-screen py-10 px-4 flex justify-center items-start">

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 p-8 relative">

        <!-- Decorative blur background -->
        <div
            class="absolute -top-24 -right-24 w-48 h-48 bg-green-100 rounded-full blur-3xl opacity-50 pointer-events-none">
        </div>
        <div
            class="absolute -bottom-24 -left-24 w-48 h-48 bg-slate-100 rounded-full blur-3xl opacity-50 pointer-events-none">
        </div>

        <div class="absolute top-4 right-4 z-20">
            <a href="{{ route('dashboard') }}"
                class="p-2 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-full transition-colors flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </a>
        </div>

        <div class="text-center mb-8 relative z-10">
            <img src="{{ asset('images/ncf-logo.png') }}" alt="NCF Logo"
                class="w-16 h-16 mx-auto object-contain drop-shadow-sm mb-4 bg-white rounded-full p-1 shadow-sm">
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Return Equipment</h1>
            <p class="text-sm text-slate-500 mt-2">Please fill out the form accurately to return borrowed items.</p>
        </div>

        @if(session('success'))
            <div
                class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 font-medium border border-green-200 flex items-center shadow-sm relative z-10">
                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div
                class="bg-rose-50 text-rose-700 p-4 rounded-xl mb-6 font-medium border border-rose-200 shadow-sm relative z-10">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Please check the errors below:</span>
                </div>
                <ul class="list-disc list-inside text-sm pl-7 text-rose-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('return.store') }}" method="POST" class="space-y-5 relative z-10">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Borrow Record <span
                            class="text-rose-500">*</span></label>
                    <select name="borrow_id" required id="borrow_id_select"
                        class="w-full px-4 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer">
                        <option value="" disabled selected>Select active borrow log</option>
                        @foreach($borrowLogs as $log)
                            <option value="{{ $log->borrow_id }}" data-equipment="{{ $log->equipment }}">
                                {{ $log->formatted_id }} - {{ $log->equipment }} (Qty: {{ $log->quantity }}, by
                                {{ $log->student_name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Date Returned</label>
                    <input type="date" name="date_returned" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        readonly
                        class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed">
                </div>
            </div>

            <div class="bg-green-50/50 p-4 rounded-xl border border-green-100/50 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Equipment Name <span
                            class="text-rose-500">*</span></label>
                    <select name="equipment_composite" id="equipment_select" required
                        class="w-full px-4 py-2.5 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer shadow-sm pointer-events-none bg-slate-50">
                        <option value="" disabled selected>Auto-selected based on Borrow Record</option>
                        <optgroup label="CSR-NCON Materials">
                            @foreach($nconMaterials as $ncon)
                                <option value="NCON_{{ $ncon->id }}">
                                    {{ $ncon->item_name }} (Code: {{ $ncon->item_code }})
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="CSR-CON Materials">
                            @foreach($conMaterials as $con)
                                <option value="CON_{{ $con->id }}">
                                    {{ $con->item_name }} (Code: {{ $con->item_code }})
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <!-- Hidden inputs to submit to standard controller methods -->
                    <input type="hidden" name="equipment_type" id="equipment_type">
                    <input type="hidden" name="equipment_id" id="equipment_id">
                    <p class="text-xs text-slate-500 mt-1.5 ml-1 tracking-wide">Must match the borrowed equipment to
                        properly restore stock.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Quantity Returned <span
                                class="text-rose-500">*</span></label>
                        <input type="number" name="quantity_returned" required min="1" value="1"
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Condition Details <span
                                class="text-rose-500">*</span></label>
                        <select name="condition" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all cursor-pointer shadow-sm">
                            <option value="Good" selected>Good / Intact</option>
                            <option value="Damaged">Damaged / Broken</option>
                            <option value="Fair">Fair / With Wear</option>
                            <option value="Missing Parts">Missing Parts</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Received By <span
                        class="text-rose-500">*</span></label>
                <select name="received_by" required
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 transition-all shadow-sm cursor-pointer">
                    <option value="" disabled selected>Select Instructor</option>
                    @foreach($clinicalInstructors as $ci)
                        <option value="{{ $ci->name }}">{{ $ci->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3.5 px-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl shadow-[0_4px_14px_0_rgba(22,163,74,0.39)] hover:shadow-[0_6px_20px_rgba(22,163,74,0.23)] hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Confirm Return
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('dashboard') }}"
                    class="text-xs font-medium text-slate-400 hover:text-slate-600 transition-colors">Return to
                    Dashboard</a>
            </div>
        </form>

    </div>

    <script>
        document.getElementById('borrow_id_select').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            var equipmentName = selectedOption.getAttribute('data-equipment');

            var eqSelect = document.getElementById('equipment_select');
            var options = eqSelect.options;

            let found = false;
            for (var i = 0; i < options.length; i++) {
                if (options[i].value === "") continue;

                if (options[i].text.includes(equipmentName)) {
                    options[i].style.display = 'block';
                    options[i].disabled = false;
                    options[i].hidden = false;
                    eqSelect.selectedIndex = i;
                    var parts = options[i].value.split('_');
                    document.getElementById('equipment_type').value = parts[0];
                    document.getElementById('equipment_id').value = parts[1];
                    found = true;
                } else {
                    options[i].style.display = 'none';
                    options[i].disabled = true;
                    options[i].hidden = true;
                }
            }

            if (!found) {
                eqSelect.selectedIndex = 0;
            }
        });
    </script>
</body>

</html>