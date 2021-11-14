@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Laporan Tanggal <span id="startPeriod"></span> s/d <span id="endPeriod"></span></h1>
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
      
      <div class="btn-group">
        <button class="btn btn-info" onclick="updatePeriode()"> <i class="fas fa-calendar"></i> Ubah Periode</button>
        <a href="" class="btn btn-success" id="printExcel" target="_blank">
          <i class="fas fa-file"></i> Export ke Excel
        </a>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          
        </div>
        <!-- /.card-body -->
      </div>

      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<!-- modal form -->
@include('admin.report.form')

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

  $('#modal-form #enddate').attr('max', '{{ date("Y-m-d") }}')
  $('#modal-form #startdate').attr('max', '{{ date("Y-m-d") }}')

   //make alert
    function makeAlert(type, title, body) {
      Swal.fire({
        icon: type,
        title: title,
        text: body
      })
    }
  
  //triger form add
  function updatePeriode() {
      $('#modal-form').modal('show')
  }
  
  //get report 
  function getReport(startdate, enddate) {
      $('#dataTable').DataTable().destroy()
      
      var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_report/' + startdate + '/' + enddate,
      columns: [
          {"data" : "DT_RowIndex"},
          {"data" : "date"},
          {"data" : "sale"},
          {"data" : "purchase"},
          {"data" : "expense"},
          {"data" : "earning"}
        ],
      paging: false,
      ordering: false,
      searching: false,
      info: false
    })
    
    $('#startPeriod').text(startdate)
    $('#endPeriod').text(enddate)

    $('#printExcel').attr('href', '/report/print/' + startdate + '/' + enddate)
  }
  
  getReport("{{ date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y') )) }}", "{{ date('Y-m-d') }}")
    
    //periode diubah
    $('#modal-form form').on('submit', function(e) {
      e.preventDefault()
      
      $('#modal-form').modal('hide')
      
      getReport( $('#modal-form form [name=startdate]').val(), $('#modal-form form [name=enddate]').val() )
      
    })
    
</script>
@endsection