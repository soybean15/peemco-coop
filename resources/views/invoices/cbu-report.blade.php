<!DOCTYPE html>
<html>
<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Loan Statement</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { margin-bottom: 30px; }
        .title { font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 20px; }
        .details { display: flex; justify-content: space-between; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-table { width: 50%; float: right; margin-top: 20px; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .footer { margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Capital Build Up (CBU)</div>
        <div class="details">
            <div>
                <div>Name of Member: <span class="bold">{{$user->name}}</span></div>
            
                <div>Total Capital Build up: <span class="bold">P{{number_format($user->capitalBuildUp()->sum('amount_received'), 2) }}</span></div>

            </div>
       
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Or Cdv</th>
                <th>Date</th>
                <th>Amount</th>
              
            </tr>
        </thead>
        <tbody>
            <!-- Repeat this block for each payment entry -->

           @foreach ($user->capitalBuildup as $item)
            <tr>
                <td>{{$item->or_cdv }}</td>
                <td class="text-right">{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</td>

                <td class="text-right">P{{ number_format($item->amount_received, 2) }}</td>
               
              
            </tr>
            @endforeach

            <!-- Add all other payment rows here following the same pattern -->
        </tbody>
    </table>
 

    <div class="footer">
        <div>Generated on: {{ \Carbon\Carbon::now()->format('M d, Y') }}</div>
    </div>
</body>
</html>
