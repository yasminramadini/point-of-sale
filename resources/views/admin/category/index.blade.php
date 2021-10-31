@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kategori</h1>
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
      
      <button class="btn btn-success" id="addForm"><i class="fas fa-plus-circle"></i> Tambah</button>

      <div class="card mt-3">
        <div class="card-body table-responsive">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Nama</th>
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
@include('admin.category.form')

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>
  $(function () {
    
    //make alert
    function makeAlert(type, title, body) {
      Swal.fire({
        icon: type,
        title: title,
        text: body
      })
    }
    
    //get category
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_categories',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "name"},
          {"data" : "aksi", "searchable" : false, "sortable" : false}
        ]
    })
    
    //add category
    $('#addForm').click(function() {
      $('#modal-form').modal('show')
      $('#modal-form form')[0].reset()
      $('#modal-form .modal-title').text('Tambah Kategori')
      $('#modal-form form .invalid-feedback').html('')
      $('#modal-form form [name=name]').removeClass('is-invalid')
    })
    
    $('#modal-form').submit(function(event) {
      event.preventDefault()
      
      $.ajax({
        url: '/categories',
        type: 'post',
        data: $('#modal-form form').serialize(),
        success: function(data) {
          makeAlert('success', 'Berhasil!', 'Kategori berhasil ditambahkan')
          $('#modal-form').modal('hide')
          table.ajax.reload()
        },
        error: function(xhr) {
          var msg = JSON.parse(xhr.responseText)
          $('#modal-form form [name=name]').addClass('is-invalid')
          $('#modal-form form .invalid-feedback').html(msg.errors.name)
        }
      })
      
    })
      
})
</script>
@endsection