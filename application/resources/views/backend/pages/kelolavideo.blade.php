@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Video
    <small>Kelola Video</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Video</li>
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
          <h4 class="modal-title">Edit Status Publikasi Video</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status publikasi untuk video ini?</p>
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
          <h4 class="modal-title">Hapus Video</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus video ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="sethapus">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaleditimportantvideo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ubah Status Video Utama</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status video utama ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="seteditimportantvideo">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('video.edit')}}" method="post">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Konten Video</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">URL Youtube</label>
              <input type="text" name="url_video" class="form-control" id="url_video">
              <input type="hidden" name="id" id="id">
            </div>
            <div class="col-md-14">
              <label class="control-label">Judul Video</label>
              <input type="text" class="form-control" name="judul_video" id="judul_video">
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_video">
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
      <form class="form-horizontal" action="{{route('video.store')}}" method="post">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Video Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('url_video') ? 'has-error' : '' }}">
              <label class="control-label">URL Youtube</label>
              <input type="text" name="url_video" class="form-control"
                @if (!$errors->has('url_video'))
                  value="{{old('url_video')}}"
                @endif
              >
              @if ($errors->has('url_video'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('url_video') }}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('judul_video') ? 'has-error' : '' }}">
              <label class="control-label">Judul Video</label>
              <input type="text" name="judul_video" class="form-control"
                @if (!$errors->has('judul_video'))
                  value="{{old('judul_video')}}"
                @endif
              >
              @if ($errors->has('judul_video'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('judul_video') }}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14">
              <label class="control-label">Video Utama</label><br>
              <input type="checkbox" class="flat-red" name="flag_important_video" value="1">
              <span class="text-muted">&nbsp;&nbsp;* Ya, tampilkan video ini pada halaman utama.</span>
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_video">
                <option value="1" {{ old('flag_video')==1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('flag_video')==0 ? 'selected' : '' }}>Tidak Aktif</option>
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
          <h3 class="box-title">Seluruh Data Video</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Video</th>
                <th>Judul Video</th>
                <th>Video Utama</th>
                <th>Status Publikasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getvideo as $key)
                <tr>
                <td>{{$i}}</td>
                <td>
									<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo substr($key->url_video,-11,23)?>" allowfullscreen></iframe>
                </td>
                <td>{{$key->judul_video}}</td>
                <td>
                  @if($key->flag_important_video=="1")
                    <span data-toggle="tooltip" title="Video ini tayang di halaman utama. Klik icon ini untuk mengubah status video utama.">
                      <a href="#" class="badge bg-yellow edit_important_video" data-toggle="modal" data-target="#modaleditimportantvideo" data-value="{{$key->id}}">
                        <i class="fa fa-star"></i>
                      </a>
                    </span>
                  @else
                    <span data-toggle="tooltip" title="Video ini tidak tayang di halaman utama. Klik icon ini untuk mengubah status video utama.">
                      <a href="#" class="badge bg-default edit_important_video" data-toggle="modal" data-target="#modaleditimportantvideo" data-value="{{$key->id}}">
                        <i class="fa fa-star"></i>
                      </a>
                    </span>
                  @endif
                </td>
                <td>
                  @if($key->flag_video=="1")
                    <span data-toggle="tooltip" title="Video ini sudah dipublikasi. Klik icon ini untuk mengubah status publikasi.">
                      <a href="#" class="badge bg-green flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-thumbs-up"></i></a>
                    </span>
                  @else
                    <span data-toggle="tooltip" title="Video ini belum dipublikasi. Klik icon ini untuk mengubah status publikasi">
                      <a href="#" class="badge bg-red flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-thumbs-down"></i></a>
                    </span>
                  @endif
                </td>
                <td>
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
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>

  <script>
    $(function () {
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
      });

      $("#tabelinfo").DataTable();

      $("#tabelinfo").on("click", "a.flagpublish", function(){
        var a = $(this).data('value');
        $('#setflagpublish').attr('href', '{{url('admin/publish-video/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-video/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit_important_video", function(){
        var a = $(this).data('value');
        $('#seteditimportantvideo').attr('href', '{{url('admin/edit-important-video')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-video/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var url_video = data.url_video;
            var judul_video = data.judul_video;
            var flag_video = data.flag_video;

            $('#id').attr('value', id);
            $('#url_video').val(url_video);
            $('#judul_video').val(judul_video);
            if(flag_video=="1") {
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
