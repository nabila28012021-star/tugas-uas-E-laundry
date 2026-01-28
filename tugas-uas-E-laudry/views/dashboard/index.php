<!-- Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $stats['total_transactions'] ?></h3>
                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="fas fa-receipt"></i>
            </div>
            <a href="<?= BASE_URL ?>/transaction" class="small-box-footer">
                Lihat detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $stats['pending_transactions'] ?></h3>
                <p>Sedang Diproses</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="<?= BASE_URL ?>/transaction?status=baru" class="small-box-footer">
                Lihat detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $stats['ready_pickup'] ?></h3>
                <p>Siap Diambil</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="<?= BASE_URL ?>/transaction?status=siap_ambil" class="small-box-footer">
                Lihat detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= Transaction::formatMoney($stats['monthly_revenue']) ?></h3>
                <p>Pendapatan Bulan Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="#" class="small-box-footer">
                <i class="fas fa-chart-line"></i> Statistik
            </a>
        </div>
    </div>
</div>

<!-- Status Overview -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks mr-2"></i>
                    Status Transaksi
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($statusCounts as $status => $data): ?>
                    <div class="col">
                        <div class="text-center">
                            <div class="mb-2">
                                <span class="badge badge-<?= $data['color'] ?>" style="font-size: 24px; padding: 15px;">
                                    <?= $data['count'] ?>
                                </span>
                            </div>
                            <small class="text-muted"><?= $data['label'] ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Recent Transactions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-2"></i>
                    Transaksi Terbaru
                </h3>
                <div class="card-tools">
                    <a href="<?= BASE_URL ?>/transaction" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentTransactions)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada transaksi
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($recentTransactions as $trx): ?>
                        <tr>
                            <td>
                                <strong><?= $trx['invoice_code'] ?></strong>
                                <br>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($trx['entry_date'])) ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($trx['customer_name']) ?>
                                <br>
                                <small class="text-muted"><?= $trx['customer_phone'] ?></small>
                            </td>
                            <td><?= Transaction::formatMoney($trx['total']) ?></td>
                            <td>
                                <span class="badge badge-<?= Transaction::getStatusColor($trx['status']) ?>">
                                    <?= Transaction::getStatusLabel($trx['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/transaction/show/<?= $trx['id'] ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-2"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body">
                <a href="<?= BASE_URL ?>/transaction/create" class="btn btn-primary btn-block mb-3">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Transaksi Baru
                </a>
                <a href="<?= BASE_URL ?>/customer/create" class="btn btn-outline-secondary btn-block mb-3">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Pelanggan
                </a>
                <a href="<?= BASE_URL ?>/tracking" target="_blank" class="btn btn-outline-info btn-block">
                    <i class="fas fa-search mr-2"></i>
                    Lacak Laundry
                </a>
            </div>
        </div>
        
        <!-- Pending Pickup -->
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-box mr-2"></i>
                    Siap Diambil
                </h3>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php 
                    $readyPickup = array_filter($pendingTransactions, fn($t) => $t['status'] === 'siap_ambil');
                    if (empty($readyPickup)): 
                    ?>
                    <li class="list-group-item text-center text-muted py-4">
                        Tidak ada laundry yang siap diambil
                    </li>
                    <?php else: ?>
                    <?php foreach (array_slice($readyPickup, 0, 5) as $trx): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= $trx['invoice_code'] ?></strong>
                                <br>
                                <small><?= htmlspecialchars($trx['customer_name']) ?></small>
                            </div>
                            <a href="<?= BASE_URL ?>/transaction/show/<?= $trx['id'] ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i>
                            </a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <!-- Info Card -->
        <div class="card bg-gradient-info">
            <div class="card-body">
                <h5 class="text-white">
                    <i class="fas fa-info-circle mr-2"></i>
                    Hari Ini
                </h5>
                <p class="text-white-50 mb-0">
                    Pendapatan: <?= Transaction::formatMoney($stats['today_revenue']) ?>
                </p>
            </div>
        </div>
    </div>
</div>
