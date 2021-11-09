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
      
      @if(session()->has('success'))
      <div class="alert alert-success my-3">
        {{ session('success') }}
      </div>
      @endif

      <div class="card mt-3">
        <div class="card-body">
          <form method="post" action="/setting" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="logoLama" value="{{ $setting->logo }}">
            <input type="hidden" name="kartuLama" value="{{ $setting->member_card }}">
            <div class="mb-3 company_name">
              <label>Nama Perusahaan</label>
              <input type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $setting->company_name }}" required>
              @error('company_name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 company_phone">
              <label>No Perusahaan</label>
              <input type="number" class="form-control @error('company_phone') is-invalid @enderror" name="company_phone" value="{{ $setting->company_phone }}" required>
              @error('company_phone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 discount">
              <label>Diskon Member</label>
              <input type="number" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ $setting->discount }}">
              @error('discount')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label>Tipe Nota</label>
              <select name="note_type" class="form-control">
                <option value="1">Kecil</option>
                <option value="2">Besar</option>
              </select>
            </div>
            <div class="mb-3 company_address">
              <label>Alamat Perusahaan</label>
              <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" required rows="5">{{ $setting->company_address }}</textarea>
              @error('company_address')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 logo">
              <label>Logo Perusahaan</label>
              <input type="file" class="form-control-input @error('logo') is-invalid @enderror" name="logo">
              <img src="/image/{{ $setting->logo }}" class="d-block img-thumbnail my-2" width="100px" id="previewLogo">
              @error('logo')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 member_card">
              <label>Kartu Member</label>
              <input type="file" class="form-control-input @error('member_card') is-invalid @enderror" name="member_card">
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

<!-- /.content-wrapper -->
@endsection