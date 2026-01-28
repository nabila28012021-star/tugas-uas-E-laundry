<p class="login-box-msg">Masuk ke Sistem Laundry Tunas Bangsa</p>

<form action="<?= BASE_URL ?>/auth/authenticate" method="post">
    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
    
    <div class="input-group mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    
    <div class="input-group mb-4">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </button>
        </div>
    </div>
</form>

<div class="mt-4 text-center">
    <a href="<?= BASE_URL ?>/tracking" class="text-muted">
        <i class="fas fa-search mr-1"></i> Lacak Status Laundry
    </a>
</div>
