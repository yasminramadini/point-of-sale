@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Penjualan</h1>
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
      
      <form method="post" action="/sales">
        @csrf
        <button type="submit" class="btn btn-success my-3"><i class="fas fa-plus-circle"></i>Tambah Transaksi</button>
      </form>
      
      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Kode Member</th>
                <th>Total Item</th>
                <th>Total Harga</th>
                <th>Diskon Member</th>
                <th>Total Bayar</th>
                <th>Diterima</th>
                <th>Kasir</th>
                <th style="style: 15%;"><i class="fas fa-cog"></i></th>
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

@include('admin.sale.item')

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

   //make alert
    function makeAlert(type, title, body) {
      Swal.fire({
        icon: type,
        title: title,
        text: body
      })
    }
  
    //get sales
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_sales',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "tanggal"},
          {"data" : "member.code", "defaultContent": "<i class='text-center text-muted'>none</i>"},
          {"data" : "total_item", "searchable" : false, "sortable" : false},
          {"data" : "total_price", "searchable" : false, "sortable" : false},
          {"data" : "discount", "searchable" : false, "sortable" : false},
          {"data" : "paid", "searchable" : false, "sortable" : false},
          {"data" : "accepted", "searchable" : false, "sortable" : false},
          {"data" : "user.name", "searchable" : false, "sortable" : false},
          {"data" : "aksi", "sortable" : false, "searchable" : false}
        ]
    })
    
    function salePreview(url) {
      $('#modal-item #itemTable').DataTable().destroy()
      $('#modal-item').modal('show')
      $('#modal-item #itemTable').DataTable({
        ajax: url,
        columns: [
          {
            "data": "DT_RowIndex",
            "searchable": false,
            "sortable": false
          },
          {
            "data": "code",
            "searchable": false,
            "sortable": false
          },
          {
            "data": "name"
          },
          {
            "data": "qty",
            "searchable": false,
            "sortable": false
          },
          {
            "data": "selling_price",
            "searchable": false,
            "sortable": false
          },
          {
            "data": "discount",
            "searchable": false,
            "sortable": false
          },
          {
            "data": "subtotal",
            "searchable": false,
            "sortable": false
          },
        ]
      })
    }
    
    //delete category
    function deleteSale(url) {
      
      if(confirm('Yakin mau membatalkan penjualan? Stok produk akan dikembalikan seperti semual')) {
      
      $.ajax({
        type: 'delete',
        url: url,
        data: {
          '_token': '{{ csrf_token() }}',
          '_method': 'delete'
        },
        success: function(data) {
          makeAlert('success', 'Berhasil!', data)
          table.ajax.reload() 
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menghapus pengeluaran')
        }
      })
    
      }
    
    }
    
</script>
@endsection