@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Manajemen Akun
    <small>Kelola Akun</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Akun</li>
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

  <div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('akun.update')}}" method="post">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Akun</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14 {{ $errors->has('email') ? 'has-error' : '' }}">
              <label class="control-label">Email</label>
              <input type="hidden" name="id" id="id">
              <input id="edit_email" type="email" name="email" class="form-control" placeholder="Email"
              @if($errors->has('email'))
                value="{{ old('email') }}"
              @endif
              readonly>
              @if($errors->has('email'))
                <span class="help-block">
                  <i>* {{$errors->first('email')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('level') ? 'has-error' : '' }}">
              <label class="control-label">Level</label>
              <select class="form-control" name="level" id="leveluser">
                <option value="-- Pilih --">-- Pilih --</option>
                <option value="1" {{ old('level')=="0" ? 'selected' : '' }} id="flag_admin">Administrator</option>
                <option value="2" {{ old('level')=="2" ? 'selected' : '' }} id="flag_skpd">User SKPD</option>
              </select>
              @if($errors->has('level'))
                <span class="help-block">
                  <i>* {{$errors->first('level')}}</i>
                </span>
              @endif
            </div>
            <div id="skpdoption" class="col-md-14 {{ $errors->has('id_skpd') ? 'has-error' : '' }}">
              <label class="control-label">SKPD</label>
              <select class="form-control select2" name="id_skpd" style="width: 100%;">
                <option value="-- Pilih --">-- Pilih --</option>
                @foreach($getskpd as $key)
                  <option value="{{$key->id}}" id="editskpd{{$key->id}}">{{$key->nama_skpd}}</option>
                @endforeach
              </select>
              @if($errors->has('id_skpd'))
                <span class="help-block">
                  <i>* {{$errors->first('id_skpd')}}</i>
                </span>
              @endif
            </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-success btn-flat">Simpan Perubahan</a>
          </div>
        </div>
    </form>
    </div>
  </div>

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Akun</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus akun ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="sethapus">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

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

    <form class="form-horizontal" method="post" action="{{route('akun.store')}}">
      {{ csrf_field() }}
        <div class="col-md-4">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Formulir Tambah Akun SKPD</h3>
            </div>
            <div class="box-body">
              <div class="col-md-14 {{ $errors->has('email') ? 'has-error' : '' }}">
                <label class="control-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email"
                @if(!$errors->has('email'))
                  value="{{ old('email') }}"
                @endif
                >
                @if($errors->has('email'))
                  <span class="help-block">
                    <i>* {{$errors->first('email')}}</i>
                  </span>
                @endif
              </div>
              <div class="col-md-14 {{ $errors->has('level') ? 'has-error' : '' }}">
                <label class="control-label">Level</label>
                <select class="form-control" name="level" id="leveluser">
                  <option value="-- Pilih --">-- Pilih --</option>
                  <option value="1" {{ old('level')=="1" ? 'selected' : '' }} >Administrator</option>
                  <option value="2" {{ old('level')=="2" ? 'selected' : '' }} >User SKPD</option>
                </select>
                @if($errors->has('level'))
                  <span class="help-block">
                    <i>* {{$errors->first('level')}}</i>
                  </span>
                @endif
              </div>
              <div id="skpdoption" class="col-md-14 {{ $errors->has('id_skpd') ? 'has-error' : '' }}">
                <label class="control-label">SKPD</label>
                <select class="form-control select2" name="id_skpd">
                  <option value="-- Pilih --">-- Pilih --</option>
                  @foreach($getskpd as $key)
                    @if (old('id_skpd')==$key->id)
                      <option value="{{$key->id}}" selected>{{$key->nama_skpd}}</option>
                    @else
                      <option value="{{$key->id}}">{{$key->nama_skpd}}</option>
                    @endif
                  @endforeach
                </select>
                @if($errors->has('id_skpd'))
                  <span class="help-block">
                    <i>* {{$errors->first('id_skpd')}}</i>
                  </span>
                @endif
              </div>

            </div>
            <div class="box-footer">
              <button type="reset" class="btn btn-default btn-sm btn-flat">Reset Formulir</button>
              <button type="submit" class="btn btn-success pull-right btn-sm btn-flat">Simpan</button>
            </div>
          </div>
        </div>
    </form>
    <!-- END FORM-->
    <!-- START TABLE-->
    <div class="col-md-8">
      <div class="box box-success box-solid">
        <div class="box-header with-border">
          <div class="box-title">
            Seluruh Data Akun SKPD
          </div>
        </div>
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Email</th>
                <th>Level</th>
                <th>Nama SKPD</th>
                <th>Status Aktifasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getuser as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->email}}</td>
                  <td>
                    @if($key->level=="1")
                      Administrator
                    @elseif($key->level=="2")
                      User SKPD
                    @endif
                  </td>
                  <td>{{$key->masterskpd->nama_skpd}}</td>
                  <td>
                    @if($key->activated=="0")
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif">
                        <i class="fa fa-thumbs-down"></i>
                      </span>
                    @elseif($key->activated=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif">
                        <i class="fa fa-thumbs-up"></i>
                      </span>
                    @endif
                  </td>
                  <td>
                    <span data-toggle="tooltip" title="Edit">
                      <a class="btn btn-xs btn-warning btn-flat edit" data-toggle="modal" data-target="#modaledit" data-value="{{$key->id}}">
                        <i class="fa fa-edit"></i>
                      </a>
                    </span>
                    <span data-toggle="tooltip" title="Hapus">
                      <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id}}">
                        <i class="fa fa-remove"></i>
                      </a>
                    </span>
                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="box-footer">

        </div>
      </div>
    </div>
    <!-- START TABLE-->
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
  <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>

  <script type="text/javascript">
  $(".select2").select2();
  </script>

  <script>
    $(function () {
      $("#tabelinfo").DataTable();

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-akun/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var email = data.email;
            var level = data.level;
            var id_skpd = data.id_skpd;

            $('#id').attr('value', id);
            $('#edit_email').attr('value', email);
            if (level=="1") {
              $('#flag_admin').attr('selected', true);
            } else {
              $('#flag_skpd').attr('selected', true);
            }
            $('#editskpd'+id_skpd).attr('selected', true);
          }
        })
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-akun/')}}/'+a);
      });

    });
  </script>

@stop
