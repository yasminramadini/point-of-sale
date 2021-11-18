@extends('admin.layout.index')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Profil</h1>
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
          
          <button class="btn btn-danger my-3" onclick="changePassword()"><i class="fas fa-lock"></i> Ubah Password</button>
          
          <form method="post" action="/profil" enctype="multipart/form-data" id="form-profil">
            @csrf
            <div class="mb-3 name">
              <label>Nama</label>
              <input type="text" class="form-control" name="name" id="name" value="{{ $profil->name }}" required>
              <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3 username">
              <label>Username</label>
              <input type="text" class="form-control" name="username" id="username" value="{{ $profil->username }}" required>
              <div class="invalid-feedback"></div>
            </div>
            <div class="mb-3 discount">
              <label>Email</label>
              <input type="email" class="form-control" name="email" value="{{ $profil->email }}" id="email">
            </div>
            <div class="mb-3 avatar">
              <label>Avatar</label>
              <input type="file" class="form-control-input" name="avatar" id="avatar">
              <img src="@if($profil->avatar !== null) /image/{{ $profil->avatar }} @else /image/avatar.png @endif" class="d-block img-thumbnail my-2" width="200px" id="previewAvatar">
              <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary">Save</button>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
      
      @include('admin.user.changePassword')

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
    
  $('#form-profil').on('submit', function(e) {
    e.preventDefault()
    
    var avatar = $('#avatar').prop('files')[0]
    var formData = new FormData()
    
    formData.append('avatar', avatar)
    formData.append('name', $('#name').val())
    formData.append('username', $('#username').val())
    formData.append('email', $('#email').val())
    formData.append('_token', '{{ csrf_token() }}')
    
    $.ajax({
      url: $('#form-profil').attr('action'),
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      success: function(data) {
        makeAlert('success', 'Berhasil!', 'Profil berhasil diupdate')
        $('#name').val(data.name)
        $('#username').val(data.username)
        $('#email').val(data.email)
        if(data.avatar !== null) {
          $('.img-avatar').attr('src', '/image/' + data.avatar)
          $('#previewAvatar').attr('src', '/image/' + data.avatar)
        } else {
          $('.img-avatar').attr('src', '/image/avatar.png')
          $('#previewAvatar').attr('src', '/image/avatar.png')
        }
        $('.text-username').text(data.username)
        
        $('.invalid-feedback').text('')
        $('#form-profil input').removeClass('is-invalid')
      },
      error: function(xhr) {
        var error = JSON.parse(xhr.responseText)
        
        if(error.errors.name) {
          $('#form-profil [name=name]').addClass('is-invalid')
          $('#form-profil .name .invalid-feedback').text(error.errors.name)
        }
        
        if(error.errors.username) {
          $('#form-profil [name=username]').addClass('is-invalid')
          $('#form-profil .username .invalid-feedback').text(error.errors.username)
        }
        
        if(error.errors.email) {
          $('#form-profil [name=email]').addClass('is-invalid')
          $('#form-profil .email .invalid-feedback').text(error.errors.email)
        }
        
        if(error.errors.avatar) {
          $('#form-profil [name=avatar]').addClass('is-invalid')
          $('#form-profil .avatar .invalid-feedback').text(error.errors.avatar)
        }
        
      }
    })
  })
  
  //ubah password
  function changePassword() {
    $('#modal-form').modal('show')
    $('#modal-form form .text-danger').text('')
    $('#modal-form form input').removeClass('is-invalid')
    $('#modal-form form')[0].reset()
  }
  
  $('#modal-form form').on('submit', function(e) {
    e.preventDefault()
    

    if($('#modal-form #confirmPassword').val() !== $('#modal-form #newPassword').val()) {
      $('#modal-form form .confirmPassword .invalid-feedback').text('Konfirmasi password salah')
      $('#modal-form form [name=confirmPassword]').addClass('is-invalid')
      return false
    } else {
      $('#modal-form form .confirmPassword .invalid-feedback').text('')
      $('#modal-form form [name=confirmPassword]').removeClass('is-invalid')
    }
   
    $.ajax({
      url: '/profil/change_password',
      type: 'post',
      data: $('#modal-form form').serialize(),
      success: function(data) {
        makeAlert('success', 'Berhasil!', 'Password berhasil diubah')
        $('#modal-form form .invalid-feedback').text('')
        $('#modal-form form input').removeClass('is-invalid')
        $('#modal-form form')[0].reset()
        $('#modal-form').modal('hide')
      },
      error: function(xhr) {
        makeAlert('error', 'Gagal!', 'Gagal mengupdate password')
        
        var error = JSON.parse(xhr.responseText)
        
        if(error.oldPassword) {
          $('#modal-form .oldPassword .text-danger').text(error.oldPassword)
        }
        
        if(error.errors.newPassword) {
          $('#modal-form .newPassword .text-danger').text(error.errors.newPassword)
        }
        
        $('#modal-form form')[0].reset()
        
      }
    })
  })
</script>

<!-- /.content-wrapper -->
@endsection