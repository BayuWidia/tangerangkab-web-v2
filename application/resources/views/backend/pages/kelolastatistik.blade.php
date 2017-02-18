@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Link Statistik
    <small>Kelola Link Statistik</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Link Statistik</li>
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
          <h4 class="modal-title">Edit Status Link Statistik</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status link statistik ini?</p>
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
          <h4 class="modal-title">Hapus Link Statistik</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus link statistik ini?</p>
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
      <form class="form-horizontal" action="{{route('statistik.edit')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Link Statistik</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">Nama Statistik</label>
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="nama_statistik" class="form-control" id="nama_statistik">
            </div>
            <div class="col-md-14">
              <label class="control-label">Link Statistik</label>
              <input type="text" name="link_statistik" class="form-control" id="link_statistik">
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
              <select class="form-control" name="flag_statistik">
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
      <form class="form-horizontal" action="{{route('statistik.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Link Statistik</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama_statistik') ? 'has-error' : '' }}">
              <label class="control-label">Nama Statistik</label>
              <input type="text" name="nama_statistik" class="form-control"
                @if (!$errors->has('nama_statistik'))
                  value="{{ old('nama_statistik') }}"
                @endif
              >
              @if($errors->has('nama_statistik'))
                <span class="help-block">
                  <i>* {{$errors->first('nama_statistik')}}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('link_statistik') ? 'has-error' : '' }}">
              <label class="control-label">Link Statistik</label>
              <input type="text" name="link_statistik" class="form-control"
                @if (!$errors->has('link_statistik'))
                  value="{{ old('link_statistik') }}"
                @endif
              >
              @if($errors->has('link_statistik'))
                <span class="help-block">
                  <i>* {{$errors->first('link_statistik')}}</i>
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
              <select class="form-control" name="flag_statistik">
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
          <h3 class="box-title">Seluruh Link Statistik</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Logo</th>
                <th>Nama</th>
                <th>Link</th>
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
                  <td>{{$key->nama_statistik}}</td>
                  <td>
                    <span data-toggle="tooltip" title="Lihat Statistik">
                      <a href="http://{{$key->link_statistik}}" target="_blank" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></a>
                    </span>
                  </td>
                  <td>
                    @if($key->flag_statistik=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif"><i class="fa fa-thumbs-up"></i></span>
                    @else
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif"><i class="fa fa-thumbs-down"></i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_statistik=="1")
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
        $('#setflagpublish').attr('href', '{{url('admin/publish-statistik/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-statistik/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-statistik/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var nama_statistik = data.nama_statistik;
            var link_statistik = data.link_statistik;
            var flag_statistik = data.flag_statistik;
            var url_logo = data.url_logo;

            $('#id').attr('value', id);
            $('#nama_statistik').val(nama_statistik);
            $('#link_statistik').val(link_statistik);
            var gambar = url_logo.split(".");
            var url_logo = gambar[0] + "_200x122." + gambar[1];
            $('#url_logo').attr('src', "{{url('/images')}}/" + url_logo);
            if(flag_statistik=="1") {
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
