<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? 'Lacak Laundry' ?> | Laundry Tunas Bangsa</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .navbar {
            background: var(--primary-gradient);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
        }
        
        .hero-section {
            background: var(--primary-gradient);
            padding: 60px 0 100px;
            margin-bottom: -50px;
        }
        
        .hero-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .search-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }
        
        .form-control-lg {
            border-radius: 12px;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            font-size: 16px;
        }
        
        .form-control-lg:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        
        .result-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-top: 30px;
        }
        
        .status-timeline {
            display: flex;
            justify-content: space-between;
            position: relative;
            padding: 20px 0;
            margin: 30px 0;
        }
        
        .status-timeline::before {
            content: '';
            position: absolute;
            top: 35px;
            left: 5%;
            right: 5%;
            height: 4px;
            background: #e0e0e0;
            z-index: 1;
            border-radius: 2px;
        }
        
        .status-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }
        
        .status-step .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .status-step.active .step-icon {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            animation: pulse 2s infinite;
        }
        
        .status-step.completed .step-icon {
            background: var(--secondary-gradient);
        }
        
        .status-step .step-label {
            font-size: 12px;
            color: #888;
            text-align: center;
            font-weight: 500;
        }
        
        .status-step.active .step-label,
        .status-step.completed .step-label {
            color: #333;
            font-weight: 600;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.5); }
            70% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
            100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
        }
        
        .invoice-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 600;
            display: inline-block;
        }
        
        .info-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .item-row {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .item-row:last-child {
            border-bottom: none;
        }
        
        .total-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .badge-status {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }
        
        footer {
            background: #1e1e2d;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        @media (max-width: 768px) {
            .status-timeline {
                flex-direction: column;
                align-items: flex-start;
                padding-left: 20px;
            }
            
            .status-timeline::before {
                left: 18px;
                top: 0;
                bottom: 0;
                width: 4px;
                height: auto;
            }
            
            .status-step {
                flex-direction: row;
                margin-bottom: 20px;
            }
            
            .status-step .step-icon {
                margin-bottom: 0;
                margin-right: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="<?= BASE_URL ?>/tracking">
                <i class="fas fa-tshirt me-2"></i>Laundry Tunas Bangsa
            </a>
            <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline-light btn-sm">
                <i class="fas fa-sign-in-alt me-1"></i> Login Staff
            </a>
        </div>
    </nav>
    
    <?= $content ?>
    
    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> Laundry Tunas Bangsa. Sistem Manajemen Laundry.</p>
        </div>
    </footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
