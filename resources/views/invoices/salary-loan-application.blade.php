<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Loan Contract Agreement</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 1.5cm; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px; }
        .parties { margin: 30px 0; display: flex; justify-content: space-between; }
        .section { margin: 25px 0; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        .signature-block { margin-top: 50px; display: flex; justify-content: space-around; }
        .footer { margin-top: 50px; font-size: 12px; color: #666; }
        .important-note { background: #f8f8f8; padding: 15px; margin: 20px 0; border-left: 4px solid #cc0000; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LOAN CONTRACT AGREEMENT</h1>
        <p>This Agreement made this {{ \Carbon\Carbon::parse($loan->created_at)->format('jS day of F, Y') }}</p>
    </div>

    <div class="parties">

        <div style="width: 45%;">
            <h3>BORROWER:</h3>
            <p>{{ $loan->user->name }}<br>
            Address{{ $loan->user->profile->address }}<br>
            Contact:{{ $loan->user->profile->contact_number }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">1. RECITALS</div>
        <p>This Loan Contract Agreement ("Agreement") sets forth the terms and conditions under which the Lender agrees to lend and the Borrower agrees to repay the Loan Amount as specified below.</p>
    </div>

    <div class="section">
        <div class="section-title">2. LOAN DETAILS</div>
        <table>
            <tr>
                <th>Principal Loan Amount</th>
                <td>{{ number_format($loan->principal_amount, 2) }} (PHP)</td>
            </tr>
            <tr>
                <th>Annual Interest Rate</th>
                <td>{{ $loan->monthly_interest_rate * 12 }}% ({{ $loan->monthly_interest_rate }}% monthly)</td>
            </tr>
            <tr>
                <th>Loan Term</th>
                <td>{{ $loan->term_months }} months</td>
            </tr>
            <tr>
                <th>Repayment Schedule</th>
                <td>Monthly amortization payments</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">3. TERMS & CONDITIONS</div>

        <h4>3.1 Payment Obligations</h4>
        <p>The Borrower agrees to repay the Loan Amount with interest through {{ $loan->term_months }} equal monthly installments of {{ number_format($loan->monthly_payment, 2) }} PHP, beginning on {{ \Carbon\Carbon::parse($loan->date_confirmed)->addMonth()->format('F j, Y') }}.</p>

        <h4>3.2 Late Payment Penalties</h4>
        <p>Late payments shall incur a penalty of {{ $loan->penalty_rate }}% per day on the overdue amount until paid in full.</p>

        <h4>3.3 Prepayment</h4>
        <p>The Borrower may prepay the loan in whole or in part at any time without penalty.</p>

        <div class="important-note">
            <strong>Important:</strong> Failure to make three consecutive payments constitutes default,
            at which point the entire outstanding balance becomes immediately due and payable.
        </div>
    </div>

    <div class="section">
        <div class="section-title">4. REPAYMENT SCHEDULE</div>
        <table>
            <thead>
                <tr>
                    <th>Due Date</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Total Payment</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loan->items as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->due_date)->format('M j, Y') }}</td>
                    <td>{{ number_format($item->principal, 2) }}</td>
                    <td>{{ number_format($item->interest, 2) }}</td>
                    <td>{{ number_format($item->amount_due, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">5. SECURITY & COLLATERAL</div>
        <p>[Description of collateral if applicable]</p>
        <p>The Borrower agrees that the Lender may pursue all available legal remedies in case of default,
        including but not limited to seizure of collateral and legal action.</p>
    </div>

    <div class="signature-block">
        <div>
            <p>_________________________<br>
            <strong>Borrower's Signature</strong><br>
            {{ $loan->user->name }}<br>
            Date: ___________________</p>
        </div>
        <div>
            <p>_________________________<br>
            <strong>Authorized Representative</strong><br>
            [Your Company Name]<br>
            Date: ___________________</p>
        </div>
    </div>

    <div class="footer">
        <p>This document constitutes the entire agreement between the parties.
        Any amendments must be made in writing and signed by both parties.</p>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('M j, Y \a\t H:i') }}</p>
    </div>
</body>
</html>
