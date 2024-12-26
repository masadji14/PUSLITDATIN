<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            text-align: center;
            padding: 10px 20px;
            border-bottom: 2px solid #333;
        }
        header img {
            height: 80px;
            margin-bottom: 10px;
        }
        header h1 {
            margin: 0;
            font-size: 24px;
        }
        header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .content {
            margin: 20px;
        }
        .content h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        table th {
            background-color: #f4f4f4;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px 20px;
            background-color: #f4f4f4;
            border-top: 2px solid #333;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/Logo_BNN.png') }}" alt="Logo Perusahaan">
        <h1>Data Pegawai</h1>
        <p>Laporan Data Pegawai - {{ now()->format('d F Y') }}</p>
    </header>

    <div class="content">
        <h2>Data Pegawai</h2>
        <table>
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ ucwords(str_replace('_', ' ', $column)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        @foreach ($columns as $column)
                            <td>{{ $record->$column }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        &copy; {{ now()->year }} Pusat Penelitian Data dan Informasi. Semua Hak Dilindungi. | Dibuat pada: {{ now()->format('d F Y H:i') }}
    </footer>
</body>
</html>