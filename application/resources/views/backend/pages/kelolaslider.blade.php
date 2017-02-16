@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Slider
    <small>Kelola Slider</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Slider</li>
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
          <h4 class="modal-title">Edit Status Slider</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status slider ini?</p>
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
          <h4 class="modal-title">Hapus Slider</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus slider ini?</p>
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
      <form class="form-horizontal" action="{{route('slider.edit')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Konten Slider</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">Gambar Slider</label>
              <div style="margin-bottom:10px;">
                <img src="" id="gambarslider">
              </div>
              <input type="file" name="url_slider" class="form-control">
              <input type="hidden" name="id" id="id">
              <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
              <div>
                <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                <span class="text-muted"><i>* Rekomendasi ukuran terbaik: 1144 x 550 px.</i></span>
              </div>
            </div>
            <div class="col-md-14">
              <label class="control-label">Keterangan</label>
              <textarea name="keterangan_slider" rows="4" cols="40" class="form-control" id="edit_keterangan_slider"></textarea>
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_slider">
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
      <form class="form-horizontal" action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Slider Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('url_slider') ? 'has-error' : '' }}">
              <label class="control-label">Gambar Slider</label>
              <input type="file" name="url_slider" class="form-control">
              <div>
                <span class="text-muted"><i>* Max Size: 2MB.</i></span><br>
                <span class="text-muted"><i>* Rekomendasi ukuran terbaik: 1144 x 550 px.</i></span>
              </div>
              @if ($errors->has('url_slider'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('url_slider')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('keterangan_slider') ? 'has-error' : '' }}">
              <label class="control-label">Keterangan</label>
              <textarea name="keterangan_slider" rows="4" cols="40" class="form-control">@if(!$errors->has('keterangan_slider')){{old('keterangan_slider')}}@endif</textarea>
              @if ($errors->has('keterangan_slider'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('keterangan_slider')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_slider">
                <option value="1" {{ old('flag_slider')==1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('flag_slider')==0 ? 'selected' : '' }}>Tidak Aktif</option>
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
          <h3 class="box-title">Seluruh Data Slider</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Gambar</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getslider as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>
                    @if($key->url_slider!="")
                      <img src="{{url('_thumbs/slider')}}/{{$key->url_slider}}">
                    @else
                      <img src="{{url('images/')}}/no_image.jpg">
                    @endif
                  </td>
                  <td>{{$key->keterangan_slider}}</td>
                  <td>
                    @if($key->flag_slider=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif">
                        <i class="fa fa-thumbs-up"></i>
                      </span>
                    @else
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif">
                        <i class="fa fa-thumbs-down"></i>
                      </span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_slider=="1")
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
        $('#setflagpublish').attr('href', '{{url('admin/publish-slider/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-slider/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-slider/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var keterangan_slider = data.keterangan_slider;
            var flag_slider = data.flag_slider;
            var url_slider = data.url_slider;

            $('#id').attr('value', id);
            $('#gambarslider').attr('src', "{{url('_thumbs/slider')}}/"+url_slider);
            $('#edit_keterangan_slider').val(keterangan_slider);
            if(flag_slider=="1") {
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
