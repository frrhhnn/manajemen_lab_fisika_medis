<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Peminjaman Alat - {{ $peminjaman->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .letterhead {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .letterhead h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .letterhead h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .letterhead p {
            font-size: 12px;
            margin-bottom: 3px;
        }
        
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin: 30px 0;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 20px;
        }
        
        .borrower-info {
            margin: 20px 0;
        }
        
        .borrower-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .borrower-info td {
            padding: 5px;
            vertical-align: top;
        }
        
        .borrower-info td:first-child {
            width: 200px;
        }
        
        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .equipment-table th,
        .equipment-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        .equipment-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        
        .signature-section {
            margin-top: 40px;
        }
        
        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 60px 0 10px 0;
            height: 1px;
        }
        
        .notes {
            margin-top: 30px;
            font-size: 12px;
            padding: 15px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        
        .notes h4 {
            margin-bottom: 10px;
            text-decoration: underline;
        }
        
        .notes ul {
            margin-left: 20px;
        }
        
        .notes li {
            margin-bottom: 5px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .print-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Print / Save PDF</button>
    
    <!-- Letterhead -->
    <div class="letterhead">
        <h1>UNIVERSITAS SYIAH KUALA</h1>
        <h2>FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM</h2>
        <h2>LABORATORIUM FISIKA MEDIS</h2>
        <p>Jl. Teuku Nyak Arief Darussalam, Banda Aceh 23111</p>
        <p>Telp. (0651) 7552121, Fax. (0651) 7552121</p>
        <p>Email: fismed@unsyiah.ac.id | Website: www.fisika.unsyiah.ac.id</p>
    </div>
    
    <!-- Title -->
    <div class="title">
        SURAT PEMINJAMAN ALAT LABORATORIUM
    </div>
    
    <!-- Content -->
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Admin Laboratorium Fisika Medis Universitas Syiah Kuala, 
        dengan ini menyatakan telah menyetujui peminjaman alat laboratorium dengan data sebagai berikut:</p>
    </div>
    
    <!-- Borrower Information -->
    <div class="borrower-info">
        <table>
            <tr>
                <td>Nama Peminjam</td>
                <td>: {{ $peminjaman->namaPeminjam }}</td>
            </tr>
            <tr>
                <td>Nomor HP</td>
                <td>: {{ $peminjaman->noHp }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $peminjaman->is_mahasiswa_usk ? 'Mahasiswa Universitas Syiah Kuala' : 'Bukan Mahasiswa USK' }}</td>
            </tr>
            @if($peminjaman->is_mahasiswa_usk && $peminjaman->npm_nim)
            <tr>
                <td>NPM/NIM</td>
                <td>: {{ $peminjaman->npm_nim }}</td>
            </tr>
            @endif
            <tr>
                <td>Tujuan Peminjaman</td>
                <td>: {{ $peminjaman->tujuanPeminjaman ?: '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Peminjaman</td>
                <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengembalian</td>
                <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Durasi Peminjaman</td>
                <td>: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)) }} hari</td>
            </tr>
            <tr>
                <td>ID Peminjaman</td>
                <td>: {{ $peminjaman->id }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Equipment List -->
    <div>
        <h4>Daftar Alat yang Dipinjam:</h4>
        <table class="equipment-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Kode Alat</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Kondisi Pinjam</th>
                    <th>Kondisi Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman->peminjamanItems as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $item->alat->nama }}</td>
                    <td>{{ $item->alat->kode }}</td>
                    <td>{{ $item->alat->nama_kategori }}</td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td style="text-align: center;">Baik</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-row">
            <div class="signature-box">
                <p>Peminjam</p>
                <div class="signature-line"></div>
                <p><strong>{{ $peminjaman->namaPeminjam }}</strong></p>
            </div>
            <div class="signature-box">
                <p>Admin Laboratorium</p>
                <div class="signature-line"></div>
                <p><strong>Admin Lab. Fisika Medis</strong></p>
            </div>
        </div>
        
        <div style="text-align: right; margin-top: 30px;">
            <p>Banda Aceh, {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        </div>
    </div>
    
    <!-- Notes -->
    <div class="notes">
        <h4>KETENTUAN PEMINJAMAN:</h4>
        <ul>
            <li>Peminjam wajib menjaga dan merawat alat dengan baik selama masa peminjaman</li>
            <li>Alat harus dikembalikan dalam kondisi baik dan sesuai jadwal yang telah ditentukan</li>
            <li>Jika terjadi kerusakan akibat kelalaian peminjam, peminjam wajib mengganti dengan nilai yang sama</li>
            <li>Keterlambatan pengembalian akan dikenakan sanksi sesuai peraturan laboratorium</li>
            <li>Peminjam wajib melaporkan segera jika terjadi kerusakan atau masalah pada alat</li>
            <li>Surat ini harus dikembalikan bersamaan dengan alat yang dipinjam</li>
        </ul>
        
        <p style="margin-top: 15px;"><strong>Kontak Lab:</strong> +62 651 7552121 | Email: fismed@unsyiah.ac.id</p>
    </div>
    
    <script>
        // Auto print dialog when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html> 