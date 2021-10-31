@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Produk</h1>
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
      
      <button class="btn btn-success" onclick="addForm('/products')"><i class="fas fa-plus-circle"></i> Tambah</button>

      <div class="card mt-3">
        <div class="card-body table-responsive">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Diskon</th>
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

<!-- modal form -->
@include('admin.product.form')

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
  
  //triger form add
  function addForm(url) {
      $('#modal-form').modal('show')
      $('#modal-form form')[0].reset()
      $('#modal-form .modal-title').text('Tambah Produk')
      $('#modal-form form .invalid-feedback').html('')
      $('#modal-form form input').removeClass('is-invalid')
      $('#modal-form form').attr('action', '/products')
      $('#modal-form form [name=_method]').val('post')
    }
    
    //submit form
    $('#modal-form form').submit(function(event) {
      event.preventDefault()
      
      $.ajax({
        url: $(this).attr('action'),
        type: $('#modal-form form [name=_method]').val(),
        data: $('#modal-form form').serialize(),
        success: function(data) {
          makeAlert('success', 'Berhasil!', data)
          $('#modal-form').modal('hide')
          table.ajax.reload()
        },
        error: function(xhr) {
          var msg = JSON.parse(xhr.responseText)
          $('#modal-form form [name=name]').addClass('is-invalid')
          $('#modal-form form .invalid-feedback').html(msg.errors.name)
          console.log(msg)
        }
      })
  })
    
    //get category
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_products',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "name"},
          {"data" : "category.name", "searchable" : false, "sortable" : false},
          {"data" : "stock", "searchable" : false, "sortable" : false},
          {"data" : "purchase_price", "searchable" : false, "sortable" : false},
          {"data" : "selling_price", "searchable" : false, "sortable" : false},
          {"data" : "discount", "searchable" : false, "sortable" : false},
          {"data" : "aksi", "searchable" : false, "sortable" : false},
        ]
    })
    
    //edit category
    function editForm(url) {
      $('#modal-form').modal('show')
      $('#modal-form .modal-title').text('Edit Kategori')
      $('#modal-form form')[0].reset()
      $('#modal-form .invalid-feedback').text('')
      $('#modal-form [name=name]').removeClass('is-invalid')
      $('#modal-form [name=_method]').val('put')
      $('#modal-form form').attr('action', url)
      console.log($('#modal-form form').attr('action'))

      $.ajax({
        type: 'get',
        url: url,
        success: function(data) {
          $('#modal-form form [name=name]').val(data.name)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menampilkan data')
        }
      })
    }
    
    //delete category
    function deleteForm(url) {
      
      if(confirm('Yakin mau menghapus kategori?')) {
      
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
          makeAlert('error', 'Gagal!', 'Gagal menghapus kategori')
        }
      })
    
      }
    
    }
</script>
@endsection