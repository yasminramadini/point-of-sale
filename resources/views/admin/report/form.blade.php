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
            <label for="startdate" class="col-form-label">Tanggal Awal:</label>
            <input type="date" name="startdate" id="startdate" class="form-control" value="{{ date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y') )) }}">
          </div>
          <div class="form-group nominal">
            <label for="enddate" class="col-form-label">Tanggal Akhir:</label>
            <input type="date" class="form-control" id="enddate" name="enddate" value="{{ date('Y-m-d') }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Pilih</button>
        </div>
      </form>
    </div>
  </div>
</div>