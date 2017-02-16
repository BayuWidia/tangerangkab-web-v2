@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Konten Menu
    <small>Seluruh Konten Menu</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Seluruh Konten Menu</li>
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
          <h4 class="modal-title">Edit Status Publikasi</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status publikasi untuk konten ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="setflagpublish">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewcontent" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="width:700px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="viewcontenttitle"></h4>
        </div>
        <div class="modal-body" id="viewcontentisi">

        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-right btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Konten Menu</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk menghapus konten ini?</p>
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

    <div class="col-md-12">
      <div class="box box-success box-solid">
        <div class="box-header">
          <h3 class="box-title">Seluruh Konten Menu</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Sub Menu</th>
                <th>Tanggal Post</th>
                <th>Status Publikasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php
                $i=1;
              @endphp
              @foreach ($getkonten as $key)
                <tr>
                  <td>{{$i}}</td>
                  <td>{{$key->judul_konten}}</td>
                  <td>{{$key->nama}}</td>
                  <td>{{$key->tanggal_post}}</td>
                  <td>
                    @if($key->flagpublish=="1")
                      <span class="badge bg-green" data-toggle="tooltip" title="Artikel telah dipublikasi"><i class="fa fa-thumbs-up"></i></span>
                    @elseif($key->flagpublish=="0")
                      <span class="badge bg-red" data-toggle="tooltip" title="Artikel belum dipublikasi"><i class="fa fa-thumbs-down"></i></span>
                    @endif
                  </td>
                  <td>
                    @if($key->flagpublish=="1")
                      <span data-toggle="tooltip" title="Ubah Status Publikasi">
                        <a href="#" class="btn btn-xs btn-danger btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_konten}}"><i class="fa fa-heartbeat"></i></a>
                      </span>
                    @elseif($key->flagpublish=="0")
                      <span data-toggle="tooltip" title="Ubah Status Publikasi">
                        <a href="#" class="btn btn-xs btn-success btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_konten}}"><i class="fa fa-heart"></i></a>
                      </span>
                    @endif
                    <span data-toggle="tooltip" title="Edit">
                      <a href="{{route('menukonten.edit', $key->id_konten)}}" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                    </span>
                    <span data-toggle="tooltip" title="Hapus">
                      <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id_konten}}"><i class="fa fa-remove"></i></a>
                    </span>
                    <span data-toggle="tooltip" title="Lihat Konten">
                      <a href="{{route('berita.preview', $key->id_konten)}}" class="btn btn-xs btn-primary btn-flat viewcontent" data-toggle="modal" data-target="#viewcontent" data-value="{{$key->id_konten}}"><i class="fa fa-eye"></i></a>
                    </span>
                  </td>
                </tr>
                @php
                  $i++;
                @endphp
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
        $('#setflagpublish').attr('href', '{{url('admin/change-menukonten/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-menukonten/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.viewcontent", function(){
        var a = $(this).data('value');
        $.ajax({
          url: "{{url('admin/bind-menukonten')}}/"+a,
          success: function(data){
            var judul_konten = data.judul_konten;
            var isi_konten = data.isi_konten;

            $("#viewcontenttitle").html(judul_konten);
            $("#viewcontentisi").html(isi_konten);
          }
        });
      });
    });
  </script>

@stop
