<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Kode Promo</h3>
            </div>
            <form action="<?= BASE_URL ?>/promo/store" method="post">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="code">Kode Promo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control text-uppercase" id="code" name="code" required placeholder="PROMO2024" style="text-transform: uppercase;">
                                <small class="text-muted">Kode akan otomatis menjadi huruf besar</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Promo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Diskon Tahun Baru">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_type">Tipe Diskon <span class="text-danger">*</span></label>
                                <select class="form-control" id="discount_type" name="discount_type" required>
                                    <option value="percent">Persentase (%)</option>
                                    <option value="fixed">Nominal (Rp)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_value">Nilai Diskon <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="discount_value" name="discount_value" required min="0" step="0.01" placeholder="10">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="min_purchase">Minimum Pembelian</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" id="min_purchase" name="min_purchase" min="0" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="max_discount">Maksimal Diskon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" id="max_discount" name="max_discount" min="0" placeholder="Kosongkan jika tidak ada batas">
                                </div>
                                <small class="text-muted">Hanya berlaku untuk diskon persentase</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valid_from">Berlaku Dari <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="valid_from" name="valid_from" required value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valid_until">Berlaku Sampai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="valid_until" name="valid_until" required value="<?= date('Y-m-d', strtotime('+1 month')) ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <a href="<?= BASE_URL ?>/promo" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
