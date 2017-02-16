@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Media Sosial
    <small>Kelola Akun Media Sosial</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Kelola Media Sosial</li>
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
      <form class="form-horizontal" action="{{route('sosmed.edit')}}" method="post">
        {{csrf_field()}}
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Akun</h4>
          </div>
          <div class="modal-body">
            <div class="col-md-14 {{ $errors->has('editsosmed') ? 'has-error' : '' }}">
              <label class="control-label">Social Media</label>
              <input type="hidden" name="id" id="idsosmed">
              <select class="form-control" name="editsosmed">
                <option value="-- Pilih --">-- Pilih --</option>
                <option value="facebook" id="sosmedfb">Facebook</option>
                <option value="twitter" id="sosmedtwit">Twitter</option>
                <option value="google-plus" id="sosmedgoogle">Google Plus</option>
                <option value="linkedin" id="sosmedlink">Linked In</option>
                <option value="youtube" id="sosmedyoutube">Youtube</option>
              </select>
            </div>
            <div class="col-md-14 {{ $errors->has('editlink') ? 'has-error' : '' }}">
              <label class="control-label">Link</label>
              <input type="text" name="editlink" class="form-control" id="editlink">
              @if ($errors->has('editlink'))
                <span class="help-block"><i>* {{$errors->first('editlink')}}</i></span>
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

    <form class="form-horizontal" method="post" action="{{route('sosmed.store')}}">
      {{ csrf_field() }}
        <div class="col-md-4">
          <div class="box box-success box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Formulir Set Link Media Sosial</h3>
            </div>
            <div class="box-body">

              <div class="col-md-14 {{ $errors->has('sosmed') ? 'has-error' : '' }}">
                <label class="control-label">Social Media</label>
                <select class="form-control" name="sosmed">
                  <option value="-- Pilih --">-- Pilih --</option>
                  <option value="facebook">Facebook</option>
                  <option value="twitter">Twitter</option>
                  <option value="google-plus">Google Plus</option>
                  <option value="linkedin">Linked In</option>
                  <option value="youtube">Youtube</option>
                </select>
                @if ($errors->has('sosmed'))
                  <span class="help-block"><i>* {{$errors->first('sosmed')}}</i></span>
                @endif
              </div>

              <div class="col-md-14 {{ $errors->has('link') ? 'has-error' : '' }}">
                <label class="control-label">Link</label>
                <input type="text" name="link" class="form-control">
                @if ($errors->has('link'))
                  <span class="help-block"><i>* {{$errors->first('link')}}</i></span>
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
            Seluruh Data Media Sosial
          </div>
        </div>
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Link</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($getsosmed as $key)
                <tr>
                  <td style="width:40px;">1</td>
                  <td>{{$key->nama_sosmed}}</td>
                  <td>
                    @php
                      if (strpos($key->link_sosmed, 'http') !== false) {
                        @endphp
                          <a href="{{$key->link_sosmed}}" target="_blank">{{$key->link_sosmed}}</a>
                        @php
                      } else {
                        @endphp
                        <a href="http://{{$key->link_sosmed}}" target="_blank">{{$key->link_sosmed}}</a>
                        @php
                      }
                    @endphp
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

  <script>
    $(function () {
      $("#tabelinfo").DataTable();

      $("#tabelinfo").on("click", "a.edit", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('/')}}/admin/bind-sosmed/"+a,
          dataType: 'json',
          success: function(data){
            var id = data.id;
            var nama = data.nama_sosmed;
            var link = data.link_sosmed;

            $('#idsosmed').attr('value', id);
            $('#editlink').attr('value', link);

            if (nama=="facebook") {
              $('#sosmedfb').attr('selected', true);
            } else if (nama=="twitter") {
              $('#sosmedtwit').attr('selected', true);
            } else if (nama=="google-plus") {
              $('#sosmedgoogle').attr('selected', true);
            } else if (nama=="linkedin") {
              $('#sosmedlink').attr('selected', true);
            } else if (nama=="youtube") {
              $('#sosmedyoutube').attr('selected', true);
            }

          }
        })
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-sosmed/')}}/'+a);
      });

    });
  </script>

@stop
