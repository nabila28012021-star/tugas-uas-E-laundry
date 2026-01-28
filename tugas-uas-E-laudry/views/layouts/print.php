<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Laundry | Laundry Tunas Bangsa</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            background: #f5f5f5;
        }
        
        .receipt {
            width: 80mm;
            margin: 20px auto;
            padding: 10mm;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            text-align: center;
            border-bottom: 1px dashed #333;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .invoice-info {
            text-align: center;
            margin-bottom: 15px;
        }
        
        .invoice-code {
            font-size: 14px;
            font-weight: bold;
            background: #f0f0f0;
            padding: 5px 10px;
            display: inline-block;
            margin: 5px 0;
        }
        
        .customer-info {
            border-top: 1px dashed #333;
            border-bottom: 1px dashed #333;
            padding: 10px 0;
            margin-bottom: 10px;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .label {
            color: #666;
        }
        
        .items {
            margin-bottom: 10px;
        }
        
        .item {
            padding: 5px 0;
            border-bottom: 1px dotted #ccc;
        }
        
        .item:last-child {
            border-bottom: none;
        }
        
        .item-name {
            font-weight: bold;
        }
        
        .item-detail {
            color: #666;
            font-size: 10px;
        }
        
        .totals {
            border-top: 1px dashed #333;
            padding-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .total-row.grand-total {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #333;
        }
        
        .footer p {
            font-size: 10px;
            color: #666;
        }
        
        .status-badge {
            text-align: center;
            margin: 10px 0;
        }
        
        .status-badge span {
            background: #333;
            color: white;
            padding: 3px 10px;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        .btn-print {
            display: block;
            width: 80mm;
            margin: 20px auto;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-print:hover {
            opacity: 0.9;
        }
        
        .btn-back {
            display: block;
            width: 80mm;
            margin: 10px auto;
            padding: 10px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
        }
        
        @media print {
            body {
                background: white;
            }
            
            .receipt {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
            
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <?= $content ?>
    
    <button class="btn-print no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Nota
    </button>
    
    <a href="<?= BASE_URL ?>/transaction/show/<?= $transaction['id'] ?>" class="btn-back no-print">
        &larr; Kembali ke Detail
    </a>
    
    <!-- Font Awesome for print icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" class="no-print">
</body>
</html>
