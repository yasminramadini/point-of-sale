@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pengeluaran</h1>
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
        <button class="btn btn-success" onclick="addForm('/expenses')"> Tambah</button>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Nominal</th>
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
@include('admin.expenses.form')

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
      $('#modal-form .modal-title').text('Tambah Pengeluaran')
      $('#modal-form form .invalid-feedback').html('')
      $('#modal-form form input').removeClass('is-invalid')
      $('#modal-form form textarea').removeClass('is-invalid')
      $('#modal-form form').attr('action', url)
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

          if(msg.errors.description) {
            $('#modal-form form [name=description]').addClass('is-invalid')
            $('#modal-form form .description .invalid-feedback').html(msg.errors.description)
          }
          
          if(msg.errors.nominal) {
            $('#modal-form form [name=nominal]').addClass('is-invalid')
            $('#modal-form form .nominal .invalid-feedback').html(msg.errors.nominal)
          }
          
        }
      })
  })
    
    //get product
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_expenses',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "tanggal"},
          {"data" : "description"},
          {"data" : "nominal", "searchable" : false, "sortable" : false},
          {"data" : "aksi", "sortable" : false, "searchable" : false}
        ]
    })
    
    //edit expenses
    function editForm(url) {
      $('#modal-form').modal('show')
      $('#modal-form .modal-title').text('Edit Pengeluaran')
      $('#modal-form form')[0].reset()
      $('#modal-form .invalid-feedback').text('')
      $('#modal-form input').removeClass('is-invalid')
      $('#modal-form form textarea').removeClass('is-invalid')
      $('#modal-form [name=_method]').val('put')
      $('#modal-form form').attr('action', url)

      $.ajax({
        type: 'get',
        url: url,
        success: function(data) {
          $('#modal-form form [name=description]').val(data.description)
          $('#modal-form form [name=nominal]').val(data.nominal)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menampilkan data')
        }
      })
    }
    
    //delete category
    function deleteForm(url) {
      
      if(confirm('Yakin mau menghapus pengeluaran?')) {
      
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