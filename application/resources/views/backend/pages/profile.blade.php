@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Profile
    <small>Manajemen Profile</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Manajemen Profile</li>
  </ol>
@stop

@section('content')
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 2000);

    window.setTimeout(function() {
      $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
    }, 5000);
  </script>

  <div class="row">
    <div class="col-md-12">
      @if(Session::has('message'))
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <p>{{ Session::get('message') }}</p>
        </div>
      @endif

      @if(Session::has('messagefail'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Oops, terjadi kesalahan!</h4>
          <p>{{ Session::get('messagefail') }}</p>
        </div>
      @endif
    </div>

    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          @if($getuser->url_foto=="")
            <img class="profile-user-img img-responsive img-circle" src="{{url('images')}}/user-not-found.png" alt="User profile picture">
          @else
            <img class="profile-user-img img-responsive img-circle" src="{{url('images')}}/{{$getuser->url_foto}}" alt="User profile picture">
          @endif
          @if($getuser->name=="")
            <h3 class="profile-username text-center">No Name</h3>
          @else
            <h3 class="profile-username text-center">{{$getuser->name}}</h3>
          @endif

          @if($getuser->level=="1")
            <p class="text-muted text-center">Admin Web Utama</p>
          @else
            <p class="text-muted text-center">Admin SKPD</p>
          @endif

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Jumlah Berita</b> <a class="badge bg-green pull-right">{{$countberita}}</a>
            </li>
          </ul>

          <strong><i class="fa fa-envelope margin-r-5"></i>  Email</strong>
          <p class="text-muted">
            {{$getuser->email}}
          </p>
          <hr>
          <strong><i class="fa fa-building margin-r-5"></i> SKPD</strong>
          <p class="text-muted">{{$getskpd->nama_skpd}}</p>
          <hr>
          <strong><i class="fa fa-calendar margin-r-5"></i> Tanggal Terdaftar</strong>
          <?php $date = explode(" ", $getuser->created_at); ?>
          <?php $format = explode("-", $date[0]); ?>
          <p class="text-muted">{{$format[2]}}-{{$format[1]}}-{{$format[0]}}</p>
          <hr>

          {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
        </div><!-- /.box-body -->
      </div><!-- /.box -->

    </div><!-- /.col -->

    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">Profile Pengguna</a></li>
          <li><a href="#password" data-toggle="tab">Ubah Password</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">
            <form class="form-horizontal" action="{{route('profile.edit')}}" enctype="multipart/form-data" method="post">
              {{csrf_field()}}
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Nama</label>
                <div class="col-sm-10">
                  <input type="hidden" name="id" value="{{$getuser->id}}">
                  <input type="text" class="form-control" name="name"
                    @if($getuser->name!="")
                      value="{{$getuser->name}}"
                    @endif
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="email" readonly
                    value="{{$getuser->email}}"
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Hak Akses</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="hakakses" readonly
                    @if($getuser->level=="1")
                      value="Admin Web Utama"
                    @else
                      value="Admin SKPD"
                    @endif
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="inputExperience" class="col-sm-2 control-label">Upload Foto</label>
                <div class="col-sm-10">
                  <input type="file" name="url_foto" class="form-control">
                  <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                  <div>
                    <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                    <span class="text-muted"><i>* Rekomendasi ukuran terbaik: 160 x 160 px.</i></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-flat">Simpan</button>
                </div>
              </div>
            </form>
          </div><!-- /.tab-pane -->

          <div class="tab-pane" id="password">
            <form class="form-horizontal" action="{{route('profile.changepassword')}}" method="post">
              {{csrf_field()}}
              <div class="form-group">
                <label class="col-sm-2 control-label">Password Lama</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="oldpassword">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="newpassword">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label">Konfirmasi Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="newpassword_confirmation">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-success btn-flat">Ubah Password Saya</button>
                </div>
              </div>
            </form>
          </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
      </div><!-- /.nav-tabs-custom -->
    </div><!-- /.col -->

  </div>
  <!-- END FORM -->

  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>

@stop
