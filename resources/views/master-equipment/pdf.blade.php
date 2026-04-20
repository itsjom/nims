<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Master Equipment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
        }

        .header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #059669;
        }

        .header h2 {
            margin: 5px 0 0;
            font-size: 16px;
            color: #1f2937;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #4b5563;
        }

        .text-center {
            text-align: center;
        }

        .item-code {
            font-family: monospace;
            font-weight: bold;
            color: #059669;
        }

        .text-red {
            color: #e11d48;
        }

        .text-green {
            color: #059669;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-good {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-fair {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .badge-damage {
            background-color: #ffe4e6;
            color: #9f1239;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ public_path('images/ncf-logo.png') }}" alt="NCF Logo">
        <h1>Medical Inventory Information System</h1>
        <h2>Master Equipment List</h2>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipment Name</th>
                <th class="text-center">Total Qty</th>
                <th class="text-center">Borrowed</th>
                <th class="text-center">Returned</th>
                <th class="text-center">Available</th>
                <th>Condition</th>
                <th>Storage Loc.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr>
                    <td><span class="item-code">{{ $material->item_code }}</span></td>
                    <td><strong>{{ $material->item_name }}</strong></td>
                    <td class="text-center">{{ $material->total_stock }}</td>
                    <td class="text-center text-red">{{ max(0, $material->total_stock - $material->supply_on_hand) }}</td>
                    <td class="text-center text-green">-</td>
                    <td class="text-center text-green"><strong>{{ max(0, $material->supply_on_hand) }}</strong></td>
                    <td>
                        @if(in_array($material->item_condition, ['New', 'Good', 'Good Condition']))
                            <span class="badge badge-good">Good</span>
                        @elseif(in_array($material->item_condition, ['Fair', 'Fair Condition']))
                            <span class="badge badge-fair">Fair</span>
                        @else
                            <span class="badge badge-damage">{{ $material->item_condition ?? 'Damage' }}</span>
                        @endif
                    </td>
                    <td>{{ $material->location ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>MIIS - Medical Inventory Information System</p>
    </div>

</body>

</html>