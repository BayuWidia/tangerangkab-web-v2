@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Aplikasi
    <small>Kelola Aplikasi</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Aplikasi</li>
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

  <div class="modal fade" id="modalflagedit" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Status Aplikasi</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status aplikasi ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="setflagpublish">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Aplikasi</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data aplikasi ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="sethapus">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('aplikasi.edit')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Konten</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">Nama Aplikasi</label>
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="nama_aplikasi" class="form-control" id="nama_aplikasi">
            </div>
            <div class="col-md-14">
              <label class="control-label">Domain Aplikasi</label>
              <input type="text" name="domain_aplikasi" class="form-control" id="domain_aplikasi">
            </div>
            <div class="col-md-14">
              <label class="control-label">Keterangan Aplikasi</label>
              <textarea name="keterangan_aplikasi" class="form-control" rows="8" cols="30" id="keterangan_aplikasi"></textarea>
            </div>
            <div class="col-md-14">
              <label class="control-label">Upload Logo</label>
              <div>
                <img src="" alt="Gambar tidak tersedia." style="margin-bottom:10px;" id="url_logo"/>
              </div>
              <input type="file" name="url_logo" class="form-control">
              <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_aplikasi">
                <option value="1" id="flag_aktif">Aktif</option>
                <option value="0" id="flag_nonaktif">Tidak Aktif</option>
              </select>
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
    <div class="col-md-4">
      <form class="form-horizontal" action="{{route('aplikasi.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Aplikasi Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama_aplikasi') ? 'has-error' : '' }}">
              <label class="control-label">Nama Aplikasi</label>
              <input type="text" name="nama_aplikasi" class="form-control"
                @if (!$errors->has('nama_aplikasi'))
                  value="{{ old('nama_aplikasi') }}"
                @endif
              >
              @if($errors->has('nama_aplikasi'))
                <span class="help-block">
                  <i>* {{$errors->first('nama_aplikasi')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('domain_aplikasi') ? 'has-error' : '' }}">
              <label class="control-label">Domain Aplikasi</label>
              <input type="text" name="domain_aplikasi" class="form-control"
                @if (!$errors->has('domain_aplikasi'))
                  value="{{ old('domain_aplikasi') }}"
                @endif
              >
              @if($errors->has('domain_aplikasi'))
                <span class="help-block">
                  <i>* {{$errors->first('domain_aplikasi')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('keterangan_aplikasi') ? 'has-error' : '' }}">
              <label class="control-label">Keterangan Aplikasi</label>
              <textarea name="keterangan_aplikasi" class="form-control" rows="8" cols="40">@if(!$errors->has('keterangan_aplikasi')){{ old('keterangan_aplikasi') }}@endif</textarea>
              @if($errors->has('keterangan_aplikasi'))
                <span class="help-block">
                  <i>* {{$errors->first('keterangan_aplikasi')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('url_logo') ? 'has-error' : '' }}">
              <label class="control-label">Upload Logo</label>
              <input type="file" name="url_logo" class="form-control">
              @if($errors->has('url_logo'))
                <span class="help-block">
                  <i>* {{$errors->first('url_logo')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_aplikasi">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right btn-sm btn-flat">Simpan</button>
            <button type="reset" class="btn btn-default btn-sm btn-flat pull-right" style="margin-right:5px;">Reset Formulir</button>
          </div>
        </div>
      </form>
    </div>

    <div class="col-md-8">
      <div class="box box-success box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Data Aplikasi</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Nama</th>
                <th>Domain</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getapps as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>
                    @if($key->url_logo!="")
                      <?php $foto = explode(".", $key->url_logo); ?>
                      <img src="{{url('images')}}/{{$foto[0]}}_200x122.{{$foto[1]}}" alt="logo"/>
                    @else
                      <img src="{{url('images')}}/no_image.jpg" alt="logo"/>
                    @endif
                  </td>
                  <td>{{$key->nama_aplikasi}}</td>
                  <td>
                    <span data-toggle="tooltip" title="Lihat Website">
                      <a href="http://{{$key->domain_aplikasi}}" target="_blank" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></a>
                    </span>
                  </td>
                  <td>{{$key->keterangan_aplikasi}}</td>
                  <td>
                    @if($key->flag_aplikasi=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif"><i class="fa fa-thumbs-up"></i></span>
                    @else
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif"><i class="fa fa-thumbs-down"></i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_aplikasi=="1")
                      <span data-toggle="tooltip" title="Ubah Status">
                        <a href="#" class="btn btn-xs btn-danger btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heartbeat"></i></a>
                      </span>
                    @else
                      <span data-toggle="tooltip" title="Ubah Status">
                        <a href="#" class="btn btn-xs btn-success btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heart"></i></a>
                      </span>
                    @endif
                    <span data-toggle="tooltip" title="Edit">
                      <a href="#" class="btn btn-xs btn-warning btn-flat edit" data-toggle="modal" data-target="#modaledit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                    </span>
                    <span data-toggle="tooltip" title="Hapus">
                      <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                    </span>
                  </td>
                </tr>
                <?php $i++; ?>
              @endforeach
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>

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

  <script>
    $(function () {
      $("#tabelinfo").DataTable();

      $("#tabelinfo").on("click", "a.flagpublish", function(){
        var a = $(this).data('value');
        $('#setflagpublish').attr('href', '{{url('admin/publish-aplikasi/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-aplikasi/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-aplikasi/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var nama_aplikasi = data.nama_aplikasi;
            var domain_aplikasi = data.domain_aplikasi;
            var keterangan_aplikasi = data.keterangan_aplikasi;
            var flag_aplikasi = data.flag_aplikasi;
            var url_logo = data.url_logo;

            $('#id').attr('value', id);
            $('#nama_aplikasi').val(nama_aplikasi);
            $('#domain_aplikasi').val(domain_aplikasi);
            $('#keterangan_aplikasi').val(keterangan_aplikasi);
            var gambar = url_logo.split(".");
            var url_logo = gambar[0] + "_200x122." + gambar[1];
            $('#url_logo').attr('src', "{{url('/images')}}/" + url_logo);
            if(flag_aplikasi=="1") {
              $('#flag_aktif').attr('selected', true);
            } else {
              $('#flag_nonaktif').attr('selected', true);
            }
          }
        })
      });
    });
  </script>

@stop
