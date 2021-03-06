<div class="modal fade" id="product-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table id="productTable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Harga Beli</th>
              <th>
                <i class="fas fa-cog"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $key => $product)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $product->code }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->purchase_price }}</td>
              <td>
                <button onclick="addProduct('{{ $product->code }}', '{{ $product->id }}')" class="btn btn-info">
                  <i class="fas fa-check-circle"></i> Pilih
                </button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
</div>
</div>