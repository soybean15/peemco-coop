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
        <div class="title">STATEMENT OF ACCOUNT</div>
        <div class="details">
            <div>
                <div>Name of Borrower: <span class="bold">{{$loan->user->name}}</span></div>
                <div>Loan Account No: <span class="bold">{{$loan->loan_application_no }}</span></div>
                <div>Date Granted: <span class="bold">{{ \Carbon\Carbon::parse($loan->date_confirmed)->format('M d, Y') }}</span></div>
            </div>
            <div>
                <div>Amount of Loan: <span class="bold">P{{number_format($loan->principal_amount, 2) }}</span></div>
                <div>Interest Rate: <span class="bold">{{$loan->monthly_interest_rate}}</span></div>
                {{-- <div>Maturity Date: 8/25/2024</div> --}}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Month</th>
                <th>Amortization</th>
                <th>Penalty</th>
                {{-- <th>Interest</th> --}}
                {{-- <th>GBT</th> --}}

                <th>Deferred Date of Payment</th>
                <th>Paid Amortization</th>
                <th>Unpaid Amortization</th>
                <th>Total Penalty and Charges</th>
            </tr>
        </thead>
        <tbody>
            <!-- Repeat this block for each payment entry -->

           @foreach ($loan->items as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->due_date)->format('M d, Y') }}</td>
                <td class="text-right">P{{ number_format($item->amount_due, 2) }}</td>

                <td class="text-right">P{{ number_format($item->penalty, 2) }}</td>
                {{-- <td>{{$item->interest}}</td> --}}
                {{-- <td></td> --}}
                <td>{{ $item->payments?->last()->date ?? '' }}</td>
                <td class="text-right">P{{ number_format($item->payments?->sum('amount_paid') ?? 0, 2) }}</td>
                <td class="text-right">P{{ number_format($item->payments?->last()?->amount_paid ?? $item->amount_due, 2) }}</td>
                <td class="text-right">P{{ number_format($item->penalty, 2) }}</td>
            </tr>
            @endforeach

            <!-- Add all other payment rows here following the same pattern -->
        </tbody>
    </table>
    <table class="total-table">
        @php
            // Calculate totals from loan items
            $totalPrincipal = $loan->principal_amount;
            $totalInterest = $loan->items->sum('interest');
            $totalPenalty = $loan->items->sum('penalty');
            $totalPayments = $loan->items->flatMap(function ($item) {
                return $item->payments ?? [];
            })->sum('amount_paid');

            $totalAmountPayable = $totalPrincipal + $totalInterest + $totalPenalty;
            $totalDue = $totalAmountPayable - $totalPayments;
        @endphp

        <tr>
            <td class="bold">Total</td>
            <td class="text-right bold">P{{ number_format($totalPrincipal + $totalInterest, 2) }}</td>
        </tr>
        <tr>
            <td>Principal</td>
            <td class="text-right">P{{ number_format($totalPrincipal, 2) }}</td>
        </tr>
        <tr>
            <td>Interest</td>
            <td class="text-right">P{{ number_format($totalInterest, 2) }}</td>
        </tr>
        <tr>
            <td>Penalty and Charges</td>
            <td class="text-right">P{{ number_format($totalPenalty, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">Total Amounts Payable</td>
            <td class="text-right bold">P{{ number_format($totalAmountPayable, 2) }}</td>
        </tr>
        <tr>
            <td>Less Payments</td>
            <td class="text-right">P{{ number_format($totalPayments, 2) }}</td>
        </tr>
        <tr>
            <td class="bold">Total Due</td>
            <td class="text-right bold">P{{ number_format($totalDue, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <div>Generated on: {{ \Carbon\Carbon::now()->format('M d, Y') }}</div>
    </div>
</body>
</html>
