<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8C6A5D;
            --primary-dark: #6D4C41;
            --black: #1A1A1A;
            --gray: #666666;
            --light-gray: #F5F5F5;
            --border: #E0E0E0;
        }
        body {
            font-family: 'Lato', sans-serif;
            color: var(--black);
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 40px;
            font-size: 15px;
            line-height: 1.6;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 50px;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 30px;
        }
        .header-left h1 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-dark);
            margin: 0 0 10px 0;
            font-size: 2.5rem;
        }
        .header-left p { margin: 0; color: var(--gray); font-size: 0.9rem; }
        .header-right { text-align: right; }
        .header-right h2 {
            font-family: 'Playfair Display', serif;
            color: var(--black);
            margin: 0 0 5px 0;
            font-size: 1.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            background: var(--light-gray);
            padding: 25px;
            border-radius: 12px;
        }
        .info-col h3 {
            font-family: 'Playfair Display', serif;
            margin: 0 0 10px 0;
            font-size: 1.1rem;
            color: var(--primary-dark);
        }
        .info-col p { margin: 0; font-size: 0.95rem; }
        table.items {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background: var(--primary);
            color: #fff;
            padding: 15px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        table.items td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
        }
        table.items tr:last-child td { border-bottom: none; }
        .totals {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-bottom: 50px;
        }
        .totals table {
            width: 300px;
            border-collapse: collapse;
        }
        .totals td { padding: 10px 15px; border-bottom: 1px solid var(--border); }
        .totals tr:last-child td { border-bottom: none; font-weight: 700; font-size: 1.2rem; color: var(--primary-dark); border-top: 2px solid var(--primary); }
        .footer {
            text-align: center;
            color: var(--gray);
            font-size: 0.85rem;
            border-top: 1px solid var(--border);
            padding-top: 20px;
        }
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px 20px;
            background: var(--primary);
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-family: 'Lato', sans-serif;
            transition: 0.2s;
        }
        .print-btn:hover { background: var(--primary-dark); }
        
        @media print {
            .print-btn { display: none !important; }
            body { background: #fff; }
            .invoice-box { padding: 0; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>

    <div class="invoice-box">
        <div class="header">
            <div class="header-left">
                <h1>Dianca Atelier</h1>
                <p>{{ \App\Models\Setting::get('butik_address', 'Jl. Contoh Alamat No. 123, Kota') }}</p>
                <p>WA: {{ \App\Models\Setting::get('butik_wa', '6281234567890') }} | Email: {{ \App\Models\Setting::get('butik_email', 'hello@diancaatelier.com') }}</p>
            </div>
            <div class="header-right">
                <h2>INVOICE</h2>
                <p><strong>No:</strong> {{ $order->order_number }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
                <p><strong>Status:</strong> <span style="text-transform:uppercase;">{{ $order->status }}</span></p>
            </div>
        </div>

        <div class="info-section">
            <div class="info-col">
                <h3>Tagihan Kepada:</h3>
                <p><strong>{{ $order->customer_name }}</strong></p>
                <p>{{ $order->customer_phone }}</p>
                @if($order->customer_email) <p>{{ $order->customer_email }}</p> @endif
                @if($order->customer_address) <p>{{ $order->customer_address }}</p> @endif
            </div>
            <div class="info-col" style="text-align:right;">
                <h3>Informasi Pesanan:</h3>
                <p><strong>Metode Pemesanan:</strong> WhatsApp</p>
                @if($order->fitting_date)
                    <p><strong>Jadwal Fitting:</strong> {{ \Carbon\Carbon::parse($order->fitting_date)->format('d/m/Y H:i') }}</p>
                @endif
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Deskripsi Item</th>
                    <th style="text-align:center;">Size</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Harga Satuan</th>
                    <th style="text-align:right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $order->product_name }}</strong><br>
                        <span style="font-size:0.85rem;color:var(--gray);">{{ $order->notes ?? '-' }}</span>
                    </td>
                    <td style="text-align:center;">{{ $order->size }}</td>
                    <td style="text-align:center;">{{ $order->quantity }}</td>
                    <td style="text-align:right;">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</td>
                    <td style="text-align:right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align:right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Biaya Pengiriman</td>
                    <td style="text-align:right;">(Dihitung terpisah via WA)</td>
                </tr>
                <tr>
                    <td><strong>Total Tagihan</strong></td>
                    <td style="text-align:right;"><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p style="font-family:'Playfair Display', serif; font-size:1.2rem; font-style:italic; color:var(--primary); margin-bottom:5px;">Terima kasih telah berbelanja di Dianca Atelier</p>
            <p>Invoice ini sah dan digenerate otomatis oleh sistem.</p>
        </div>
    </div>
</body>
</html>
