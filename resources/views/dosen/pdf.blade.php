<!DOCTYPE html>
<html>
<head>
    <title>Data Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA DOSEN</h1>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dosen as $index => $dsn)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $dsn['nidn'] ?? '-' }}</td>
                <td>{{ $dsn['nama'] ?? '-' }}</td>
                <td>{{ $dsn['email'] ?? '-' }}</td>
                <td>{{ $dsn['prodi'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ count($dosen) }} dosen</p>
    </div>
</body>
</html>
