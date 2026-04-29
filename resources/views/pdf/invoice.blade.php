<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', serif; color: #18181b; font-size: 12px; }
        .header { text-align: center; margin-bottom: 50px; }
        .brand { font-style: italic; font-size: 24px; letter-spacing: -1px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th { text-align: left; border-bottom: 1px solid #e4e4e7; padding: 10px; text-transform: uppercase; font-size: 9px; letter-spacing: 2px; }
        .table td { padding: 10px; border-bottom: 1px solid #f4f4f5; }
        .total-section { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">Abrari Studio.</div>
        <p style="text-transform: uppercase; letter-spacing: 3px; font-size: 9px;">Official Tax Invoice</p>
    </div>

    <table style="width: 100%">
        <tr>
            <td>
                <strong>Billed To:</strong><br>
                {{ $order->user->name }}<br>
                {{ nl2br($order->address->getFullAddressAttribute()) }}
            </td>
            <td style="text-align: right">
                <strong>Order Details:</strong><br>
                No: #{{ $order->order_number }}<br>
                Date: {{ $order->created_at->format('d M Y') }}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price, 2) }}</td>
                <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p>Subtotal: ₹{{ number_format($order->subtotal, 2) }}</p>
        <p>Shipping: {{ $order->shipping_charges == 0 ? 'Complimentary' : '₹'.number_format($order->shipping_charges, 2) }}</p>        
        <p>Discount: ₹{{ number_format($order->discount_amount, 2) }}</p>
        
        <h2 style="font-style: italic;">Total: ₹{{ number_format($order->total, 2) }}</h2>
    </div>
</body>
</html>