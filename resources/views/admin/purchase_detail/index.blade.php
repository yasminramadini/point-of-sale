@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Pembelian</h1>
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
      
      <div class="row">
        <div class="col-md-5">
          <div class="row">
            <div class="col-md-4">
              Kode Produk
            </div>
            <div class="col-md-8">
              <form class="form-product" method="post" action="">
                @csrf
                <input type="hidden" name="product_id">
                <div class="input-group">
                  <input type="text" name="code" class="form-control">
                  <button class="btn btn-info btn-flat" onclick="addForm()" type="button"><i class="fas fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
          <table class="mb-5">
            <tr>
              <td>Nama supplier: {{ $supplier->name }}</td>
            </tr>
            <tr>
              <td>Telepon: {{ $supplier->phone }}</td>
            </tr>
            <tr>
              <td>Alamat: {{ $supplier->address }}</td>
            </tr>
          </table>
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th style="style: 15%;"><i class="fas fa-cog"></i></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          
          <div class="row my-5">
            <div class="col-lg-8 m-4">
              <div class="bg-primary text-center text-white p-3" id="totalrp" style="font-size: 2rem">Rp 0</div>
            </div>
            <div class="col-lg-4 m-4">
              <form id="purchase-form" action="/save_purchase" method="post">
                @csrf 
                <input type="hidden" name="purchase_id" value="{{ session('purchase_id') }}">
                <input type="hidden" name="total_price">
                <div class="mb-3">
                  <label>Total item</label>
                  <input type="number" name="total_item" class="form-control" readonly>
                </div>
                <div class="mb-3">
                  <label>Diskon (%)</label>
                  <input type="number" value="0" class="form-control" name="discount">
                </div>
                <div class="mb-3">
                  <label>Total Bayar</label>
                  <input type="number" class="form-control" name="paid" readonly>
                </div>
                <button class="btn btn-info">Simpan</button>
              </form>
            </div>
          </div>

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
@include('admin.purchase_detail.form')

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

  //get subtotal
  function count_subtotal() {
  $.ajax({
    url: '/count_subtotal',
    success: function(data) {
      $('#totalrp').text(data.price)
      $('#purchase-form [name=discount]').val(data.discount)
      $('#purchase-form [name=total_item]').val(data.total_item)
      $('#purchase-form [name=paid]').val(data.paid)
      $('#purchase-form [name=total_price]').val(data.num_price)
    },
    error: function(xhr) {
      makeAlert('error', 'Gagal!', 'Gagal menghitung subtotal')
    }
  })
  }
  
  count_subtotal()

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
      $('#product-list').modal('show')
    }
    
    //get product
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_purchase_detail',
      columns: [
          {"data" : "DT_RowIndex", "searchable" : false, "sortable" : false},
          {"data" : "product.code", "searchable": false, "sortable": false},
          {"data" : "product.name"},
          {"data" : "price", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "qty", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "subtotal", 
            "searchable" : false,
            "sortable" : false, 
          },
          {"data" : "aksi", 
            "searchable" : false,
            "sortable" : false, 
          }
        ],
    })
    
    //edit qty
    function editQty(id, value) {
      
      if(parseInt(value) > 10000) {
        makeAlert('warning', 'Perhatian!', 'Maksimal qty 10000')
        value = 10000
      }
      
      if(parseInt(value) < 1) {
        makeAlert('warning', 'Perhatian!', 'Minimal qty 1')
        value = 1
      }
      
     $.ajax({
       url: `/purchase_detail/${id}`,
       type: 'put',
       data: {
         '_token': '{{ csrf_token() }}',
         'purchase_detail_id': id,
         'qty': value
       },
       success: function(data) {
         table.ajax.reload()
         count_subtotal()
       },
       error: function(xhr) {
         makeAlert('error', 'Gagal!', 'Gagal mengupdate qty')
       }
     })
    }
    
    //delete product
    function deleteProduct(url) {
      
      if(confirm('Yakin mau menghapus produk yang dibeli?')) {

      $.ajax({
        type: 'delete',
        url: url,
        data: {
          '_token': '{{ csrf_token() }}',
          '_method': 'delete'
        },
        success: function(data) {
          count_subtotal()
          table.ajax.reload()
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menghapus produk')
        }
      })
    
      }
    
    }
    
    //tampilkan produk
    $('#productTable').DataTable()
    
    //tambah produk 
    function saveProduct() {
      $.ajax({
        url: '/purchase_detail',
        type: 'post',
        data: $('.form-product').serialize(),
        success: function(data) {
          count_subtotal()
          table.ajax.reload()
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menambahkan produk')
        }
      })
    }
    
    //pilih produk 
    function addProduct(code, id) {
      $('.form-product [name=code]').val(code)
      $('.form-product [name=product_id]').val(id)
      $('#product-list').modal('hide')
      saveProduct()
      table.ajax.reload()
    }
    
    //update diskon 
    $('#purchase-form [name=discount]').on('change', function() {

      $.ajax({
        url: '/purchases/{{ session("purchase_id") }}',
        type: 'put',
        data: {
          '_token': '{{ csrf_token() }}',
          'discount': $(this).val()
        },
        success: function(data) {
          count_subtotal()
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal mengupdate diskon')
        }
      })
      
    })
</script>
@endsection