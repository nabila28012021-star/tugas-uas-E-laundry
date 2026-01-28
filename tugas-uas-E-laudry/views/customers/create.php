<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Pelanggan</h3>
            </div>
            <form action="<?= BASE_URL ?>/customer/store" method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Nama pelanggan">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" required placeholder="08xxxxxxxxxx">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Alamat lengkap..."></textarea>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="<?= BASE_URL ?>/customer" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
