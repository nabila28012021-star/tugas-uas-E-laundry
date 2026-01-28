<div class="row">
    <!-- Transaction Details -->
    <div class="col-md-8">
        <!-- Invoice Header -->
        <div class="invoice-box">
            <div class="row">
                <div class="col">
                    <h2>KODE INVOICE</h2>
                    <h1><?= $transaction['invoice_code'] ?></h1>
                </div>
                <div class="col text-right">
                    <span class="badge badge-<?= Transaction::getStatusColor($transaction['status']) ?>" style="font-size: 18px; padding: 10px 20px;">
                        <i class="fas <?= Transaction::getStatusIcon($transaction['status']) ?> mr-2"></i>
                        <?= Transaction::getStatusLabel($transaction['status']) ?>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Status Timeline -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">Status Pengerjaan</h5>
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
                
                <?php if ($transaction['status'] !== 'selesai'): ?>
                <div class="text-center mt-4">
                    <form action="<?= BASE_URL ?>/transaction/next/<?= $transaction['id'] ?>" method="post" style="display: inline;">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-arrow-right mr-2"></i>
                            Lanjutkan ke "<?= Transaction::getStatusLabel($statuses[$transaction['status']]['next']) ?>"
                        </button>
                    </form>
                </div>
                <?php else: ?>
                <div class="text-center mt-4">
                    <div class="alert alert-success mb-0">
                        <i class="fas fa-check-circle mr-2"></i>
                        Transaksi selesai pada <?= date('d/m/Y H:i', strtotime($transaction['completed_date'])) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Items -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list mr-2"></i>
                    Detail Item
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Paket</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($item['package_name']) ?></strong>
                                <br>
                                <small class="text-muted"><?= ucfirst($item['package_type']) ?></small>
                            </td>
                            <td class="text-center"><?= number_format($item['quantity'], 2) ?> <?= $item['package_type'] === 'kg' ? 'kg' : 'pcs' ?></td>
                            <td class="text-right"><?= Transaction::formatMoney($item['price']) ?></td>
                            <td class="text-right"><?= Transaction::formatMoney($item['subtotal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                            <td class="text-right"><strong><?= Transaction::formatMoney($transaction['subtotal']) ?></strong></td>
                        </tr>
                        <?php if ($transaction['discount'] > 0): ?>
                        <tr class="text-danger">
                            <td colspan="3" class="text-right">
                                Diskon
                                <?php if ($transaction['promo_code']): ?>
                                <small>(<?= $transaction['promo_code'] ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">- <?= Transaction::formatMoney($transaction['discount']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr class="bg-light">
                            <td colspan="3" class="text-right"><h4 class="mb-0">Total</h4></td>
                            <td class="text-right"><h4 class="mb-0 text-primary"><?= Transaction::formatMoney($transaction['total']) ?></h4></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <?php if ($transaction['notes']): ?>
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-sticky-note mr-2"></i>
                    Catatan
                </h3>
            </div>
            <div class="card-body">
                <?= nl2br(htmlspecialchars($transaction['notes'])) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Customer Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Data Pelanggan
                </h3>
            </div>
            <div class="card-body">
                <h5><?= htmlspecialchars($transaction['customer_name']) ?></h5>
                <p class="mb-1">
                    <i class="fas fa-phone mr-2 text-muted"></i>
                    <a href="tel:<?= $transaction['customer_phone'] ?>"><?= $transaction['customer_phone'] ?></a>
                </p>
                <?php if ($transaction['customer_address']): ?>
                <p class="mb-0">
                    <i class="fas fa-map-marker-alt mr-2 text-muted"></i>
                    <?= htmlspecialchars($transaction['customer_address']) ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Transaction Info -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted">Tanggal Masuk</td>
                        <td class="text-right"><?= date('d/m/Y H:i', strtotime($transaction['entry_date'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Estimasi Selesai</td>
                        <td class="text-right">
                            <?= date('d/m/Y', strtotime($transaction['estimated_date'])) ?>
                            <?php if ($transaction['status'] !== 'selesai' && strtotime($transaction['estimated_date']) < time()): ?>
                            <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kasir</td>
                        <td class="text-right"><?= htmlspecialchars($transaction['user_name']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog mr-2"></i>
                    Aksi
                </h3>
            </div>
            <div class="card-body">
                <a href="<?= BASE_URL ?>/transaction/print/<?= $transaction['id'] ?>" class="btn btn-primary btn-block mb-2" target="_blank">
                    <i class="fas fa-print mr-2"></i> Cetak Nota
                </a>
                
                <a href="<?= BASE_URL ?>/transaction" class="btn btn-secondary btn-block mb-2">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                <?php if ($transaction['status'] === 'baru'): ?>
                <hr>
                <a href="<?= BASE_URL ?>/transaction/delete/<?= $transaction['id'] ?>" class="btn btn-outline-danger btn-block btn-delete">
                    <i class="fas fa-trash mr-2"></i> Hapus Transaksi
                </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Manual Status Change -->
        <?php if ($transaction['status'] !== 'selesai'): ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-2"></i>
                    Ubah Status Manual
                </h3>
            </div>
            <div class="card-body">
                <form action="<?= BASE_URL ?>/transaction/status/<?= $transaction['id'] ?>" method="post">
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <?php foreach ($statuses as $status => $config): ?>
                            <option value="<?= $status ?>" <?= $transaction['status'] === $status ? 'selected' : '' ?>>
                                <?= $config['label'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">
                        <i class="fas fa-save mr-2"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
