<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_id }} - Exclusive Fragrance</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Amarante&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            color: #151E25;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #F5D57A;
            padding-bottom: 20px;
        }
        
        .logo {
            font-family: 'Amarante', cursive;
            font-size: 28px;
            color: #151E25;
            margin: 0;
        }
        
        .tagline {
            color: #6B7280;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #151E25;
        }
        
        .invoice-meta {
            color: #6B7280;
            margin: 3px 0;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #151E25;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .info-group {
            margin-bottom: 15px;
        }
        
        .info-label {
            font-size: 12px;
            color: #6B7280;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            font-size: 15px;
            color: #151E25;
            font-weight: 500;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th {
            background-color: #F5D57A;
            color: #151E25;
            text-align: left;
            padding: 12px 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        .total-row td {
            padding-top: 20px;
            font-weight: 600;
        }
        
        .grand-total {
            font-size: 18px;
            color: #151E25;
            font-weight: 700;
        }
        
        .grand-total-amount {
            color: #151E25;
            font-size: 18px;
            font-weight: 700;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #F5D57A;
            text-align: center;
            color: #6B7280;
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-completed {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-cancelled {
            background-color: #FEE2E2;
            color: #B45309;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .barcode {
            margin-top: 10px;
            text-align: center;
            font-family: 'Libre Barcode 128', cursive;
            font-size: 36px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1 class="logo">Exclusive Fragrance</h1>
                <p class="tagline">Premium Scents for the Discerning Individual</p>
            </div>
            <div class="invoice-info">
                <h2 class="invoice-title">INVOICE</h2>
                <p class="invoice-meta">Invoice #{{ $order->order_id }}</p>
                <p class="invoice-meta">Date: {{ $order->order_date->format('M d, Y') }}</p>
                <p class="invoice-meta">Status: 
                    <span class="status-badge status-{{ $order->order_status }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="grid-2 section">
            <div>
                <h3 class="section-title">Billed To</h3>
                <div class="info-group">
                    <div class="info-label">Customer Name</div>
                    <div class="info-value">{{ $order->user->name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $order->user->email }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Customer Since</div>
                    <div class="info-value">{{ $order->user->created_at->format('M d, Y') }}</div>
                </div>
            </div>
            
            <div>
                <h3 class="section-title">Shipping To</h3>
                <div class="info-group">
                    <div class="info-label">Recipient</div>
                    <div class="info-value">{{ $order->shipping->full_name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Address</div>
                    <div class="info-value">{{ $order->shipping->address }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">City</div>
                    <div class="info-value">{{ $order->shipping->city }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Postal Code</div>
                    <div class="info-value">{{ $order->shipping->postal_code }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Phone</div>
                    <div class="info-value">{{ $order->shipping->phone }}</div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <h3 class="section-title">Order Items</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->product_name }}</strong><br>
                            <span style="color: #6B7280; font-size: 13px;">
                                {{ $item->product->fragrance_type }} • {{ $item->product->size }}ml
                            </span>
                        </td>
                        <td>LKR {{ number_format($item->sale_item_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">LKR {{ number_format($item->sale_item_price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    
                    <tr class="total-row">
                        <td colspan="3" class="text-right">Subtotal:</td>
                        <td class="text-right">LKR {{ number_format($order->total_sale_amount - 500, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Shipping:</td>
                        <td class="text-right">LKR 500.00</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right grand-total">Grand Total:</td>
                        <td class="text-right grand-total-amount">LKR {{ number_format($order->total_sale_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="grid-3 section">
            <div>
                <h3 class="section-title">Payment Method</h3>
                <div class="info-value">
                    @if($order->payment_method === 'cod')
                        Cash on Delivery
                    @elseif($order->payment_method === 'credit_card')
                        Credit Card
                    @elseif($order->payment_method === 'paypal')
                        PayPal
                    @else
                        {{ ucfirst($order->payment_method) }}
                    @endif
                </div>
            </div>
            
            <div>
                <h3 class="section-title">Payment Status</h3>
                <div class="info-value">
                    @if($order->order_status === 'completed')
                        Paid
                    @elseif($order->order_status === 'cancelled')
                        Refunded
                    @else
                        Pending
                    @endif
                </div>
            </div>
            
            <div>
                <h3 class="section-title">Shipping Method</h3>
                <div class="info-value">Standard Delivery</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for your business! We appreciate your trust in Exclusive Fragrance.</p>
            <p>Invoice generated on: {{ now()->format('M d, Y \a\t h:i A') }}</p>
            <div class="barcode">*{{ $order->order_id }}*</div>
            <p>www.exclusivefragrance.com | contact@exclusivefragrance.com | +94 112 345 678</p>
        </div>
    </div>
</body>
</html>