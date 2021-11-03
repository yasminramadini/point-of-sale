<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">ePos</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->username }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="/" class="nav-link @if(request()->is('/')) active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-header">MASTER</li>
        <li class="nav-item">
          <a href="/categories" class="nav-link @if(request()->is('categories')) active @endif">
            <i class="nav-icon fas fa-cube"></i>
            <p>
              Kategori
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/products" class="nav-link @if(request()->is('products')) active @endif">
            <i class="nav-icon fas fa-cubes"></i>
            <p>
              Produk
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/members" class="nav-link @if(request()->is('members')) active @endif">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Member
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/suppliers" class="nav-link @if(request()->is('suppliers')) active @endif">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Supplier
            </p>
          </a>
        </li>
        <li class="nav-header">TRANSAKSI</li>
        <li class="nav-item">
          <a href="/expenses" class="nav-link @if(request()->is('expenses')) active @endif">
            <i class="nav-icon fas fa-money-bill-alt nav-icon"></i>
            <p>
              Pengeluaran
            </p>
          </a>
          <li class="nav-item">
            <a href="pages/UI/general.html" class="nav-link">
              <i class="nav-icon fas fa-download"></i>
              <p>
                Daftar Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/icons.html" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Transaksi Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/buttons.html" class="nav-link">
              <i class="nav-icon fas fa-upload"></i>
              <p>
                Daftar Penjualan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/sliders.html" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Transaksi Penjualan
              </p>
            </a>
          </li>
          <li class="nav-header">LAPORAN</li>
          <li class="nav-item">
            <a href="pages/UI/modals.html" class="nav-link">
              <i class="nav-icon far fa-file"></i>
              <p>
                Laporan
              </p>
            </a>
          </li>
          <li class="nav-header">KONFIGURASI</li>
          <li class="nav-item">
            <a href="pages/UI/navbar.html" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/timeline.html" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/UI/ribbons.html" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Profil
              </p>
            </a>
          </li>
        </li>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>