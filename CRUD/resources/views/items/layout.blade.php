<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Fleet Lister — Premium Dashboard</title>
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6.5.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <style>
        :root {
            --bg-gradient-start: #0b0f19;
            --bg-gradient-end: #151c2c;
            --card-bg: rgba(26, 32, 49, 0.65);
            --card-border: rgba(255, 255, 255, 0.08);
            --primary-glow: rgba(99, 102, 241, 0.15);
            --primary-accent: #6366f1;
            --primary-accent-hover: #4f46e5;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --success-accent: #10b981;
            --danger-accent: #ef4444;
            --warning-accent: #f59e0b;
            --info-accent: #06b6d4;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e1e38 0%, var(--bg-gradient-start) 50%, var(--bg-gradient-end) 100%);
            background-color: var(--bg-gradient-start);
            color: var(--text-main);
            min-height: 100vh;
            padding-bottom: 3rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Glassmorphism Background Accent Glows */
        body::before {
            content: '';
            position: absolute;
            top: -150px;
            left: -150px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: absolute;
            top: 20%;
            right: -200px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.15) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .main-container {
            position: relative;
            z-index: 2;
        }

        /* Sleek Navbar */
        .dashboard-header {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 2rem;
            border-radius: 16px;
            margin-top: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .brand-link {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
            color: var(--text-main);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            color: var(--primary-accent);
            transform: translateY(-1px);
        }

        .brand-icon-wrapper {
            background: linear-gradient(135deg, var(--primary-accent), var(--info-accent));
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        }

        /* Glassmorphic Premium Cards */
        .premium-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
            padding: 2.25rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .premium-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-accent), var(--info-accent));
            opacity: 0.8;
        }

        /* Typography */
        h2.premium-heading {
            font-weight: 800;
            font-size: 1.85rem;
            letter-spacing: -0.5px;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .sub-header {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        /* Elegant Stat Panels */
        .stat-card {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        /* Buttons styling */
        .btn-modern {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }

        .btn-modern-primary {
            background: linear-gradient(135deg, var(--primary-accent), var(--primary-accent-hover));
            color: #fff;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
        }

        .btn-modern-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
            color: #fff;
        }

        .btn-modern-warning {
            background: linear-gradient(135deg, var(--warning-accent), #d97706);
            color: #fff;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25);
        }

        .btn-modern-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
            color: #fff;
        }

        .btn-modern-secondary {
            background: rgba(71, 85, 105, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
        }

        .btn-modern-secondary:hover {
            background: rgba(71, 85, 105, 0.7);
            color: var(--text-main);
            transform: translateY(-2px);
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none !important;
            border: none;
        }

        .btn-action-info {
            background: rgba(6, 182, 212, 0.15);
            color: var(--info-accent);
        }

        .btn-action-info:hover {
            background: var(--info-accent);
            color: #000;
            transform: scale(1.1);
        }

        .btn-action-primary {
            background: rgba(99, 102, 241, 0.15);
            color: var(--primary-accent);
        }

        .btn-action-primary:hover {
            background: var(--primary-accent);
            color: #fff;
            transform: scale(1.1);
        }

        .btn-action-danger {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger-accent);
        }

        .btn-action-danger:hover {
            background: var(--danger-accent);
            color: #fff;
            transform: scale(1.1);
        }

        /* Beautiful Tables */
        .premium-table-wrapper {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            background: rgba(15, 23, 42, 0.3);
        }

        .premium-table {
            margin-bottom: 0;
            color: var(--text-main);
            background-color: transparent !important;
        }

        .premium-table th {
            background: rgba(30, 41, 59, 0.6) !important;
            border-bottom: 1px solid var(--card-border) !important;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1.2rem 1.5rem;
        }

        .premium-table td {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .premium-table tbody tr {
            transition: all 0.25s ease;
        }

        .premium-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02) !important;
        }

        /* Dynamic badging */
        .category-badge {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: 30px;
            display: inline-block;
            text-transform: capitalize;
        }

        .badge-Economy { background: rgba(16, 185, 129, 0.15); color: var(--success-accent); border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-Compact { background: rgba(6, 182, 212, 0.15); color: var(--info-accent); border: 1px solid rgba(6, 182, 212, 0.2); }
        .badge-SUV { background: rgba(99, 102, 241, 0.15); color: var(--primary-accent); border: 1px solid rgba(99, 102, 241, 0.2); }
        .badge-Luxury { background: rgba(245, 158, 11, 0.15); color: var(--warning-accent); border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-Electric { background: rgba(139, 92, 246, 0.15); color: #a78bfa; border: 1px solid rgba(139, 92, 246, 0.2); }
        .badge-Van { background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.2); }

        .badge-fallback {
            background: rgba(148, 163, 184, 0.15);
            color: var(--text-muted);
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        /* Form styling */
        .form-control-modern {
            background: rgba(15, 23, 42, 0.5) !important;
            border: 1px solid var(--card-border) !important;
            color: var(--text-main) !important;
            border-radius: 10px;
            padding: 0.75rem 1.1rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-modern:focus {
            outline: none !important;
            border-color: var(--primary-accent) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
        }

        .form-label-modern {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        /* Alert and feedback styling */
        .alert-modern {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-left: 4px solid var(--success-accent);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Pagination style adjustments */
        .pagination {
            gap: 5px;
            margin-top: 1.5rem;
            margin-bottom: 0;
            justify-content: flex-end;
        }

        .pagination .page-item .page-link {
            background: rgba(30, 41, 59, 0.4) !important;
            border: 1px solid var(--card-border) !important;
            color: var(--text-main) !important;
            border-radius: 8px !important;
            padding: 0.55rem 0.95rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-accent), var(--primary-accent-hover)) !important;
            border-color: transparent !important;
            box-shadow: 0 0 12px rgba(99, 102, 241, 0.35);
        }

        .pagination .page-item:hover:not(.active) .page-link {
            background: rgba(99, 102, 241, 0.15) !important;
            border-color: rgba(99, 102, 241, 0.4) !important;
            color: var(--primary-accent) !important;
        }

        .pagination .page-item.disabled .page-link {
            background: rgba(30, 41, 59, 0.15) !important;
            border-color: rgba(255, 255, 255, 0.02) !important;
            color: rgba(255, 255, 255, 0.15) !important;
        }
    </style>
</head>
<body>
    <div class="container main-container">
        <!-- Dashboard Sleek Navbar -->
        <header class="dashboard-header">
            <a href="{{ route('items.index') }}" class="brand-link">
                <div class="brand-icon-wrapper">
                    <i class="fa fa-car"></i>
                </div>
                <span>CAR FLEET <span style="font-weight: 300; color: var(--text-muted)">LISTER</span></span>
            </a>
            <div class="d-none d-md-flex align-items-center gap-3">
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-3">
                    <i class="fa fa-circle-check me-1"></i> Live Connection
                </span>
            </div>
        </header>

        <!-- Main Dynamic Content Injection -->
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
