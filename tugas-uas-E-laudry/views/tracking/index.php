<!-- Hero Section -->
<div class="hero-section text-white text-center">
    <div class="container">
        <h1 class="hero-title">
            <i class="fas fa-search me-2"></i>
            Lacak Status Laundry Anda
        </h1>
        <p class="opacity-75">Masukkan kode invoice untuk melacak status laundry</p>
    </div>
</div>

<!-- Search Form -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="search-card">
                <?php
                $flash = Session::getAllFlash();
                if (!empty($flash)):
                    foreach ($flash as $type => $message):
                ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show mb-4">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= $message ?>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
                
                <form action="<?= BASE_URL ?>/tracking/search" method="get">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-lg" name="code" placeholder="Masukkan kode invoice (contoh: INV-20260126-0001)" required autofocus>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-search me-2"></i> Lacak
                            </button>
                        </div>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Kode invoice dapat ditemukan pada struk/nota laundry Anda
                    </p>
                </div>
            </div>
            
            <!-- How it works -->
            <div class="row mt-5 text-center">
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="text-primary mb-3" style="font-size: 48px;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h5>1. Siapkan Nota</h5>
                        <p class="text-muted">Siapkan struk/nota laundry yang diberikan saat penyerahan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="text-primary mb-3" style="font-size: 48px;">
                            <i class="fas fa-keyboard"></i>
                        </div>
                        <h5>2. Masukkan Kode</h5>
                        <p class="text-muted">Masukkan kode invoice yang tertera pada nota</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4">
                        <div class="text-primary mb-3" style="font-size: 48px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h5>3. Lihat Status</h5>
                        <p class="text-muted">Status laundry Anda akan ditampilkan secara real-time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
