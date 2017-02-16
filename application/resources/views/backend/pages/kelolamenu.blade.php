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
    Manajemen Menu
    <small>Kelola Menu</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Menu</li>
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
          <h4 class="modal-title">Hapus Menu</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus menu ini?</p>
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
            <h4 class="modal-title">Edit Data Menu</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14 {{ $errors->has('nama') ? 'has-error' : '' }}">
              <label class="control-label">Nama Menu</label>
              <input type="text" name="nama" class="form-control"
                @if (!$errors->has('nama'))
                  value="{{ old('nama') }}"
                @endif
              id="namaedit">
              @if ($errors->has('nama'))
                <span class="help-block">
                  <i>* {{ $errors->first('nama') }}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('level') ? 'has-error' : '' }}">
              <label class="control-label">Level Menu</label>
              <select class="form-control" name="level" id="levelmenuedit">
                <option value="-- Pilih --">-- Pilih --</option>
                <option value="1" {{ old('level')==1 ? 'selected' : '' }} id="levelmenuedit1">Main Menu</option>
                <option value="2" {{ old('level')==2 ? 'selected' : '' }} id="levelmenuedit2">Sub Menu</option>
              </select>
              @if ($errors->has('level'))
                <span class="help-block">
                  <i>* {{ $errors->first('level') }}</i>
                </span>
              @endif
              <div style="margin-top:5px;" id="idlinkcheckedit">
                <input type="checkbox" id="linkcheckedit"> Tandai bila main menu memiliki link.
              </div>
            </div>
            <div class="col-md-14" id="linkmainmenuedit">
              <label class="control-label">Link Main Menu</label>
              <div class="input-group">
                <span class="input-group-addon">http://</span>
                <input type="text" name="linkmainmenu" class="form-control" id="linkedit">
              </div>
            </div>
            <div class="col-md-14 {{ $errors->has('parent_menu') ? 'has-error' : '' }}" id="submenuedit">
              <label class="control-label">Pilih Menu Utama</label>
              <select class="form-control" name="parent_menu" id="parentmenuedit">
                <option value="000">-- Pilih --</option>
                @foreach($getmain as $key)
                  <option value="{{$key->id}}" id="submenuedit{{$key->id}}">{{$key->nama}}</option>
                @endforeach
              </select>
              @if(count($getmain)==0)
                <span class="text-muted" style="color:red;">* Anda belum memiliki Main Menu.</span>
              @endif
              @if ($errors->has('parent_menu'))
                <span class="help-block">
                  <i>* {{ $errors->first('parent_menu') }}</i>
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
      <form class="form-horizontal" action="{{route('menu.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Formulir Tambah Menu Baru</h3>
          </div>
          <div class="box-body">
            <div class="col-md-14 {{ $errors->has('nama') ? 'has-error' : '' }}">
              <label class="control-label">Nama Menu</label>
              <input type="text" name="nama" class="form-control"
                @if (!$errors->has('nama'))
                  value="{{ old('nama') }}"
                @endif
              >
              @if ($errors->has('nama'))
                <span class="help-block">
                  <i>* {{ $errors->first('nama') }}</i>
                </span>
              @endif
            </div>
            <div class="col-md-14 {{ $errors->has('level') ? 'has-error' : '' }}">
              <label class="control-label">Level Menu</label>
              <select class="form-control" name="level" id="levelmenu">
                <option value="-- Pilih --">-- Pilih --</option>
                <option value="1" {{ old('level')==1 ? 'selected' : '' }}>Main Menu</option>
                <option value="2" {{ old('level')==2 ? 'selected' : '' }}>Sub Menu</option>
              </select>
              @if ($errors->has('level'))
                <span class="help-block">
                  <i>* {{ $errors->first('level') }}</i>
                </span>
              @endif
              <div style="margin-top:5px;" id="idlinkcheck">
                <input type="checkbox" id="linkcheck"> Tandai bila main menu memiliki link.
              </div>
            </div>
            <div class="col-md-14" id="linkmainmenu">
              <label class="control-label">Link Main Menu</label>
              <div class="input-group">
                <span class="input-group-addon">http://</span>
                <input type="text" name="linkmainmenu" class="form-control";>
              </div>
            </div>
            <div class="col-md-14 {{ $errors->has('parent_menu') ? 'has-error' : '' }}" id="submenu">
              <label class="control-label">Pilih Menu Utama</label>
              <select class="form-control" name="parent_menu">
                <option value="000">-- Pilih --</option>
                @foreach($getmain as $key)
                  <option value="{{$key->id}}">{{$key->nama}}</option>
                @endforeach
              </select>
              @if(count($getmain)==0)
                <span class="text-muted" style="color:red;">* Anda belum memiliki Main Menu.</span>
              @endif
              @if ($errors->has('parent_menu'))
                <span class="help-block">
                  <i>* {{ $errors->first('parent_menu') }}</i>
                </span>
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
          <h3 class="box-title">Seluruh Data Menu</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Parent Menu</th>
                <th>Link Main Menu</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              @foreach($getmenu as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->nama}}</td>
                  <td>
                    @if($key->level=="1")
                      Main Menu
                    @else
                      Sub Menu
                    @endif
                  </td>
                  <td>
                    @if($key->parent_menu)
                      @foreach($getparent as $keys)
                        @if($key->parent_menu==$keys->id)
                          {{$keys->nama}}
                        @endif
                      @endforeach
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    @if ($key->linkmainmenu!="")
                      <a href="{{$key->linkmainmenu}}" target="_blank">Link</a>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                    {{-- <span data-toggle="tooltip" title="Edit">
                      <a href="#" class="btn btn-xs btn-warning btn-flat edit" data-toggle="modal" data-target="#modaledit" data-value="{{$key->id}}"><i class="fa fa-edit"></i></a>
                    </span> --}}
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
      var level = $('#levelmenu').val();
      if (level==2) {
        $('#submenu').show();
      } else {
        $('#submenu').hide();
        $('#idlinkcheck').hide();
        $('#linkmainmenu').hide();
      }

      $('#linkcheck').click(function(){
        if (this.checked) {
          $('#linkmainmenu').show();
        } else {
          $('#linkmainmenu').hide();
        }
      });

      $('#linkcheckedit').click(function(){
        if (this.checked) {
          $('#linkmainmenuedit').show();
        } else {
          $('#linkmainmenuedit').hide();
        }
      });

      $('#levelmenu').change(function(){
        var a = $(this).val();
        if (a==2) {
          $('#idlinkcheck').hide();
          $('#submenu').show();
        } else if(a==1){
          $('#idlinkcheck').show();
          $('#submenu').hide();
        } else {
          $('#submenu').hide();
        }
      });

      $('#levelmenuedit').change(function(){
        var a = $(this).val();
        if (a==2) {
          $('#idlinkcheckedit').hide();
          $('#submenuedit').show();
        } else if (a==1) {
          $('#idlinkcheckedit').show();
          $('#submenuedit').hide();
        } else {
          $('#submenuedit').hide();
        }
      });

      $("#tabelinfo").DataTable();

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-menu/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('admin/bind-menu')}}/" + a,
          success: function(data){
            var parent_menu = data.parent_menu;
            var nama = data.nama;
            var level = data.level;
            var linkmainmenu = data.linkmainmenu;


            if (level==1) {
              if (linkmainmenu!="") {
                $('#linkcheckedit').attr('checked',true);
                $('#linkmainmenuedit').show()
                var potonglink = linkmainmenu.substring(7);
                $('#linkedit').val(potonglink);
              } else {
                $('#linkcheckedit').attr('checked',false);
                $('#linkmainmenuedit').hide()
              }

              $('#submenuedit').hide();
              $('#namaedit').val(nama);
              $('#levelmenuedit1').attr('selected', true);
              $('#levelmenuedit2').removeAttr('selected');
              $('#idlinkcheckedit').show();
            } else {
              $('#idlinkcheckedit').hide();
              $('#linkmainmenuedit').hide()
              $('#linkmainmenuedit').hide()
              $('#submenuedit').show();
              $('#namaedit').val(nama);
              $('#levelmenuedit2').attr('selected', true);
              $('#levelmenuedit1').removeAttr('selected');

              ////////////// BUGS //////////////////
              $('#parentmenuedit option:selected').prop('selected', false);
              $('#submenuedit'+parent_menu).attr('selected', true);
              ////////////// BUGS //////////////////
            }
          }
        })
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

      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });
    });
  </script>

@stop
