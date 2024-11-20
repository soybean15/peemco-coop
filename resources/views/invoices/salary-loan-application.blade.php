<!DOCTYPE html>
<html lang="fil">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application for Salary Loan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.2;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            margin: 0;
        }
        .form-title {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }
        .form-row {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }
        .form-field {
            flex: 1;
        }
        label {
            display: inline;
            margin-right: 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 120px);
            border-bottom: 1px solid #000;
            border-top: none;
            border-left: none;
            border-right: none;
        }
        .checkbox-group {
            display: flex;
            gap: 10px;
        }
        .terms {
            margin: 10px 0;
            font-size: 12px;
        }
        .signatures {
            margin-top: 20px;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 20px;
            width: 45%;
            display: inline-block;
        }
        .committee {
            margin-top: 20px;
        }
        .committee-members {
            display: flex;
            justify-content: space-between;
        }
        .committee-member {
            width: 30%;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEÑARANDA EDUCATORS AND EMPLOYEES MULTI-PURPOSE COOPERATIVE</h1>
        <p>Poblacion I, Peñaranda, Nueva Ecija</p>
    </div>

    <div class="form-title">APPLICATION FOR SALARY LOAN</div>

    <form>
        <div class="form-row">
            <div class="form-field">
                <label for="pangalan">PANGALAN:</label>
                <input type="text" id="pangalan" name="pangalan">
            </div>
            <div class="form-field">
                <label for="petsa">PETSA:</label>
                <input type="text" id="petsa" name="petsa">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="tirahan">TIRAHAN:</label>
                <input type="text" id="tirahan" name="tirahan">
            </div>
            <div class="form-field">
                <label for="contact">TEL NO./CELL NO.:</label>
                <input type="text" id="contact" name="contact">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="halaga">HALAGA NG INUTANG: P</label>
                <input type="number" id="halaga" name="halaga">
            </div>
            <div class="form-field">
                <label>TYPE OF LOAN:</label>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="loan_type" value="appliance"> Appliance</label>
                    <label><input type="checkbox" name="loan_type" value="salary"> Salary</label>
                    <label><input type="checkbox" name="loan_type" value="groceries"> Groceries</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <label>TAGAL NG PAGBABAYAD:</label>
            <div class="checkbox-group">
                <label><input type="checkbox" name="term" value="isang_taon"> ISANG TAON</label>
                <label><input type="checkbox" name="term" value="dalawang_taon"> DALAWANG TAON</label>
                <label><input type="checkbox" name="term" value="tatlong_taon"> TATLONG TAON</label>
                <label><input type="checkbox" name="term" value="iba_pa"> IBA PA:</label>
                <input type="text" name="iba_pa_specify" style="width: 100px;">
            </div>
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="kasalukuyang_puhunang">KASALUKUYANG PUHUNANG (CAPITAL):</label>
                <input type="text" id="kasalukuyang_puhunang" name="kasalukuyang_puhunang">
            </div>
            <div class="form-field">
                <label for="kasalukuyang_utang">KASALUKUYANG UTANG P:</label>
                <input type="text" id="kasalukuyang_utang" name="kasalukuyang_utang">
            </div>
        </div>

        <div class="form-title">KATIBAYAN NG PAGKAKAUTANG AT PANGAKO SA PAGBABAYAD</div>

        <div class="terms">
            <p>HALAGA NG UTANG/INUTANG:</p>
            <p>PHP: _____________ Monthly Due: _____________ Petsa: _____________</p>
            <p>Interest: _____ Diminishing per annum; Penalty 3% per month on principal due or 36% per annum on principal due.</p>
            <p>Dahilan at alang-alang sa halagang aking tinanggap/tatanggapin ayon sa tadkang nakalahat dito, ay nangangako ako na aking babayaran ang PEEMCO o sa utos/atas nito ang nasabing halaga na ang aabutin ay ________________ at ito'y babayaran tuwing kada-buwan</p>
            <p>ng bawat taon na magsisimula sa ika- ____ ng _____________ at ganun ding halaga, tuwing kada-buwan ng bawat taon pagkaraan ng unang hulog hanggang sa ang buong pagkakautang kasama ang napagkasunduang pakinabang o tubo na ____________ (_____%) kada taon batay sa nababawasang balance (diminishing balance) na babayaran naman ng buwanan ay akingmabayaran ng buha kasama ang penalty.</p>
            <p>Ang aking pangako sa katibayan ng pangako na rin na magbabayad ng pagkakautang ay ang aking Saping Puhunan (CBU) na nakalahad sa P______________.</p>
            <p>Sa sandaling ang alinsong bulog ay hindi ko mabayaran ayon sa kasunduan sa itaas nito, ang saping puhunan, iba pang mga deposito at anumang benepisyo na matatanggap kaugnay ng pagiging kasapi ay masasaing ibabwas sa utang sa kapasyahan ng kooperatiba.</p>
        </div>

        <div class="terms">
            <p>NALALAMAN KO NA ANG PAGKAKAUTANG NA ITO AY NASASAKOP/HINDI NASASAKOP (WITH WAIVER) NG LOAN PROTECTION PLAN KAHIT ITO AY SINASAGOT NG AKING CAPITAL SHARE.</p>
            <p>NABASA KO AT NAINTINDIHAN ANG LAHAT NG NASASAAD SA KASULATAN ITO AT WALANG SINUMANG PUMILIT O TUMAKOT SA AKIN UPANG LAGDAAN ANG KATIBAYAN NG PAGKAKAUTANG AT PANGAKO SA PAGBABAYAD.</p>
        </div>

        <div class="signatures">
            <div class="signature-line">
                <p>Pangalan at Lagda ng Humiram</p>
            </div>
            <div class="signature-line" style="float: right;">
                <p>Tirahan</p>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-line">
                <p>Pangalan at Lagda ng Ka-ako (co-maker)</p>
            </div>
            <div class="signature-line" style="float: right;">
                <p>Tirahan</p>
            </div>
        </div>

        <div class="signatures">
            <div class="signature-line">
                <p>Pangalan at Lagda ng Ka-ako (co-maker)</p>
            </div>
            <div class="signature-line" style="float: right;">
                <p>Tirahan</p>
            </div>
        </div>

        <div class="committee">
            <p>Credit Committee:</p>
            <div class="committee-members">
                <div class="committee-member">
                    <div class="signature-line">JOSEFINA P. LADIA</div>
                </div>
                <div class="committee-member">
                    <div class="signature-line">RACHELLE KAREN R. ROQUE</div>
                </div>
                <div class="committee-member">
                    <div class="signature-line">WILLY F. PERMISON</div>
                </div>
            </div>
        </div>

        <div class="form-title">KAPAHINTULUTAN</div>

        <div class="terms">
            <p>Sa pamamagitan nito, binibyan ko ng pahintulot ang mga-ayaman ng Kooperatiba na kunin ang aking mga pangakong saping rosso, tubo at aking kinukuning panggot bilang pambayad sa aking himiram na puhunang kasama ang natupok na interest kung hindi ako makabayad sa aking himiram na puhunang kasama.</p>
            <p>At pinahihintulutan din ang Kahera ng PNHS (Disbursing Officer) na bawasan sa aking buwanang sweldo ang karampatang hulog sa aking pagkakautang sa PEEMCO sa halagang _____________.</p>
        </div>
        <div class="signatures" style="margin-top: 30px;">
            <div class="signature-line">
                <p>Pangalan at Lagda</p>
            </div>
        </div>
    </form>
</body>
</html>
