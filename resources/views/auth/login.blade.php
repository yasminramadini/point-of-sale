@extends('auth.layout')

@section('content')

@if(session()->has('success'))
<div class="alert alert-success m-3">
  {{ session('success') }}
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger m-3">
  {{ session('error') }}
</div>
@endif

<form class="quickForm" method="post" action="{{ route('login.store') }}">
  @csrf
  <div class="card-body">
    <div class="form-group">
      <label for="exampleInputEmail1">Username</label>
      <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" required value="{{ old('username') }}">
      @error('username')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" required>
      @error('password')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer text-center">
    <button type="submit" class="btn btn-primary btn-block">Login</button>
    <small class="d-block mt-3">Lupa password? <a href="#">klik di sini</a></small>
    <small class="d-block">Belum punya akun? <a href="{{ route('register') }}">register</a></small>
  </div>
</form>

@endsection