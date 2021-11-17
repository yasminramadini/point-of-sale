@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content bg-white p-4 text-center">
    <div class="container-fluid">
      <!-- /.row -->
      <!-- Main row -->
      <h1 class="text-center">Halo, {{ auth()->user()->name }}!</h1>
      <p class="text-center">Anda login sebagai kasir. Jika ingin membuat transaksi baru, silahkan klik tombol berikut:</p>
      <a href="/sales" class="btn btn-primary text-center"><i class="fas fa-money"></i> Buat Transaksi</a>
      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection