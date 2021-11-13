<div class="modal fade" id="member-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table id="memberTable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Telepon</th>
              <th>Alamat</th>
              <th>
                <i class="fas fa-cog"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($members as $key => $member)
            <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $member->code }}</td>
              <td>{{ $member->name }}</td>
              <td>{{ $member->phone }}</td>
              <td>{{ $member->address }}</td>
              <td>
                <button onclick="addMember('{{ $member->code }}', '{{ $member->id }}')" class="btn btn-info">
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