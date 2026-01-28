<!-- Filter by Status -->
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="d-flex flex-wrap align-items-center">
            <span class="mr-3">Filter Status:</span>
            <a href="<?= BASE_URL ?>/transaction" class="btn btn-sm <?= empty($currentStatus) ? 'btn-primary' : 'btn-outline-secondary' ?> mr-2 mb-1">
                Semua
            </a>
            <?php foreach ($statuses as $status => $config): ?>
            <a href="<?= BASE_URL ?>/transaction?status=<?= $status ?>" class="btn btn-sm <?= $currentStatus === $status ? 'btn-' . $config['color'] : 'btn-outline-' . $config['color'] ?> mr-2 mb-1">
                <i class="fas <?= $config['icon'] ?> mr-1"></i>
                <?= $config['label'] ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Transaksi</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>/transaction/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Transaksi Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal Masuk</th>
                    <th>Estimasi</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $trx): ?>
                <tr>
                    <td>
                        <strong><?= $trx['invoice_code'] ?></strong>
                    </td>
                    <td>
                        <?= htmlspecialchars($trx['customer_name']) ?>
                        <br>
                        <small class="text-muted"><?= $trx['customer_phone'] ?></small>
                    </td>
                    <td><?= Transaction::formatMoney($trx['total']) ?></td>
                    <td>
                        <span class="badge badge-<?= Transaction::getStatusColor($trx['status']) ?>">
                            <i class="fas <?= Transaction::getStatusIcon($trx['status']) ?> mr-1"></i>
                            <?= Transaction::getStatusLabel($trx['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($trx['entry_date'])) ?></td>
                    <td>
                        <?= date('d/m/Y', strtotime($trx['estimated_date'])) ?>
                        <?php if ($trx['status'] !== 'selesai' && strtotime($trx['estimated_date']) < time()): ?>
                        <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/transaction/show/<?= $trx['id'] ?>" class="btn btn-sm btn-info" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/transaction/print/<?= $trx['id'] ?>" class="btn btn-sm btn-secondary" title="Cetak" target="_blank">
                            <i class="fas fa-print"></i>
                        </a>
                        <?php if ($trx['status'] !== 'selesai'): ?>
                        <a href="<?= BASE_URL ?>/transaction/next/<?= $trx['id'] ?>" class="btn btn-sm btn-success" title="Lanjut Status">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
