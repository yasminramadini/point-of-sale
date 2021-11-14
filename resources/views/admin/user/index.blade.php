@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar User</h1>
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
    <div class="container-fluid mb-5">
      
      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
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
@include('admin.user.form')

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
      $('#modal-form .modal-title').text('Detail User')
      $('#modal-form form .invalid-feedback').html('')
      $('#modal-form form input').removeClass('is-invalid')
      $('#modal-form form textarea').removeClass('is-invalid')
      $('#modal-form form').attr('action', url)
      $('#modal-form form [name=_method]').val('put')
      
      $.ajax({
        type: 'get',
        url: url,
        data: $('#modal-form form').serialize(),
        success: function(data) {
          $('#modal-form form [name=username]').val(data.username)
          $('#modal-form form [name=name]').val(data.name)
          $('#modal-form form [name=email]').val(data.email)
          $('#modal-form form [name=role]').val(data.role)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menampilkan data')
        }
      })
    }
    
    //update role
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
          makeAlert('error', 'Gagal!', 'Gagal mengubah role')
        }
        
      })
  })
    
    //get user
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_user',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "username"},
          {"data" : "name"},
          {"data" : "email", "searchable" : false, "sortable" : false},
          {"data" : "aksi", "sortable" : false, "searchable" : false}
        ]
    })
    
    //delete user
    function deleteForm(url) {
      
      if(confirm('Yakin mau menghapus user?')) {
      
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
          makeAlert('error', 'Gagal!', 'Gagal menghapus user')
        }
      })
    
      }
    
    }
</script>
@endsection