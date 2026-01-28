<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Paket Laundry</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>/package/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Paket
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Paket</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($packages as $i => $package): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <strong><?= htmlspecialchars($package['name']) ?></strong>
                    </td>
                    <td>
                        <span class="badge badge-<?= $package['type'] === 'kg' ? 'info' : 'secondary' ?>">
                            <?= Package::getTypeLabel($package['type']) ?>
                        </span>
                    </td>
                    <td><?= Package::formatPrice($package['price']) ?></td>
                    <td><?= htmlspecialchars($package['description'] ?? '-') ?></td>
                    <td>
                        <?php if ($package['is_active']): ?>
                        <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/package/edit/<?= $package['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/package/delete/<?= $package['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
