<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="/image/{{ $setting->logo }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ $setting->company_name }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="@if(auth()->user()->avatar !== null) image/{{ auth()->user()->avatar }} @else image/avatar.png @endif" class="img-circle elevation-2 img-avatar" alt="User Image">
      </div>
      <div class="info">
        <span class="d-block text-username text-white">{{ Auth::user()->username }}</span>
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
        @can('admin')
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
            <a href="/purchases" class="nav-link @if(request()->is('purchases')) active @endif">
              <i class="nav-icon fas fa-download"></i>
              <p>
                Daftar Pembelian
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/purchase_detail" class="nav-link @if(request()->is('purchase_detail')) active @endif">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Transaksi Pembelian
              </p>
            </a>
          </li>
          @endcan
          <li class="nav-item">
            <a href="/sales" class="nav-link @if(request()->is('sales')) active @endif">
              <i class="nav-icon fas fa-upload"></i>
              <p>
                Daftar Penjualan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/transaction" class="nav-link @if(request()->is('transaction')) active @endif">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Transaksi Penjualan
              </p>
            </a>
          </li>
          @can('admin')
          <li class="nav-header">LAPORAN</li>
          <li class="nav-item">
            <a href="/report" class="nav-link @if(request()->is('report')) active @endif">
              <i class="nav-icon far fa-file"></i>
              <p>
                Data Laporan
              </p>
            </a>
          </li>
          <li class="nav-header">KONFIGURASI</li>
          <li class="nav-item">
            <a href="/setting" class="nav-link @if(request()->is('setting')) active @endif">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Pengaturan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/user" class="nav-link @if(request()->is('user')) active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li>
          @endcan
          <li class="nav-item">
            <a href="/profil" class="nav-link @if(request()->is('profil')) active @endif">
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