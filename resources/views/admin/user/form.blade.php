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
          @method('put')
          <div class="form-group username">
            <label for="username" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" readonly>
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group name">
            <label for="name" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" readonly>
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group name">
            <label for="email" class="col-form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" readonly>
            <div class="invalid-feedback"></div>
          </div>
          <div class="form-group role">
            <label for="role" class="col-form-label">Ubah Role:</label>
            <select name="role" class="form-control">
              @foreach($roles as $role)
              <option value="{{ $role }}">@if($role !== 1) User @else Admin @endif</option>
              @endforeach
            </select>
            <div class="invalid-feedback"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>