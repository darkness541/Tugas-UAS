<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Mutasi Stok</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 2px 0;
            font-size: 14px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 12px;
        }
        .data-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .footer-table {
            width: 100%;
            text-align: center;
        }
        .signature-space {
            height: 80px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0d6efd; color: white; border: none; cursor: pointer; border-radius: 5px; font-weight: bold;">
            🖨️ Cetak Dokumen / Simpan PDF
        </button>
    </div>

    <div class="header">
        <h1>SISTEM MANAJEMEN INVENTARIS</h1>
        <p>Gudang Pusat Operasional - PT Contoh Perusahaan Tbk.</p>
        <p>Jl. Contoh Jalan Raya No. 123, Kota Contoh, Telp: (021) 1234567</p>
    </div>

    <div class="info-section">
        <h3 style="text-align: center; margin-bottom: 15px;">LAPORAN MUTASI STOK BARANG</h3>
        <table class="info-table">
            <tr>
                <td width="15%"><strong>Periode</strong></td>
                <td width="2%">:</td>
                <td>{{ $startDate }} s.d. {{ $endDate }}</td>
                
                <td width="15%"><strong>Dicetak Oleh</strong></td>
                <td width="2%">:</td>
                <td>{{ $printedBy }}</td>
            </tr>
            <tr>
                <td><strong>Filter Jenis</strong></td>
                <td>:</td>
                <td>
                    @if($selectedType == 'in') Masuk (Inbound)
                    @elseif($selectedType == 'out') Keluar (Outbound)
                    @else Semua Transaksi
                    @endif
                </td>
                
                <td><strong>Waktu Cetak</strong></td>
                <td>:</td>
                <td>{{ $printedAt }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Waktu</th>
                <th width="15%">No. Referensi</th>
                <th width="30%">Nama Barang (SKU)</th>
                <th width="10%">Tipe</th>
                <th width="10%">Qty</th>
                <th width="15%">User ID</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $t)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($t->transaction_date)->format('d/m/Y H:i') }}</td>
                    <td class="text-center">{{ $t->reference_number ?: '-' }}</td>
                    <td>
                        {{ $t->item->name }}<br>
                        <span style="font-size: 10px; color: #555;">SKU: {{ $t->item->sku }}</span>
                    </td>
                    <td class="text-center">{{ strtoupper($t->type) }}</td>
                    <td class="text-center">{{ $t->quantity }}</td>
                    <td class="text-center">{{ $t->user->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data transaksi yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-bottom: 30px;">
        <strong>Ringkasan:</strong><br>
        Total Barang Masuk: {{ number_format($totalIn, 0, ',', '.') }} Item<br>
        Total Barang Keluar: {{ number_format($totalOut, 0, ',', '.') }} Item
    </div>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td width="50%">
                    Diperiksa Oleh,<br>
                    <strong>Manajer Operasional</strong>
                    <div class="signature-space"></div>
                    ( ......................................... )
                </td>
                <td width="50%">
                    Dicetak Oleh,<br>
                    <strong>Petugas Gudang / Admin</strong>
                    <div class="signature-space"></div>
                    ( {{ $printedBy }} )
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
