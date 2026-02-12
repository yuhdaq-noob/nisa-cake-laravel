<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 4px 8px; text-align: left; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Omzet</th>
                <th>HPP</th>
                <th>Profit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>
                        @foreach($order->items as $item)
                            {{ $item->product->name }} ({{ $item->quantity }})<br>
                        @endforeach
                    </td>
                    <td>{{ number_format($order->total_price,0,',','.') }}</td>
                    <td>{{ number_format($order->total_hpp,0,',','.') }}</td>
                    <td>{{ number_format($order->total_price - $order->total_hpp,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Dicetak: {{ date('Y-m-d H:i') }}</p>
</body>
</html>

