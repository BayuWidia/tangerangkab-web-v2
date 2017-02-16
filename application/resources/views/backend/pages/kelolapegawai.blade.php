@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/iCheck/all.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Pegawai
    <small>Kelola Data Pegawai</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Data Pegawai</li>
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
          <h4 class="modal-title">Edit Status Pegawai</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status pegawai ini?</p>
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
          <h4 class="modal-title">Hapus Pegawai</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data pegawai ini?</p>
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
      <form class="form-horizontal" action="{{route('pegawai.edit')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data Pegawai</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14">
              <label class="control-label">Nama</label>
              <input type="hidden" name="id" class="form-control" id="id">
              <input type="text" name="nama_pegawai" class="form-control" id="nama_pegawai">
            </div>
            <div class="col-md-14">
              <label class="control-label">Jenis Kelamin</label>
              <br>
              <input type="radio" name="jenis_kelamin" class="minimal" value="1" id="jk_pria"> &nbsp;Pria&nbsp;&nbsp;&nbsp;
              <input type="radio" name="jenis_kelamin" class="minimal" value="2" id="jk_wanita"> &nbsp;Wanita
            </div>
            <div class="col-md-14">
              <label class="control-label">Esselon</label>
              <select class="form-control" name="id_esselon">
                <option>-- Pilih --</option>
                @foreach($getesselon as $key)
                  <option value="{{$key->id}}" id="esselon{{$key->id}}">{{$key->nama_esselon}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-14">
              <label class="control-label">Pangkat</label>
              <select class="form-control" name="id_pangkat">
                <option>-- Pilih --</option>
                @foreach($getpangkat as $key)
                  <option value="{{$key->id}}" id="pangkat{{$key->id}}">{{$key->golongan}} - {{$key->pangkat}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-14">
              <label class="control-label">Foto Pegawai</label>
              <div style="margin-bottom:10px;">
                <img src="" alt="Foto Pegawai" id="fotopegawai"/>
              </div>
              <input type="file" name="url_foto" class="form-control">
              <span class="text-muted">* Biarkan kosong jika tidak ingin diganti.</span>
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_pegawai">
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
      <form class="form-horizontal" action="{{route('pegawai.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Pegawai Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama_pegawai') ? 'has-error' : '' }}">
              <label class="control-label">Nama</label>
              <input type="text" name="nama_pegawai" class="form-control">
              @if ($errors->has('nama_pegawai'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('nama_pegawai')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('jenis_kelamin') ? 'has-error' : '' }}">
              <label class="control-label">Jenis Kelamin</label>
              <br>
              <input type="radio" name="jenis_kelamin" class="minimal" value="1"> &nbsp;Pria&nbsp;&nbsp;&nbsp;
              <input type="radio" name="jenis_kelamin" class="minimal" value="2"> &nbsp;Wanita
              @if ($errors->has('jenis_kelamin'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('jenis_kelamin')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('id_esselon') ? 'has-error' : '' }}">
              <label class="control-label">Esselon</label>
              <select class="form-control" name="id_esselon">
                <option>-- Pilih --</option>
                @foreach($getesselon as $key)
                  <option value="{{$key->id}}">{{$key->nama_esselon}}</option>
                @endforeach
              </select>
              @if ($errors->has('id_esselon'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('id_esselon')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('id_pangkat') ? 'has-error' : '' }}">
              <label class="control-label">Pangkat</label>
              <select class="form-control" name="id_pangkat">
                <option>-- Pilih --</option>
                @foreach($getpangkat as $key)
                  <option value="{{$key->id}}">{{$key->golongan}} - {{$key->pangkat}}</option>
                @endforeach
              </select>
              @if ($errors->has('id_pangkat'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('id_pangkat')}}</i>
                  </span>
                </div>
              @endif
            </div>
            <div class="col-md-14">
              <label class="control-label">Foto Pegawai</label>
              <input type="file" name="url_foto" class="form-control">
            </div>
            <div class="col-md-14 {{ $errors->has('flag_pegawai') ? 'has-error' : '' }}">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_pegawai">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
              @if ($errors->has('flag_pegawai'))
                <div>
                  <span class="help-block">
                    <i>* {{$errors->first('flag_pegawai')}}</i>
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
          <h3 class="box-title">Seluruh Data Pegawai</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Esselon</th>
                <th>Pangkat</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getpegawai as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->nama_pegawai}}</td>
                  <td>
                    @if($key->jenis_kelamin=="1")
                      Pria
                    @else
                      Wanita
                    @endif
                  </td>
                  <td>{{$key->esselon->nama_esselon}}</td>
                  <td>{{$key->pangkat->golongan}}</td>
                  <td>
                    @if($key->flag_pegawai=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Aktif"><i class="fa fa-thumbs-up"></i></span>
                    @else
                      <span class="badge bg-red" data-toggle="tooltip" title="Tidak Aktif"><i class="fa fa-thumbs-down"></i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_pegawai=="1")
                      <span data-toggle="tooltip" title="Ubah Status">
                        <a href="#" class="btn btn-xs btn-danger btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heartbeat"></i></a>
                      </span>
                    @elseif($key->flag_pegawai=="0")
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
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
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
        $('#setflagpublish').attr('href', '{{url('admin/publish-pegawai/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-pegawai/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-pegawai/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var nama_pegawai = data.nama_pegawai;
            var jenis_kelamin = data.jenis_kelamin;
            var id_esselon = data.id_esselon;
            var id_pangkat = data.id_pangkat;
            var flag_pegawai = data.flag_pegawai;
            var url_foto = data.url_foto;


            if (url_foto!=null) {
              var foto = url_foto.split('.');
              $('#fotopegawai').attr('src', "{{url('images')}}/"+foto[0]+"_115x155."+foto[1]);
            } else {
              $('#fotopegawai').attr('src', "");
            }

            $('#id').attr('value', id);
            $('#nama_pegawai').attr('value', nama_pegawai);
            $('#esselon'+id_esselon).attr('selected', true);
            $('#pangkat'+id_pangkat).attr('selected', true);

            if(jenis_kelamin=="1") {
              $('#jk_pria').attr('checked', true);
              $('#jk_wanita').attr('checked', false);
            } else {
              $('#jk_pria').attr('checked', false);
              $('#jk_wanita').attr('checked', true);
            }

            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });

            if(flag_pegawai=="1") {
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
