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
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $category }}</h3>

              <p>
                Total Kategori
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-cube"></i>
            </div>
            <a href="/categories" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ $product }}</h3>

              <p>
                Total Produk
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-cubes"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{ $member }}</h3>

              <p>
                Total Member
              </p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $supplier }}</h3>

              <p>
                Supplier
              </p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row mb-5">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable" style="overflow-x: auto;">
          <!-- Custom tabs (Charts with tabs)-->
          <div id="chart_div" style="width: 100%; height: 500px;"></div>
          <!-- /.card -->

        </section>
      </div>
      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

  google.charts.load('current', {
    'packages': ['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Tanggal', 'Pendapatan', 'Pengeluaran'],
      @foreach($earning as $e)
        ["{{ $e['date'] }}", {{ $e['sale']}}, {{ $e['expense'] }} ],
      @endforeach
    ]);

    var options = {
      title: 'Penjualan {{ date("01-m-Y") }} s/d {{ date("d-m-Y", strtotime("-1 day", strtotime(date("Y-m-d")) )) }}',
      hAxis: {
        title: 'Tanggal',
        titleTextStyle: {
          color: '#333'
        }},
      vAxis: {
        minValue: 0
      }
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
  
  $(window).resize(function() {
    drawChart()
  })
  
</script>
@endsection