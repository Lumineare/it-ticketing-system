<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Ticketing System</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            color: #334155;
            font-size: .875rem; 
        }
        
        /* Sidebar Styling */
        .sidebar { 
            position: fixed; 
            top: 0; 
            bottom: 0; 
            left: 0; 
            z-index: 100; 
            padding: 48px 0 0; 
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); 
            background-color: #ffffff;
        }
        .sidebar-sticky { 
            position: relative; 
            top: 0; 
            height: calc(100vh - 48px); 
            padding-top: .5rem; 
            overflow-x: hidden; 
            overflow-y: auto; 
        }
        
        .nav-link { 
            font-weight: 500; 
            color: #64748b; 
            padding: 0.75rem 1rem;
            margin: 0.2rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link .bi { 
            margin-right: .5rem; 
            color: #94a3b8; 
        }
        .nav-link:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }
        .nav-link.active { 
            color: #ffffff; 
            background-color: #2563eb;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
        }
        .nav-link.active .bi { 
            color: #ffffff; 
        }
        
        /* Top Navbar Branding */
        .navbar-brand { 
            padding-top: .75rem; 
            padding-bottom: .75rem; 
            font-size: 1rem; 
            background-color: rgba(0, 0, 0, .25); 
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25); 
        }
        header.navbar {
            background-color: #0f172a !important; /* Dark slate */
        }
        
        main { 
            padding-top: 60px; 
        }

        /* Common component overrides */
        .page-header {
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .page-header h2 {
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin-bottom: 0.5rem;
        }
        .page-header p {
            color: #64748b;
            margin-bottom: 0;
        }
        
        .card-custom {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 fw-bold" href="/">
    <i class="bi bi-headset me-2 text-primary"></i> IT Support
  </a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav w-100 d-flex flex-row justify-content-end align-items-center pe-3">
    <!-- Navbar Right Items (Optional) -->
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <!-- Public Sidebar -->
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
      <div class="position-sticky sidebar-sticky mt-3">
        
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-4 mt-2 mb-2 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
          <span>Layanan Utama</span>
        </h6>
        
        <ul class="nav flex-column mb-4">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
              <i class="bi bi-list-ul"></i> Antrean Tiket Aktif
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('ticket/create') ? 'active' : '' }}" href="{{ route('ticket.create') }}">
              <i class="bi bi-plus-circle"></i> Buat Tiket Baru
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('tickets-completed') ? 'active' : '' }}" href="{{ route('tickets.completed') }}">
              <i class="bi bi-archive"></i> Riwayat Tiket Selesai
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-4 mt-2 mb-2 text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
          <span>Admin & Teknisi</span>
        </h6>
        
        <ul class="nav flex-column">
          <li class="nav-item">
            <!-- Jika User sudah login, ubah link ke Dashboard. Jika belum, ke form Login -->
            @auth
              <a class="nav-link text-primary" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2 text-primary"></i> Kembali ke Dashboard
              </a>
            @else
              <a class="nav-link text-secondary" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i> Login Tim IT
              </a>
            @endauth
          </li>
        </ul>

      </div>
    </nav>

    <!-- Main Content Area -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
      @if(session('success'))
          <div class="alert alert-success mt-4 alert-dismissible bg-success text-white border-0 shadow-sm fade show" role="alert">
              <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      @endif

      @yield('content')
    </main>
    
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
