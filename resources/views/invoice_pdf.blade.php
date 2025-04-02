

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice #{{ $invoice_number ?? 'N/A' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #333;
            background: #f8f9fa;
        }
        .container {
            max-width: 800px;
            background: #fff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            /*   */
        }
        .company-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .logo-container {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        .company-name {
            font-size: 16px;
            margin-top: 5px;
            color: #555;
        }
        .invoice-details {
            text-align: right;
            font-size: 14px;
            color: #444;
        }
        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        .address-section h2 {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .address-content {
            font-size: 14px;
            line-height: 1.5;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background-color: #f1f5f9;
            color: #333;
            font-weight: 600;
        }
        td {
            font-size: 14px;
            color: #444;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 20px;
            width: 100%;
            text-align: right;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .total-row.final {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
        .notes {
            margin-top: 30px;
            font-size: 14px;
            color: #555;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .notes h2 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                @if(isset($company_logo))
                    <div class="logo-container">
                        <img src="http://localhost:8000/storage/company-logos/JyWwTe3ci6cO7X4FzffaNBxvAMz3j3eoCFgv3PjY.jpg" alt="Company Logo" class="logo">
                    </div>
                @endif
                <div>
                    <div class="invoice-title">INVOICE</div>
                    <div class="company-name">{{ $company_name ?? 'Your Company Name' }}</div>
                </div>
            </div>
            <div class="invoice-details">
                <div><strong>Invoice #:</strong> {{ $invoice_number ?? 'N/A' }}</div>
                <div><strong>Date:</strong> {{ $invoice_date ?? date('Y-m-d') }}</div>
                <div><strong>Due Date:</strong> {{ $due_date  ?? date('Y-m-d') }}</div>
                <div><strong>PO Number:</strong> {{ $po_number }}</div>
            </div>
        </div>

        
        <div class="addresses">
            <div class="address-section">
                <h2>Bill To:</h2>
                <div class="address-content">
                    {{ $bill_to_name ?? 'Client Name' }}<br>
                    {{ $bill_to_address ?? 'Client Address' }}
                </div>
            </div>
            <div class="address-section">
                <h2>Ship To:</h2>
                <div class="address-content">
                    {{ $ship_to_name ?? 'Shipping Name' }}<br>
                    {{ $ship_to_address ?? 'Shipping Address' }}
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items ?? [] as $item)
                    <tr>
                        <td>{{ $item['name'] ?? '' }}</td>
                        <td>{{ $item['description'] ?? '' }}</td>
                        <td class="text-right">{{ $item['quantity'] ?? 1 }}</td>
                        <td class="text-right">${{ number_format($item['rate'] ?? 0, 2) }}</td>
                        <td class="text-right">${{ number_format($item['amount'] ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($subtotal ?? 0, 2) }}</span>
            </div>
            @if(isset($discount_rate) && $discount_rate > 0)
                <div class="total-row">
                    <span>Discount ({{ $discount_rate }}%):</span>
                    <span>- ${{ number_format($discount_amount ?? 0, 2) }}</span>
                </div>
            @endif
            @if(isset($tax_rate) && $tax_rate > 0)
                <div class="total-row">
                    <span>Tax ({{ $tax_rate }}%):</span>
                    <span>${{ number_format($tax_amount ?? 0, 2) }}</span>
                </div>
            @endif
            <div class="total-row final">
                <span>Total:</span>
                <span>${{ number_format($total ?? 0, 2) }}</span>
            </div>
        </div>

        @if(isset($notes))
            <div class="notes">
                <h2>Notes:</h2>
                <div>{{ $notes }}</div>
            </div>
        @endif
    </div>
</body>
</html>

