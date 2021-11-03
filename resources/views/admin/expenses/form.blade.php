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
          <div class="form-group description">
            <label for="description" class="col-form-label">Deskripsi:</label>
            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group nominal">
            <label for="phone" class="col-form-label">Nominal:</label>
            <input type="number" class="form-control" id="nominal" name="nominal">
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