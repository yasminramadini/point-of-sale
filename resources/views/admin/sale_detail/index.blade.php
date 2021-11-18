@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transaksi Penjualan</h1>
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
                  <input type="text" name="code" class="form-control" readonly>
                  <button class="btn btn-info btn-flat" onclick="addProductForm()" type="button"><i class="fas fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-body table-responsive px-2">
            <table id="dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
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
              <form id="selling-form" action="/save_selling" method="post">
                @csrf 
                <input type="hidden" name="total_price">
                <div class="mb-3">
                  <label>Member</label>
                  <div class="input-group">
                    <input type="text" name="member" class="form-control" readonly>
                    <button type="button" class="btn btn-info btn-flat" onclick="addMemberForm()">
                      <i class="fas fa-arrow-right"></i>
                    </button>
                  </div>
                </div>
                <div class="mb-3">
                  <label>Total item</label>
                  <input type="number" name="total_item" class="form-control" readonly>
                </div>
                <div class="mb-3">
                  <label>Diskon Member (%)</label>
                  <input type="number" value="0" class="form-control" name="discount" readonly>
                </div>
                <div class="mb-3">
                  <label>Total Bayar</label>
                  <input type="number" class="form-control" name="paid" id="total_bayar" readonly>
                </div>
                <div class="mb-3">
                  <label>Diterima</label>
                  <input type="number" class="form-control" name="accepted" onchange="hitungKembali()">
                </div>
                <div class="mb-3">
                  <label>Kembalian</label>
                  <input type="number" class="form-control" readonly name="kembali">
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
@include('admin.sale_detail.products')
@include('admin.sale_detail.members')

<!-- /.content-wrapper -->
@endsection

@section('script')
<script>

  //get subtotal
  function count_subtotal() {
  $.ajax({
    url: '/count_subtotal_transaction',
    success: function(data) {
      $('#totalrp').text(data.paid)
      $('#selling-form [name=total_item]').val(data.total_item)
      $('#selling-form #total_bayar').val(data.num_paid)
      $('#selling-form [name=total_price]').val(data.total_price) 
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
  
  //triger product form
    function addProductForm() {
      $('#product-list').modal('show')
    }
  
  //triger member form
  function addMemberForm() {
    $('#member-list').modal('show')
  }
    
    //get transaction
    var table = $('#dataTable').DataTable({
      processing: true,
      ajax: '/data_transaction',
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
          {
            "data": "discount",
            "searchable": false,
            "sortable": false
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
    function editQty(id, value, qty) {
      
      if(parseInt(value) > 10000) {
        makeAlert('warning', 'Perhatian!', 'Maksimal qty 10000')
        value = 1
      }
      
      if(parseInt(value) < 1) {
        makeAlert('warning', 'Perhatian!', 'Minimal qty 1')
        value = 1
      }
      
      if(parseInt(value) > parseInt(qty)) {
        makeAlert('warning', 'Perhatian!', 'Jumlah qty tidak boleh lebih dari stok produk')
        value = 1
      }
      
     $.ajax({
       url: `/transaction/${id}`,
       type: 'put',
       data: {
         '_token': '{{ csrf_token() }}',
         'transaction_id': id,
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
        url: '/transaction',
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
    
    //add member 
    function addMember(code, id) {
      $('#selling-form [name=member]').val(code)
      $('#member-list').modal('hide')

      $.ajax({
        url: `/sales/{{ session('sale_id') }}`,
        type: 'put',
        data: {
          '_token': '{{ csrf_token() }}',
          'member': id
        },
        success: function(data) {
          $('#selling-form [name=discount]').val(data.discount_member)
          $('#selling-form [name=paid]').val(data.price_member)
          $('#totalrp').text(data.num_price_member)
        },
        error: function(xhr) {
          makeAlert('error', 'Gagal!', 'Gagal menambahkan member')
        }
      }) 
      
    }
    
    //hitung kembalian 
    function hitungKembali() {
      var kembali = $('#selling-form [name=accepted]').val() - $('#selling-form [name=paid]').val()
      
      $('#selling-form [name=kembali]').val($('#selling-form [name=accepted]').val() - $('#selling-form #total_bayar').val())
    }
    
</script>
@endsection