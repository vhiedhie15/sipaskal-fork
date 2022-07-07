@extends('layouts.app')

@section('title')
    | Edit | {{ $user->nama }}
@endsection

@section('css')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection

@section('header')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pengguna</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users') }}">Pengguna</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/users'.$user->id) }}">{{ $user->nama }}</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-plus"></i> Form Edit Pengguna <b>{{ $user->nama }}</b></h3>
              </div>
              <!-- /.card-header -->

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

              <!-- form start -->
              {{-- <form method="POST" action="{{ URL('/users/'.$user->id.'/edit') }}" enctype="multipart/form-data"> --}}
            <form method="POST" action="{{ route('users.update', [$user->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nomor Induk Pegawai</label>
                                <input type="number" class="form-control" placeholder="Masukan Nomor Induk Pegawai ..." name="nip" value="{{ $user->nip }}">
                            </div>
                            <div class="form-group">
                                <label>Nomor Induk Kependudukan</label>
                                <input type="number" class="form-control" placeholder="Masukan NIK ..." name="nik" value="{{ $user->nik }}">
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" placeholder="Masukan Nama Lengkap ..." name="nama_lengkap" value="{{ $user->nama }}">
                            </div>
                            <div class="form-group">
                                <label>Nomor Seluler / WhatsApp</label>
                                <input type="number" class="form-control" placeholder="Masukan Nomor Seluler ..." name="no_hp" value="{{ $user->no_hp }}">
                                <small>Disarankan nomor yang digunakan <b><i>WhatsApp</i></b></small>
                            </div>
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input type="text" class="form-control" placeholder="Masukan Nama Pengguna ..." name="username" value="{{ $user->username }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Masukan Email ..." name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label>Kata Sandi</label>
                                <input type="password" class="form-control" placeholder="Minimal 8 karakter ..." name="password">
                            </div>
                            {{-- <div class="form-group">
                                <label>Konfirmasi Kata Sandi</label>
                                <input type="text" class="form-control" placeholder="Ketik ulang kata sandi ...">
                            </div> --}}
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hak Akses</label>
                                {{-- <select id="hak-akses" class="js-example-placeholder-single js-states form-control select2" style="width: 100%;"> --}}
                                <select id="hak-akses" class="form-control select2bs4" style="width: 100%;" name="role">
                                    <option value="{{ $user->id_role }}" selected disabled hidden>{{ $user->nama_role }}</option>
                                    @foreach ($role as $item)
                                    <option value="{{ $item->id }}">{{$item->nama_role}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>OPD</label>
                                <select id="opd" name="opd" class="form-control select2bs4" style="width: 100%;">
                                    <option value="{{ $user->nama }}" selected disabled hidden>{{ $user->nama_opd }}</option>
                                    @foreach ($opd as $item)
                                    <option value="{{ $item->id }}">{{$item->nama_opd}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Unit Kerja</label>
                                <select id="unitkerja" name="unitkerja" class="form-control select2bs4" style="width: 100%;">
                                    <option value="{{ $user->id }}" selected disabled hidden>{{ $user->nama_unitkerja }}</option>
                                    {{-- @foreach ($unitkerja as $item)
                                    <option value="{{ $item->id }}">{{$item->nama_unitkerja}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="jabatan">
                                    <option value="{{ $user->id_jabatan }}" selected disabled hidden>{{ $user->nama_jabatan }}</option>
                                    @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}">{{$item->nama_jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Grup Jabatan</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="pangkat">
                                    <option value="{{ $user->pangkat }}" selected disabled hidden>{{ $user->pangkat }}</option>
                                    <option value="Menteri">Menteri</option>
                                    <option value="Kepala LPNK">Kepala LPNK</option>
                                    <option value="Eselon I">Eselon I</option>
                                    <option value="Eselon II">Eselon II</option>
                                    <option value="Eselon III / Koordinator">Eselon III / Koordinator</option>
                                    <option value="Eselon IV / Sub-Koordinator">Eselon IV / Sub-Koordinator</option>
                                    <option value="Fungsional Tertentu">Fungsional Tertentu</option>
                                    <option value="Fungsional Umum">Fungsional Umum</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Pimpinan Daerah">Pimpinan Daerah</option>
                                    <option value="Panglima">Panglima</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Pengguna</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="jenis_user">
                                    <option value="{{ $user->jenis_user }}" selected disabled hidden>{{ $user->jenis_user }}</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="Pekerja Harian Lepas">Pekerja Harian Lepas</option>
                                    <option value="PPNPN">PPNPN</option>
                                    <option value="Tenaga Harian Lepas">Tenaga Harian Lepas</option>
                                    <option value="PTT (Pekerja Tidak Tetap)">PTT (Pekerja Tidak Tetap)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Foto</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="foto">
                                        <label class="custom-file-label" for="customFile">{{ $user->foto }}</label>
                                    </div>
                                </div>
                                <small style="color:red">
                                    *Format lampiran yang diperbolehkan *.JPG, *.PNG
                                <br/>*Ukuran maksimal file 2 MB
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ URL::to('/users') }}">
                        <button type="button" class="btn btn-default">
                            <i class="fas fa-arrow-circle-left"></i> Kembali
                        </button>
                    </a>
                  <button type="submit" class="btn btn-success float-right"><i class="fa fa-save"></i> Simpan</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
@endsection

@section('script')
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
    // $('#hak-akses').select2({
    //     placeholder: "Pilih Hak Akses",
    //     allowClear: true
    // });
})

// $(".js-example-placeholder-single").select2({
//     placeholder: "Pilih Hak Akses",
//     allowClear: true
// });

</script>

<script>
    $(function () {
      bsCustomFileInput.init();
    });
</script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection