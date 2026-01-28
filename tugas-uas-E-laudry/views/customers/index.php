<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Pelanggan</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>/customer/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Pelanggan
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Terdaftar</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $i => $customer): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <strong><?= htmlspecialchars($customer['name']) ?></strong>
                    </td>
                    <td>
                        <a href="tel:<?= $customer['phone'] ?>">
                            <?= htmlspecialchars($customer['phone']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($customer['address'] ?? '-') ?></td>
                    <td><?= date('d/m/Y', strtotime($customer['created_at'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/customer/edit/<?= $customer['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/customer/delete/<?= $customer['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
