<div class="modal fade" id="supplier-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table id="supplierTable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Telepon</th>
              <th>Alamat</th>
              <th>
                <i class="fas fa-cog"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($suppliers as $key => $supplier)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $supplier->name }}</td>
              <td>{{ $supplier->phone }}</td>
              <td>{{ $supplier->address }}</td>
              <td>
                <form method="post" action="/purchases">
                  @csrf
                  <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                  <button class="btn btn-info">
                    <i class="fas fa-check-circle"></i> Pilih
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
</div>
</div>