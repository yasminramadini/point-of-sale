@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pengaturan</h1>
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
      
      <div class="card mt-3">
        <div class="card-body">
          <form method="post" action="/setting" enctype="multipart/form-data" id="form-setting">
            @csrf
            <div class="mb-3 company_name">
              <label>Nama Perusahaan</label>
              <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" id="company_name" value="{{ $setting->company_name }}" required>
              @error('company_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 company_phone">
              <label>No Perusahaan</label>
              <input type="number" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" id="company_phone" value="{{ $setting->company_phone }}" required>
              @error('company_phone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 discount">
              <label>Diskon Member</label>
              <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ $setting->discount }}" id="discount">
              @error('discount')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 company_address">
              <label>Alamat Perusahaan</label>
              <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" required rows="5" id="company_address">{{ $setting->company_address }}</textarea>
              @error('company_address')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 logo">
              <label>Logo Perusahaan</label>
              <input type="file" class="form-control-input @error('logo') is-invalid @enderror" name="logo" id="logo">
              <img src="/image/{{ $setting->logo }}" class="d-block img-thumbnail my-2" width="100px" id="previewLogo">
              @error('logo')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 member_card">
              <label>Kartu Member</label>
              <input type="file" class="form-control-input @error('member_card') is-invalid @enderror" name="member_card" id="member_card">
              <img src="/image/{{ $setting->member_card }}" class="d-block img-thumbnail my-2" width="130px" id="previewCard">
              @error('member_card')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <button class="btn btn-primary">Save</button>
          </form>
        </div>
        <!-- /.card-body -->
      </div>

      <!-- /.row (main row) -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>

<script>

   //make alert
    function makeAlert(type, title, body) {
      Swal.fire({
        icon: type,
        title: title,
        text: body
      })
    }
    
  $('#form-setting').on('submit', function(e) {
    e.preventDefault()
    
    var logo = $('#logo').prop('files')[0]
    var member_card = $('#member_card').prop('files')[0]
    var formData = new FormData()
    
    formData.append('logo', logo)
    formData.append('member_card', member_card)
    formData.append('company_name', $('#company_name').val())
    formData.append('company_phone', $('#company_phone').val())
    formData.append('company_address', $('#company_address').val())
    formData.append('discount', $('#discount').val())
    formData.append('_token', '{{ csrf_token() }}')
    
    $.ajax({
      url: $('#form-setting').attr('action'),
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      success: function(data) {
        makeAlert('success', 'Berhasil!', 'Pengaturan berhasil diupdate')
        $('#company_name').val(data.company_name)
        $('#company_phone').val(data.company_phone)
        $('#company_address').val(data.company_address)
        $('#previewLogo').attr('src', '/image/' + data.logo)
        $('#previewCard').attr('src', '/image/' + data.member_card)
        $('#discount').val(data.discount)
      },
      error: function(xhr) {
        makeAlert('error', 'Gagal!', 'Gagal mengupdate pengaturan')
      }
    })
  })
</script>

<!-- /.content-wrapper -->
@endsection