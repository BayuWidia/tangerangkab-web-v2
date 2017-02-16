@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <style>
  .datepicker{z-index:1151 !important;}
  </style>
@stop

@section('breadcrumb')
  <h1>
    Anggaran
    <small>Kelola Data Anggaran</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Data Anggaran</li>
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
          <h4 class="modal-title">Edit Status Anggaran</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status anggaran ini?</p>
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
          <h4 class="modal-title">Hapus Anggaran</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data anggaran ini?</p>
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
      <form class="form-horizontal" action="{{route('anggaran.edit')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data anggaran</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">Nama Anggaran</label>
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="uraian" class="form-control" id="uraian">
            </div>
            <div class="col-md-14">
              <label class="control-label">Upload Document</label>
              <input type="file" name="url_file" class="form-control">
              <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
            </div>
            <div class="col-md-14">
              <label class="control-label">Tahun</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="tahun" id="edit_tahun_anggaran">
              </div><!-- /.input group -->
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_anggaran">
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
      <form class="form-horizontal" action="{{route('anggaran.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Anggaran Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('uraian') ? 'has-error' : '' }}">
              <label class="control-label">Nama Anggaran</label>
              <input type="text" name="uraian" class="form-control"
                @if (!$errors->has('uraian'))
                  value="{{ old('uraian') }}"
                @endif
              >
              @if ($errors->has('uraian'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('uraian') }}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('url_file') ? 'has-error' : '' }}">
              <label class="control-label">Upload Document</label>
              <input type="file" name="url_file" class="form-control">
              @if ($errors->has('url_file'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('url_file') }}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('tahun') ? 'has-error' : '' }}">
              <label class="control-label">Tahun</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="tahun" id="tahun_anggaran"
                  @if (!$errors->has('tahun'))
                    value="{{ old('tahun') }}"
                  @endif
                >
              </div><!-- /.input group -->
              @if ($errors->has('tahun'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('tahun') }}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('flag_anggaran') ? 'has-error' : '' }}">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_anggaran">
                <option value="1" {{ old('flag_anggaran')==1 ? 'selected' : ''}}>Aktif</option>
                <option value="0" {{ old('flag_anggaran')==0 ? 'selected' : ''}}>Tidak Aktif</option>
              </select>
              @if ($errors->has('flag_anggaran'))
                <div>
                  <span class="help-block">
                    <i>* {{ $errors->first('flag_anggaran') }}</i>
                  </span>
                </div>
              @endif
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
          <h3 class="box-title">Seluruh Data Anggaran</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Tahun</th>
                <th>Dokumen</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getanggaran as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->uraian}}</td>
                  <td>{{$key->tahun}}</td>
                  <td>
                    @if($key->url_file!="")
                      <a href="{{url('/')}}/documents/{{$key->url_file}}" download>{{$key->url_file}}</a>
                    @else
                      <span class="text-muted"><i>Dokumen tidak tersedia.</i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_anggaran=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif"><i class="fa fa-thumbs-up"></i></span>
                    @else
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif"><i class="fa fa-thumbs-down"></i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_anggaran=="1")
                      <span data-toggle="tooltip" title="Ubah Status">
                        <a href="#" class="btn btn-xs btn-danger btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heartbeat"></i></a>
                      </span>
                    @elseif($key->flag_anggaran=="0")
                      <span data-toggle="tooltip" title="Ubah Status">
                        <a href="#" class="btn btn-xs btn-success btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heart"></i></a>
                      </span>
                    @endif
                    <span data-toggle="tooltip" title="Edit">
                      <a href="#" class="btn btn-xs btn-warning btn-flat edit"data-toggle="modal" data-target="#modaledit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
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
  <!-- date-range-picker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
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
        $('#setflagpublish').attr('href', '{{url('admin/publish-anggaran/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-anggaran/')}}/'+a);
      });

      $('#tahun_anggaran').datepicker({
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
      });

      $('#edit_tahun_anggaran').datepicker({
        format: " yyyy",
        viewMode: "years",
        minViewMode: "years"
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-anggaran/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var uraian = data.uraian;
            var tahun = data.tahun;
            var flag_anggaran = data.flag_anggaran;

            $('#id').attr('value', id);
            $('#uraian').attr('value', uraian);
            $('#edit_tahun_anggaran').attr('value', tahun);

            if(flag_anggaran=="1") {
              $('#flag_aktif').attr('selected', true);
            } else {
              $('#flag_nonaktif').attr('selected', true);
            }
          }
        })
      });

      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });
    });
  </script>

@stop
