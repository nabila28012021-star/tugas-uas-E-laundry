<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar User</h3>
        <div class="card-tools">
            <a href="<?= BASE_URL ?>/user/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover datatable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $i => $user): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <code><?= htmlspecialchars($user['username']) ?></code>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($user['name']) ?></strong>
                    </td>
                    <td>
                        <?php if ($user['role'] === 'admin'): ?>
                        <span class="badge badge-danger">Admin</span>
                        <?php else: ?>
                        <span class="badge badge-info">Kasir</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($user['is_active']): ?>
                        <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                        <span class="badge badge-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/user/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
