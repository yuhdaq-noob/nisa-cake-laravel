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

