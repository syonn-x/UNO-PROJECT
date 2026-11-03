<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Sewa - U.N.O</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background: #fff;
            padding: 20px;
        }
        .header-kop {
            border-bottom: 3px double #0284c7;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .kop-logo {
            font-size: 28px;
            font-weight: 900;
            color: #0284c7;
            letter-spacing: 1px;
        }
        .badge-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

<div class="no-print mb-4 p-3 bg-light border rounded d-flex justify-content-between align-items-center">
    <div>
        <strong>Mode Cetak Laporan Resmi</strong> - Klik tombol cetak untuk mencetak atau simpan sebagai PDF.
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary btn-sm font-weight-bold mr-2">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="btn btn-secondary btn-sm">
            Tutup Tab
        </button>
    </div>
</div>

<div class="container-fluid">
    <!-- Kop Surat -->
    <div class="header-kop d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="mr-3" style="width: 50px; height: 50px; object-fit: contain;">
            <div>
                <div class="kop-logo">U.N.O (USE NOT OWN)</div>
                <div class="text-muted" style="font-size: 13px;">Platform E-Commerce Rental & Sirkular Terpadu</div>
                <div class="text-muted" style="font-size: 12px;">Server Node: 10.61.4.129 • Telp: (021) 7890-1234 • Email: admin@uno.com</div>
            </div>
        </div>
        <div class="text-right">
            <h4 class="font-weight-bold text-uppercase mb-1">LAPORAN TRANSAKSI SEWA</h4>
            <div class="text-muted" style="font-size: 13px;">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
            <div class="text-muted" style="font-size: 11px;">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} WIB</div>
        </div>
    </div>

    <!-- Ringkasan Eksekutif -->
    <div class="row mb-4">
        <div class="col-6">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="bg-light" style="width: 45%;">Total Transaksi:</th>
                    <td class="font-weight-bold">{{ $totalTransactions }} Pesanan</td>
                </tr>
                <tr>
                    <th class="bg-light">Total Pendapatan / Omset:</th>
                    <td class="font-weight-bold text-success" style="font-size: 1.1rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="bg-light" style="width: 45%;">Filter Status:</th>
                    <td>{{ $status ? strtoupper($status) : 'Semua Status Transaksi' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Petugas Pembuat:</th>
                    <td>{{ auth()->user()->name ?? 'Administrator UNO' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tabel Data Transaksi -->
    <table class="table table-bordered table-sm mb-4" style="font-size: 12px;">
        <thead class="thead-light">
            <tr>
                <th style="width: 40px;" class="text-center">No</th>
                <th>No. Order</th>
                <th>Tanggal</th>
                <th>Nama Barang Rental</th>
                <th>Kategori</th>
                <th>Penyewa</th>
                <th>Durasi</th>
                <th class="text-right">Biaya Sewa</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $idx => $b)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td class="font-weight-bold">#BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $b->created_at->format('d/m/Y') }}</td>
                <td>{{ $b->item->name }}</td>
                <td>{{ $b->item->category->name }}</td>
                <td>{{ $b->renter->name }} ({{ $b->renter->phone ?? '-' }})</td>
                <td>{{ $b->total_days }} Hari</td>
                <td class="text-right font-weight-bold">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                <td class="text-center font-weight-bold text-uppercase" style="font-size: 10px;">{{ $b->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-3">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="font-weight-bold bg-light">
                <td colspan="7" class="text-right">TOTAL PENDAPATAN TERVERIFIKASI:</td>
                <td class="text-right text-success" style="font-size: 13px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Tanda Tangan -->
    <div class="row mt-5 pt-3">
        <div class="col-8">
            <p class="text-muted text-xs">
                * Dokumen ini dibuat secara otomatis oleh Sistem U.N.O E-Commerce Rental Platform.<br>
                Host System: 10.61.4.129 • Tanggal: {{ date('d-m-Y') }}
            </p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-5">Mengetahui,<br><strong>Manager Operasional & Keuangan</strong></p>
            <br><br>
            <p class="font-weight-bold mb-0"><u>( Ahmad Danuarta, S.Kom )</u></p>
            <small class="text-muted">NIP: 19880214 201201 1 002</small>
        </div>
    </div>
</div>

</body>
</html>
