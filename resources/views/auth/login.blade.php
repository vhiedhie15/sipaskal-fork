@extends('layouts.login')

@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="text-center">
        <a href="{{ url('/') }}" class="h1">
            <img src="assets/img/login/sipaskal-logo-login.png" alt="SIPASKAL" style="width:200px">
        </a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Masuk ke akun anda</p>
  
        <form action="{{ route('login') }}" method="post">
            @csrf
          <div class="input-group mb-3">
            <input id="login" name="login" type="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
                <p class="mb-1">
                    <a href="forgot-password.html">Saya lupa password</a>
                </p>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.card-body -->
      <div class="card-body">
        <div class="social-auth-links text-center mt-2 mb-3">
            <a href="https://diskominfo.landakkab.go.id/">
                <img src="assets/img/login/diskominfolandak3.png" alt="Diskominfo Landak" style="width:250px">
            </a>
        </div>
        <!-- /.social-auth-links -->
      </div>
    </div>
    <!-- /.card -->
  </div>
<!-- /.login-box -->
@endsection
