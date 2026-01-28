<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kode Promo</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>/promo/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Promo
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Kode</th>
                    <th>Nama Promo</th>
                    <th>Diskon</th>
                    <th>Min. Pembelian</th>
                    <th>Masa Berlaku</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promos as $i => $promo): ?>
                <?php
                $today = date('Y-m-d');
                $isExpired = $today > $promo['valid_until'];
                $isNotStarted = $today < $promo['valid_from'];
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <code class="bg-light px-2 py-1"><?= htmlspecialchars($promo['code']) ?></code>
                    </td>
                    <td><?= htmlspecialchars($promo['name']) ?></td>
                    <td>
                        <?php if ($promo['discount_type'] === 'percent'): ?>
                        <span class="badge badge-info"><?= $promo['discount_value'] ?>%</span>
                        <?php else: ?>
                        <span class="badge badge-success"><?= Transaction::formatMoney($promo['discount_value']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= Transaction::formatMoney($promo['min_purchase']) ?></td>
                    <td>
                        <?= date('d/m/Y', strtotime($promo['valid_from'])) ?> - 
                        <?= date('d/m/Y', strtotime($promo['valid_until'])) ?>
                        <?php if ($isExpired): ?>
                        <br><small class="text-danger">Kadaluarsa</small>
                        <?php elseif ($isNotStarted): ?>
                        <br><small class="text-warning">Belum berlaku</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($promo['is_active']): ?>
                        <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/promo/edit/<?= $promo['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/promo/delete/<?= $promo['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
