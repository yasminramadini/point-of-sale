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
        <form method="post" action="/update/change_password">
          @csrf
          <div class="form-group oldPassword">
            <label for="oldPassword" class="col-form-label">Password Lama:</label>
            <input type="password" name="oldPassword" id="oldPassword" class="form-control" required>
            <p class="text-danger"></p>
          </div>
          <div class="form-group newPassword">
            <label for="newPassword" class="col-form-label">Password Baru:</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            <p class="text-danger"></p>
          </div>
          <div class="form-group confirmPassword">
            <label for="confirmPassword" class="col-form-label">Konfirmasi Password:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="submitForm">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>