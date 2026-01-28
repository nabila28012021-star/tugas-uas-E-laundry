<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Paket Laundry</h3>
            </div>
            <form action="<?= BASE_URL ?>/package/update/<?= $package['id'] ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Paket <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($package['name']) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Tipe Harga <span class="text-danger">*</span></label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="kg" <?= $package['type'] === 'kg' ? 'selected' : '' ?>>Per Kilogram (Kg)</option>
                            <option value="satuan" <?= $package['type'] === 'satuan' ? 'selected' : '' ?>>Per Satuan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control" id="price" name="price" required min="0" step="500" value="<?= $package['price'] ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($package['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" <?= $package['is_active'] ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                    <a href="<?= BASE_URL ?>/package" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
