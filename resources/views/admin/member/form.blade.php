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
          <div class="form-group stock">
            <label for="phone" class="col-form-label">Telepon:</label>
            <input type="number" class="form-control" id="phone" name="phone" autocomplete="off">
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group address">
            <label for="address" class="col-form-label">Alamat:</label>
            <textarea name="address" class="form-control" id="address" cols="10"></textarea>
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