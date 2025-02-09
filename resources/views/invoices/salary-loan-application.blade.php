<!DOCTYPE html>
<html lang="fil">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Application for Salary Loan</title>
    <style>
        /* PDF-Friendly Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            font-size: 16px;
            margin: 5px 0;
            font-weight: bold;
        }

        .form-title {
            text-align: center;
            font-weight: bold;
            margin: 25px 0;
            text-decoration: underline;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .form-row {
            display: flex;
            margin-bottom: 15px;
            gap: 20px;
        }

        .form-field {
            flex: 1;
            min-width: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-field {
            border-bottom: 1px solid #000;
            padding: 4px 0;
            width: 100%;
            display: block;
            min-height: 20px;
        }

        .checkbox-group {
            display: flex;
            gap: 25px;
            align-items: center;
            margin-top: 10px;
        }

        .terms {
            margin: 20px 0;
            font-size: 11px;
            text-align: justify;
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 45%;
            display: inline-block;
            margin-right: 5%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }

        .committee-members {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .committee-member {
            width: 30%;
            text-align: center;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 100px;
            text-align: center;
            padding: 0 5px;
        }

        .dynamic-value {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEÑARANDA EDUCATORS AND EMPLOYEES MULTI-PURPOSE COOPERATIVE</h1>
        <p>Poblacion I, Peñaranda, Nueva Ecija</p>
    </div>

    <div class="form-title">APPLICATION FOR SALARY LOAN</div>

    <!-- Personal Information Section -->
    <div class="section">
        <div class="form-row">
            <div class="form-field">
                <label>PANGALAN:</label>
                <span class="input-field">{{ $loan->borrower_name ?? 'KEVIN EVANISTO DEL ROSARIO' }}</span>
            </div>
            <div class="form-field">
                <label>PETSA:</label>
                <span class="input-field">{{ $loan->date_confirmed ?? '2023-07-03' }}</span>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>TIRAHAN:</label>
                <span class="input-field">{{ $loan->address ?? 'Poblacion I, Peñaranda, Nueva Ecija' }}</span>
            </div>
            <div class="form-field">
                <label>KONTAK:</label>
                <span class="input-field">{{ $loan->contact_number ?? '0912-345-6789' }}</span>
            </div>
        </div>
    </div>

    <!-- Loan Details Section -->
    <div class="section">
        <div class="form-row">
            <div class="form-field">
                <label>HALAGA NG INUTANG:</label>
                <span class="input-field dynamic-value">₱{{ number_format($loan->principal_amount ?? 200000, 2) }}</span>
            </div>
            <div class="form-field">
                <label>URI NG PAUTANG:</label>
                <div class="checkbox-group">
                    <span>☒ Salary Loan</span>
                    <span>☐ Appliance Loan</span>
                    <span>☐ Groceries Loan</span>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label>TAGAL NG PAGBABAYAD:</label>
                <div class="checkbox-group">
                    <span>☐ 1 Taon</span>
                    <span>☐ 2 Taon</span>
                    <span>☒ 3 Taon</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="section">
        <div class="terms">
            <p>
                INTERES: <span class="dynamic-value">{{ $loan->interest_rate ?? '7.5' }}%</span> bawat taon (Diminishing Balance)<br>
                PENALTY: <span class="dynamic-value">3%</span> buwanan sa natitirang prinsipal
            </p>
            
            <p>
                Nangangako akong magbabayad ng buwanang hulog na <span class="dynamic-value">₱{{ number_format($loan->monthly_payment ?? 6221.24, 2) }}</span> 
                simula <span class="dynamic-value">25 Agosto 2023</span> hanggang 
                <span class="dynamic-value">25 Agosto 2026</span>.
            </p>

            <p>
                Sumasang-ayon akong ang aking Capital Build-Up (CBU) na <span class="dynamic-value">₱{{ number_format($loan->cbu ?? 50000, 2) }}</span> 
                ay magsisilbing collateral sa pautang na ito.
            </p>
        </div>
    </div>

    <!-- Signatures Section -->
    <div class="section signature-section">
        <div class="form-row">
            <div class="signature-box">
                <p>Lagda ng Humiram</p>
                <div class="signature-line"></div>
                <p>Petsa: ___________________</p>
            </div>

            <div class="signature-box">
                <p>Lagda ng Tagapagsangla</p>
                <div class="signature-line"></div>
                <p>Petsa: ___________________</p>
            </div>
        </div>

        <div class="committee-members">
            <div class="committee-member">
                <p>JOSEFINA P. LADIA</p>
                <div class="signature-line"></div>
                <p>Pangulo, Lupon ng Pautang</p>
            </div>
            <div class="committee-member">
                <p>RACHELLE A. YAN</p>
                <div class="signature-line"></div>
                <p>Kalihim</p>
            </div>
            <div class="committee-member">
                <p>MAY ZEN C. GREGORIO</p>
                <div class="signature-line"></div>
                <p>Taga-pagtaya</p>
            </div>
        </div>
    </div>
</body>
</html>