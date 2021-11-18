@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Daftar Pembelian</h1>
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
        <button class="btn btn-success" onclick="addForm('/suppliers')"> <i class="fas fa-plus-circle"></i> Transaksi Baru</button>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Total Item</th>
                <th>Total Harga</th>
                <th>Diskon</th>
                <th>Total Bayar</th>
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
@include('admin.purchase.form')
@include('admin.purchase.item')

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
  function addForm() {
      $('#supplier-list').modal('show')
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

          if(msg.errors.name) {
            $('#modal-form form [name=name]').addClass('is-invalid')
            $('#modal-form form .name .invalid-feedback').html(msg.errors.name)
          }
          
          if(msg.errors.phone) {
            $('#modal-form form [name=phone]').addClass('is-invalid')
            $('#modal-form form .phone .invalid-feedback').html(msg.errors.phone)
          }
          
          if(msg.errors.address) {
            $('#modal-form form [name=address]').addClass('is-invalid')
            $('#modal-form form .address .invalid-feedback').html(msg.errors.address)
          }
          
        }
      })
  })
    
    //get product
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_purchases',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "created_at"},
          {"data" : "supplier.name", "searchable" : false, "sortable" : false},
          {"data" : "total_item", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "total_price", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "discount", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "paid", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "aksi", 
            "searchable" : false,
            "sortable" : false, 
          }
        ],
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
          $('#modal-form form [name=phone]').val(data.phone)
          $('#modal-form form [name=address]').val(data.address)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menampilkan data')
        }
      })
    }
    
    //delete purchase
    function deletePurchase(id) {
      
      if(confirm('Membatalkan pembelian akan mengembalikan stok produk ke semula, yakin mau dibatalkan?')) {
      
      $.ajax({
        type: 'delete',
        url: '/purchases/' + id,
        data: {
          '_token': '{{ csrf_token() }}',
          '_method': 'delete'
        },
        success: function(data) {
          makeAlert('success', 'Berhasil!', data)
          table.ajax.reload()
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menghapus pembelian')
        }
      })
    
      }
    
    }
    
    $('#supplierTable').DataTable()
    
    //item purchase 
    function itemPurchase(id) {
      $('#modal-item #itemTable').DataTable().destroy()
      $('#modal-item').modal('show')
      $('#modal-item #itemTable').DataTable({
        ajax: '/item_purchase/' + id,
        columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "code", "searchable" : false, "sortable" : false},
          {"data" : "name", "searchable" : false, "sortable" : false},
          {"data" : "qty", "searchable" : false, "sortable" : false},
          {"data" : "purchase_price", "searchable" : false, "sortable" : false},
          {"data" : "subtotal", "searchable" : false, "sortable" : false},
          ]
      })
    }
    
</script>
@endsection