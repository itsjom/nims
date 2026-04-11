<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Borrow Equipment - NIMS</title>
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

    <div class="max-w-xl w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 p-8">

        <div class="text-center mb-8">
            <div
                class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg shadow-indigo-200 mb-4">
                N</div>
            <h1 class="text-3xl font-bold text-slate-800">Borrow Equipment</h1>
            <p class="text-sm text-slate-500 mt-2">Please fill out the form accurately to borrow items.</p>
        </div>

        @if(session('success'))
            <div
                class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 font-medium border border-emerald-100 flex items-center">
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
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Student Name</label>
                <input type="text" name="student_name" required placeholder="Juan Dela Cruz"
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Contact Info (CP No. / Email)</label>
                <input type="text" name="contact_info" required placeholder="09123456789 or juan@mail.com"
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Clinical Instructor</label>
                <input type="text" name="clinical_instructor" required placeholder="Instructor Name"
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Procedure</label>
                <select name="procedure" required
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all bg-white">
                    <option value="" disabled selected>Select Procedure</option>
                    @foreach($procedures as $p)
                        <option value="{{ $p->name }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Equipment</label>
                <!-- We pass both type and id by a composite value or use javascript. 
                     An easier way is to just merge in Controller or use JS. 
                     Let's use a selected item that encodes both type and id: "FNP_1" -->
                <select name="equipment_composite" id="equipment_select" required
                    class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all bg-white mb-2">
                    <option value="" disabled selected>Select Equipment</option>
                    <optgroup label="FNP Materials">
                        @foreach($fnpMaterials as $fnp)
                            @php $availableFnp = max(0, $fnp->total_quantity - $fnp->borrowed); @endphp
                            <option value="FNP_{{ $fnp->fnp_id }}" {{ $availableFnp <= 0 ? 'disabled' : '' }}
                                class="{{ $availableFnp <= 0 ? 'text-slate-300' : '' }}">
                                FNP - {{ $fnp->name }} (Available: {{ $availableFnp }})
                            </option>
                        @endforeach
                    </optgroup>
                    <optgroup label="HA Materials">
                        @foreach($haMaterials as $ha)
                            @php $availableHa = max(0, $ha->total_quantity - $ha->borrowed); @endphp
                            <option value="HA_{{ $ha->ha_id }}" {{ $availableHa <= 0 ? 'disabled' : '' }}
                                class="{{ $availableHa <= 0 ? 'text-slate-300' : '' }}">
                                HA - {{ $ha->name }} (Available: {{ $availableHa }})
                            </option>
                        @endforeach
                    </optgroup>
                </select>
                <!-- Hidden inputs to submit to standard controller methods -->
                <input type="hidden" name="equipment_type" id="equipment_type">
                <input type="hidden" name="equipment_id" id="equipment_id">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" required min="1" value="1"
                        class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Expected Return Date</label>
                    <input type="date" name="expected_returned_date" required
                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
                        class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all bg-white">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <input type="text" name="status" value="Borrowed" readonly
                    class="w-full px-4 py-2 bg-indigo-50 text-indigo-700 font-medium border border-indigo-100 cursor-not-allowed rounded-xl text-sm transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:-translate-y-0.5 transition-all duration-200">
                    Submit Borrow Request
                </button>
            </div>
        </form>

    </div>

    <script>
        document.getElementById('equipment_select').addEventListener('change', function () {
            var val = this.value;
            if (val) {
                var parts = val.split('_');
                document.getElementById('equipment_type').value = parts[0];
                document.getElementById('equipment_id').value = parts[1];
            }
        });
    </script>
</body>

</html>