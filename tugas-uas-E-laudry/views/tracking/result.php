<!-- Hero Section -->
<div class="hero-section text-white text-center">
    <div class="container">
        <span class="invoice-badge mb-3">
            <i class="fas fa-receipt me-2"></i>
            <?= $transaction['invoice_code'] ?>
        </span>
        <h1 class="hero-title mt-3">Status Laundry</h1>
    </div>
</div>

<!-- Result -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="result-card">
                <!-- Status Timeline -->
                <h5 class="text-center mb-4">Status Pengerjaan</h5>
                <div class="status-timeline">
                    <?php 
                    $statusOrder = ['baru', 'dicuci', 'disetrika', 'siap_ambil', 'selesai'];
                    $currentIndex = array_search($transaction['status'], $statusOrder);
                    foreach ($statusOrder as $index => $status): 
                        $config = $statuses[$status];
                        $isActive = $status === $transaction['status'];
                        $isCompleted = $index < $currentIndex;
                    ?>
                    <div class="status-step <?= $isActive ? 'active' : '' ?> <?= $isCompleted ? 'completed' : '' ?>">
                        <div class="step-icon">
                            <i class="fas <?= $isCompleted ? 'fa-check' : $config['icon'] ?>"></i>
                        </div>
                        <span class="step-label"><?= $config['label'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Current Status -->
                <div class="text-center my-4">
                    <span class="badge-status bg-<?= Transaction::getStatusColor($transaction['status']) ?> text-white">
                        <i class="fas <?= Transaction::getStatusIcon($transaction['status']) ?> me-2"></i>
                        <?= Transaction::getStatusLabel($transaction['status']) ?>
                    </span>
                </div>
                
                <hr>
                
                <!-- Info Cards -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <div class="info-label">Nama Pelanggan</div>
                            <div class="info-value"><?= htmlspecialchars($transaction['customer_name']) ?></div>
                        </div>
                        <div class="mb-4">
                            <div class="info-label">Tanggal Masuk</div>
                            <div class="info-value"><?= date('d F Y, H:i', strtotime($transaction['entry_date'])) ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <div class="info-label">Estimasi Selesai</div>
                            <div class="info-value">
                                <?= date('d F Y', strtotime($transaction['estimated_date'])) ?>
                                <?php if ($transaction['status'] !== 'selesai' && strtotime($transaction['estimated_date']) < time()): ?>
                                <small class="text-danger d-block"><i class="fas fa-exclamation-triangle me-1"></i> Melebihi estimasi</small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($transaction['status'] === 'selesai'): ?>
                        <div class="mb-4">
                            <div class="info-label">Tanggal Selesai</div>
                            <div class="info-value text-success"><?= date('d F Y, H:i', strtotime($transaction['completed_date'])) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Items -->
                <h5 class="mt-4 mb-3">Detail Item</h5>
                <?php foreach ($items as $item): ?>
                <div class="item-row d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($item['package_name']) ?></strong>
                        <br>
                        <small class="text-muted"><?= number_format($item['quantity'], 2) ?> <?= $item['package_type'] === 'kg' ? 'kg' : 'pcs' ?></small>
                    </div>
                    <div class="text-end">
                        <?= Transaction::formatMoney($item['subtotal']) ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Total -->
                <div class="total-section">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span><?= Transaction::formatMoney($transaction['subtotal']) ?></span>
                    </div>
                    <?php if ($transaction['discount'] > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span>Diskon</span>
                        <span>- <?= Transaction::formatMoney($transaction['discount']) ?></span>
                    </div>
                    <?php endif; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong class="text-primary" style="font-size: 20px;"><?= Transaction::formatMoney($transaction['total']) ?></strong>
                    </div>
                </div>
                
                <!-- Message based on status -->
                <div class="mt-4">
                    <?php if ($transaction['status'] === 'siap_ambil'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Laundry Anda sudah siap diambil!</strong><br>
                        Silakan kunjungi outlet kami untuk mengambil laundry Anda.
                    </div>
                    <?php elseif ($transaction['status'] === 'selesai'): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Laundry sudah diambil.</strong><br>
                        Terima kasih telah menggunakan layanan kami.
                    </div>
                    <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Laundry sedang dalam proses.</strong><br>
                        Kami akan menghubungi Anda saat laundry sudah siap diambil.
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Search Again -->
                <div class="text-center mt-4">
                    <a href="<?= BASE_URL ?>/tracking" class="btn btn-outline-secondary">
                        <i class="fas fa-search me-2"></i> Lacak Laundry Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
