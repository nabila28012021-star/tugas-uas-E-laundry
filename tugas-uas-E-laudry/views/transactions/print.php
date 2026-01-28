<div class="receipt">
    <div class="header">
        <h1><?= $settings['company_name'] ?? 'Laundry Tunas Bangsa' ?></h1>
        <p><?= $settings['company_address'] ?? '' ?></p>
        <p>Telp: <?= $settings['company_phone'] ?? '' ?></p>
    </div>
    
    <div class="invoice-info">
        <p>No. Invoice:</p>
        <div class="invoice-code"><?= $transaction['invoice_code'] ?></div>
        <p><?= date('d/m/Y H:i', strtotime($transaction['entry_date'])) ?></p>
    </div>
    
    <div class="customer-info">
        <div class="row">
            <span class="label">Pelanggan:</span>
            <span><?= htmlspecialchars($transaction['customer_name']) ?></span>
        </div>
        <div class="row">
            <span class="label">Telepon:</span>
            <span><?= $transaction['customer_phone'] ?></span>
        </div>
    </div>
    
    <div class="items">
        <?php foreach ($items as $item): ?>
        <div class="item">
            <div class="item-name"><?= htmlspecialchars($item['package_name']) ?></div>
            <div class="item-detail">
                <?= number_format($item['quantity'], 2) ?> <?= $item['package_type'] === 'kg' ? 'kg' : 'pcs' ?> 
                x <?= Transaction::formatMoney($item['price']) ?>
            </div>
            <div class="row">
                <span></span>
                <span><?= Transaction::formatMoney($item['subtotal']) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="totals">
        <div class="total-row">
            <span>Subtotal</span>
            <span><?= Transaction::formatMoney($transaction['subtotal']) ?></span>
        </div>
        <?php if ($transaction['discount'] > 0): ?>
        <div class="total-row">
            <span>Diskon <?= $transaction['promo_code'] ? '(' . $transaction['promo_code'] . ')' : '' ?></span>
            <span>- <?= Transaction::formatMoney($transaction['discount']) ?></span>
        </div>
        <?php endif; ?>
        <div class="total-row grand-total">
            <span>TOTAL</span>
            <span><?= Transaction::formatMoney($transaction['total']) ?></span>
        </div>
    </div>
    
    <div class="status-badge">
        <span>Status: <?= Transaction::getStatusLabel($transaction['status']) ?></span>
    </div>
    
    <div class="row">
        <span class="label">Estimasi Selesai:</span>
        <span><?= date('d/m/Y', strtotime($transaction['estimated_date'])) ?></span>
    </div>
    
    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda</p>
        <p>Simpan struk ini untuk pengambilan</p>
        <p style="margin-top: 10px;">==================================</p>
        <p><?= $settings['app_name'] ?? 'Laundry Tunas Bangsa' ?></p>
    </div>
</div>
