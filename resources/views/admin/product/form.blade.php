<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          @csrf
          @method('post')
          <div class="form-group code">
            <label for="code" class="col-form-label">Kode:</label>
            <input type="text" class="form-control" id="code" name="code" autocomplete="off">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group name">
            <label for="name" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" autocomplete="off">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group category_id">
            <label for="category_id" class="col-form-label">Kategori:</label>
            <select name="category_id" class="form-control">
              @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            </select>
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group stock">
            <label for="stock" class="col-form-label">Stok:</label>
            <input type="number" class="form-control" id="stock" name="stock" value="0">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group purchase_price">
            <label for="purchase_price" class="col-form-label">Harga Beli:</label>
            <input type="number" class="form-control" id="purchase_price" name="purchase_price" value="0">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group selling_price">
            <label for="selling_price" class="col-form-label">Harga Jual:</label>
            <input type="number" class="form-control" id="selling_price" name="selling_price" value="0">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group discount">
            <label for="discount" class="col-form-label">Diskon:</label>
            <input type="number" class="form-control" id="discount" name="discount" value="0">
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>