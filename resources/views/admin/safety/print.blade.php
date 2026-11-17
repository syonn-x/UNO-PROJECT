<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara & Laporan Keamanan Pengguna - U.N.O</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 24px;
            font-size: 13px;
            line-height: 1.5;
            background: #fff;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 3px solid #0284c7;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .logo-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }
        .title-block h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .title-block p {
            margin: 2px 0 0 0;
            font-size: 11px;
            color: #64748b;
        }
        .doc-meta {
            text-align: right;
            font-size: 11px;
            color: #475569;
        }
        .doc-meta strong {
            font-size: 13px;
            color: #0284c7;
            display: block;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 4px;
        }
        .badge-danger { background: #fee2e2; color: #b91c1c; }
        .badge-warning { background: #fef3c7; color: #b45309; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-info { background: #e0f2fe; color: #0369a1; }
        .badge-secondary { background: #f1f5f9; color: #475569; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f8fafc;
            color: #334155;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }
        .incident-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .incident-title {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px 0;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 12px;
            font-size: 12px;
        }
        .meta-item strong {
            display: block;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
        }
        .section-heading {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #1e293b;
            border-left: 4px solid #0284c7;
            padding-left: 8px;
            margin: 20px 0 12px 0;
        }
        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }
        .sig-col {
            width: 220px;
            text-align: center;
        }
        .sig-line {
            margin-top: 60px;
            border-bottom: 1px solid #0f172a;
            font-weight: 700;
            padding-bottom: 4px;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="background: #0284c7; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ Cetak Dokumen / Simpan PDF
        </button>
        <button onclick="window.close()" style="background: #64748b; color: #fff; border: none; padding: 8px 16px; border-radius: 6px; font-weight: bold; cursor: pointer; margin-left: 8px;">
            Tutup
        </button>
    </div>

    <!-- Official Header -->
    <div class="header">
        <div class="logo-box">
            <img src="{{ asset('images/logo.png') }}" class="logo-img" alt="Logo U.N.O">
            <div class="title-block">
                <h1>U.N.O • USE NOT OWN</h1>
                <p>Divisi Kepatuhan, Keamanan Ekosistem & Perlindungan Pengguna Pusat</p>
                <p>Graha U.N.O Jakarta Pusat • helpdesk@uno.com • Hotline: (021) 8899-7711</p>
            </div>
        </div>
        <div class="doc-meta">
            <strong>BERITA ACARA KEAMANAN</strong>
            <div>No. Dokumen: SEC-BA/{{ date('Ymd') }}/UNO</div>
            <div>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 12px; margin-bottom: 20px;">
        <strong style="color: #1e40af;">POKOK LAPORAN:</strong>
        <p style="margin: 4px 0 0 0; color: #1e3a8a; font-size: 12px;">
            Dokumen resmi ini merangkum audit investigasi insiden keamanan, sengketa hak sewa, perlindungan privasi, serta tindakan sanksi disipliner akun pengguna yang diterbitkan oleh Manajemen Pusat U.N.O.
        </p>
    </div>

    <div class="section-heading">Daftar Audit Insiden & Laporan Keamanan</div>

    @foreach($reports as $r)
    <div class="incident-card">
        <div class="incident-title">
            [{{ $r->report_code }}] {{ $r->title }}
        </div>
        <div class="meta-grid">
            <div class="meta-item">
                <strong>Kategori Masalah</strong>
                <span>{{ $r->category_label }}</span>
            </div>
            <div class="meta-item">
                <strong>Tingkat Urgensi</strong>
                <span class="badge {{ $r->severity_badge['class'] }}">{{ $r->severity_badge['label'] }}</span>
            </div>
            <div class="meta-item">
                <strong>Status Investigasi</strong>
                <span class="badge {{ $r->status_badge['class'] }}">{{ $r->status_badge['label'] }}</span>
            </div>
            <div class="meta-item">
                <strong>Pihak Pelapor</strong>
                <span>{{ $r->reporter->name ?? 'Anonim' }} ({{ $r->reporter->email ?? '-' }})</span>
            </div>
            <div class="meta-item">
                <strong>Pihak Terlapor</strong>
                <span>{{ $r->reportedUser->name ?? '-' }} ({{ $r->reportedUser->status === 'suspended' ? 'DITANGGUHKAN' : 'Aktif' }})</span>
            </div>
            <div class="meta-item">
                <strong>Waktu Lapor / Selesai</strong>
                <span>{{ $r->created_at->format('d/m/Y') }} @if($r->resolved_at) / {{ $r->resolved_at->format('d/m/Y') }} @endif</span>
            </div>
        </div>

        <div style="margin-bottom: 10px;">
            <strong style="font-size: 11px; text-transform: uppercase; color: #475569;">Kronologi Aduan:</strong>
            <p style="margin: 4px 0 0 0; font-size: 12px; color: #334155; line-height: 1.4;">
                {{ $r->description }}
            </p>
        </div>

        @if($r->admin_notes)
        <div style="background: #f1f5f9; border-left: 3px solid #0284c7; padding: 8px 12px; border-radius: 4px; margin-top: 8px;">
            <strong style="font-size: 11px; color: #0f172a;">Catatan & Tindakan Disiplin Admin Pusat:</strong>
            <div style="font-size: 12px; color: #334155; margin-top: 2px;">{{ $r->admin_notes }}</div>
        </div>
        @endif
    </div>
    @endforeach

    <div class="signature-block">
        <div class="sig-col">
            <div>Dibuat Oleh,</div>
            <div style="font-size: 11px; color: #64748b;">Tim Investigasi Keamanan</div>
            <div class="sig-line">Petugas Keamanan Pusat</div>
            <div style="font-size: 10px; color: #64748b;">ID Petugas: #SEC-OPR-01</div>
        </div>

        <div class="sig-col">
            <div>Mengetahui & Menyetujui,</div>
            <div style="font-size: 11px; color: #64748b;">Kepala Admin Pusat U.N.O</div>
            <div class="sig-line">{{ auth()->user()->name ?? 'Administrator Utama' }}</div>
            <div style="font-size: 10px; color: #64748b;">Head of Trust & Platform Safety</div>
        </div>
    </div>

</body>
</html>
