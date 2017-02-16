@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Data SKPD
    <small>Seluruh Data SKPD</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Seluruh Data SKPD</li>
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

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data SKPD</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus data ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger  btn-flat" id="sethapus">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalflagedit" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Status SKPD</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status data SKPD?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger  btn-flat" id="setflagedit">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('skpd.edit')}}" method="post" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Data SKPD</h4>
          </div>
          <div class="modal-body">
              {{ csrf_field() }}
                <div class="col-md-14">
                  <label class="control-label">Nama SKPD</label>
                  <input type="hidden" name="id" class="form-control" id="id">
                  <input type="text" name="nama_skpd" class="form-control" placeholder="Nama SKPD" id="nama_skpd">
                </div>
                <div class="col-md-14">
                  <label class="control-label">Singkatan</label>
                  <input type="text" name="singkatan" class="form-control" id="singkatan">
                </div>
                <div class="col-md-14">
                  <label class="control-label">Alamat</label>
                  <textarea name="alamat_skpd" rows="4" cols="40" class="form-control" id="alamat_skpd"></textarea>
                </div>
                <div class="col-md-14">
                  <label class="control-label">Logo Header SKPD</label>
                  <div>
                    <img src="" alt="Header belum di set." id="logo_skpd" style="margin-bottom:10px;"/>
                  </div>
                  <input type="file" name="logo_skpd" class="form-control" placeholder="Nama Domain">
                  <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                </div>
                <div class="col-md-14">
                  <label class="control-label">Status</label>
                  <select class="form-control" name="flag_skpd">
                    <option value="1" id="flag_aktif">Aktif</option>
                    <option value="0" id="flag_nonaktif">Tidak Aktif</option>
                  </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-success btn-flat">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modalview" role="dialog">
    <div class="modal-dialog">
      <form class="form-horizontal" action="{{route('skpd.edit')}}" method="post" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">view Data SKPD</h4>
          </div>
          <div class="modal-body">
              {{ csrf_field() }}
                <div class="col-md-14">
                  <label class="control-label">Nama SKPD</label>
                  <input type="hidden" name="id" class="form-control" id="id">
                  <input type="text" name="nama_skpd" class="form-control" placeholder="Nama SKPD" id="nama_skpd_view" readonly="true">
                </div>
                <div class="col-md-14">
                  <label class="control-label">Singkatan</label>
                  <input type="text" name="singkatan" class="form-control" id="singkatan_view" readonly="true">
                </div>
                <div class="col-md-14">
                  <label class="control-label">Alamat</label>
                  <textarea name="alamat_skpd" rows="4" cols="40" class="form-control" id="alamat_skpd_view" readonly="true"></textarea>
                </div>
                <div class="col-md-14">
                  <label class="control-label">Logo Header SKPD</label>
                  <div>
                    <img src="" alt="Header belum di set." id="logo_skpd_view" style="margin-bottom:10px;"/>
                  </div>
                  <input type="file" name="logo_skpd" class="form-control" placeholder="Nama Domain" disabled="true">
                  <span style="color:red;">* Biarkan kosong jika tidak ingin diganti.</span>
                </div>
                <div class="col-md-14">
                  <label class="control-label">Status</label>
                  <select class="form-control" name="flag_skpd" disabled="true">
                    <option value="1" id="flag_aktif_view">Aktif</option>
                    <option value="0" id="flag_nonaktif_view">Tidak Aktif</option>
                  </select>
                </div>
          </div>
          <div class="modal-footer">
            <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tutup Halaman</button>
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
      <form class="form-horizontal" action="{{route('skpd.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Kategori Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama_skpd') ? 'has-error' : '' }}">
              <label class="control-label">Nama SKPD</label>
              <input type="text" name="nama_skpd" class="form-control" placeholder="Nama SKPD"
                @if(!$errors->has('nama_skpd'))
                 value="{{ old('nama_skpd') }}"
                @endif
              >
              <div>
                @if($errors->has('nama_skpd'))
                 <span class="help-block">
                   <strong>* {{ $errors->first('nama_skpd')}}
                   </strong>
                 </span>
                @endif
              </div>
            </div>
            <div class="col-md-14 {{ $errors->has('singkatan') ? 'has-error' : '' }}">
              <label class="control-label">Singkatan</label>
              <input type="text" name="singkatan" class="form-control" placeholder="Singkatan"
                @if(!$errors->has('singkatan'))
                 value="{{ old('singkatan') }}"
                @endif
              >
              <div>
                @if($errors->has('singkatan'))
                 <span class="help-block">
                   <strong>* {{ $errors->first('singkatan')}}
                   </strong>
                 </span>
                @endif
              </div>
            </div>
            <div class="col-md-14 {{ $errors->has('alamat_skpd') ? 'has-error' : '' }}">
              <label class="control-label">Alamat</label>
              <textarea name="alamat_skpd" rows="4" cols="40" class="form-control" placeholder="Alamat SKPD">@if(!$errors->has('alamat_skpd')){{ old('alamat_skpd') }}@endif</textarea>
              <div>
                @if($errors->has('alamat_skpd'))
                 <span class="help-block">
                   <strong>* {{ $errors->first('alamat_skpd')}}
                   </strong>
                 </span>
                @endif
              </div>
            </div>
            <div class="col-md-14 {{ $errors->has('logo_skpd') ? 'has-error' : '' }}">
              <label class="control-label">Logo Header SKPD</label>
              <input type="file" name="logo_skpd" class="form-control" placeholder="Nama Domain">
              <div>
                @if($errors->has('logo_skpd'))
                 <span class="help-block">
                   <strong>* {{ $errors->first('logo_skpd')}}
                   </strong>
                 </span>
                @endif
              </div>
            </div>
            <div class="col-md-14">
              <label class="control-label">Status</label>
              <select class="form-control" name="flag_skpd">
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
          <h3 class="box-title">Seluruh Data SKPD</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama SKPD</th>
                <th>Singkatan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getskpd as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->nama_skpd}}</td>
                  <td>
                    @if($key->singkatan=="")
                      <span class="text-muted"><i>Belum di set.</i></span>
                    @else
                      {{$key->singkatan}}
                    @endif
                  </td>
                  <td>
                    @if($key->flag_skpd=="1")
                      <span class="label bg-green">Aktif</span>
                    @else
                      <span class="label bg-red">Tidak Aktif</span>
                    @endif
                  </td>
                  <td>
                    @if($key->flag_skpd=="1")
                      <span data-toggle="tooltip" title="Non Aktifkan">
                        <a href="#" class="btn btn-xs btn-danger btn-flat flagedit" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heartbeat"></i></a>
                      </span>
                    @else
                      <span data-toggle="tooltip" title="Aktifkan">
                        <a href="#" class="btn btn-xs btn-success btn-flat flagedit" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id}}"><i class="fa fa-heart"></i></a>
                      </span>
                    @endif
                    <span data-toggle="tooltip" title="Ubah">
                      <a href="#" class="btn btn-xs btn-warning btn-flat edit" data-toggle="modal" data-target="#modaledit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                    </span>
                    <span data-toggle="tooltip" title="Hapus">
                      <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id}}"><i class="fa fa-remove"></i></a>
                    </span>
                    <span data-toggle="tooltip" title="Lihat Website">
                      <a href="#" class="btn btn-xs btn-primary btn-flat view" data-toggle="modal" data-target="#modalview" data-value="{{$key->id}}"><i class="fa fa-eye"></i></a>
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

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-skpd/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.flagedit", function(){
        var a = $(this).data('value');
        $('#setflagedit').attr('href', '{{url('admin/change-status-skpd/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/admin/bind-skpd/"+a,
          dataType: 'json',
          success: function(data){
            //get
            var id = data.id;
            var nama_skpd = data.nama_skpd;
            var flag_skpd = data.flag_skpd;
            var singkatan = data.singkatan;
            var alamat = data.alamat_skpd;
            var logo_skpd = data.logo_skpd;

            //set
            $('#id').attr('value', id);
            $('#nama_skpd').attr('value', nama_skpd);
            $('#singkatan').attr('value', singkatan);
            $('#alamat_skpd').val(alamat);

            var gambar = logo_skpd.split(".");
            var logo_skpd = gambar[0] + "_200x122." + gambar[1];
            $('#logo_skpd').attr('src', "{{url('/images')}}/" + logo_skpd);

            if (flag_skpd=="1") {
              $('option#flag_aktif').attr('selected', true);
            } else {
              $('option#flag_nonaktif').attr('selected', true);
            }
          }
        });
      });


      $("#tabelinfo").on("click", "a.view", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{ url('/') }}/admin/bind-skpd/"+a,
          dataType: 'json',
          success: function(data){
            //get
            var id = data.id;
            var nama_skpd = data.nama_skpd;
            var flag_skpd = data.flag_skpd;
            var singkatan = data.singkatan;
            var alamat = data.alamat_skpd;
            var logo_skpd = data.logo_skpd;

            //set
            $('#id_view').attr('value', id);
            $('#nama_skpd_view').attr('value', nama_skpd);
            $('#singkatan_view').attr('value', singkatan);
            $('#alamat_skpd_view').val(alamat);

            var gambar = logo_skpd.split(".");
            var logo_skpd = gambar[0] + "_200x122." + gambar[1];
            $('#logo_skpd_view').attr('src', "{{url('/images')}}/" + logo_skpd);

            if (flag_skpd=="1") {
              $('option#flag_aktif_view').attr('selected', true);
            } else {
              $('option#flag_nonaktif_view').attr('selected', true);
            }
          }
        });
      });
    });
  </script>

@stop
