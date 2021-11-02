@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Member</h1>
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
        <button class="btn btn-success" onclick="addForm('/members')"> Tambah</button>
        <button class="btn btn-danger" id="delete_all" onclick="delete_all('/delete_all_products')">Hapus Banyak</button>
        <button class="btn btn-info" onclick="print_barcode('/print_barcode')">Cetak Kartu</button>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
          <form class="form-product" action="" method="post">
            @csrf
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>
                  <input type="checkbox" id="select_all" style="position:relative">
                </th>
                <th style="width: 5%;">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th style="style: 15%;"><i class="fas fa-cog"></i></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          </form>
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
@include('admin.member.form')

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
      $('#modal-form .modal-title').text('Tambah Member')
      $('#modal-form form .invalid-feedback').html('')
      $('#modal-form form input').removeClass('is-invalid')
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
          console.log(msg)
          if(msg.errors.code) {
            $('#modal-form form [name=code]').addClass('is-invalid')
            $('#modal-form form .code .invalid-feedback').html(msg.errors.code)
          }
          
          if(msg.errors.name) {
            $('#modal-form form [name=name]').addClass('is-invalid')
            $('#modal-form form .name .invalid-feedback').html(msg.errors.name)
          }
          
          if(msg.errors.phone) {
            $('#modal-form form [name=phone]').addClass('is-invalid')
            $('#modal-form form .phone .invalid-feedback').html(msg.errors.phone)
          }
          
          if(msg.errors.address) {
            $('#modal-form form [name=addClass]').addClass('is-invalid')
            $('#modal-form form .address .invalid-feedback').html(msg.errors.address)
          }
          
        }
      })
  })
    
    //get product
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_members',
      columns: [
          {"data" : "select_all", "sortable" : false, "searchable" : false,
            "ordering" : false
          },
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "code",
            "searchable" : false,
            "sortable" : false
          },
          {"data" : "name"},
          {"data" : "phone", "searchable" : false, "sortable" : false},
          {"data" : "address", "searchable" : false, "sortable" : false},
          {"data" : "aksi", "searchable" : false, "sortable" : false},
        ]
    })
    
    //edit category
    function editForm(url) {
      $('#modal-form').modal('show')
      $('#modal-form .modal-title').text('Edit Produk')
      $('#modal-form form')[0].reset()
      $('#modal-form .invalid-feedback').text('')
      $('#modal-form input').removeClass('is-invalid')
      $('#modal-form [name=_method]').val('put')
      $('#modal-form form').attr('action', url)

      $.ajax({
        type: 'get',
        url: url,
        success: function(data) {
          $('#modal-form form [name=name]').val(data.name)
          $('#modal-form form [name=code]').val(data.code)
          $('#modal-form form [name=category_id]').val(data.category_id)
          $('#modal-form form [name=stock]').val(data.stock)
          $('#modal-form form [name=purchase_price]').val(data.purchase_price)
          $('#modal-form form [name=selling_price]').val(data.selling_price)
          $('#modal-form form [name=discount]').val(data.discount)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menampilkan data')
        }
      })
    }
    
    //delete category
    function deleteForm(url) {
      
      if(confirm('Yakin mau menghapus produk?')) {
      
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
          makeAlert('error', 'Gagal!', 'Gagal menghapus produk')
        }
      })
    
      }
    
    }
    
    //select all 
    $('#select_all').on('click', function() {
      $(':checkbox').prop('checked', this.checked)
    })
    
    function delete_all(url) {
      if($('.form-product input:checked').length < 1) {
        makeAlert('warning', 'Perhatian!', 'Silahkan pilih produk')
        return false
      }
      
      if(confirm('Yakin mau menghapus produk terpilih?')) {
        
        $.post(url, $('.form-product').serialize())
        .done(data => {
          makeAlert('success', 'Berhasil', data)
          table.ajax.reload()
        })
        .fail(xhr => {
          makeAlert('error', 'Gagal!', 'Gagal menghapus data')
        })
        }
      
    }
    
    //print Barcode
    function print_barcode(url) {
       if($('.form-product tbody input:checked').length < 3) {
         makeAlert('warning', 'Perhatian!', 'Minimal pilih 3 produk')
         return false
       }
       
       $('.form-product').attr('action', url)
         .attr('target', '_blank')
         .submit()
    }
 
</script>
@endsection