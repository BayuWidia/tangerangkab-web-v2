@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Berita
    <small>Preview Konten</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Lihat Berita</li>
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

      <div class="box box-widget">
        <div class="box-header with-border">
          <div class="user-block">
            @if($getberita->foto_user=="")
              <img class="img-circle" src="{{url('images')}}/user-not-found.png" alt="user image">
            @else
              <img class="img-circle" src="{{url('images')}}/{{$getberita->foto_user}}" alt="user image">
            @endif
            <span class="username"><a>{{$getberita->judul_berita}}</a></span>
            <span class="description">
              @if($getberita->nama_skpd=="")
                Konten Web Terpadu
              @else
                SKPD : {{$getberita->nama_skpd}}
              @endif
               || Kategori : {{$getberita->nama_kategori}}
               || Tanggal Posting :
               <?php $date = explode(" ", $getberita->tanggal_posting); ?>
               <?php $format = explode("-", $date[0]);?>
               <?php echo $format[2]."-".$format[1]."-".$format[0] ?>
            </span>
          </div><!-- /.user-block -->
          <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
          <!-- post text -->
          <?php echo $getberita->isi_berita ?>

        </div><!-- /.box-body -->

        {{-- <div class="box-footer">
          <span data-toggle="tooltip" title="Ubah Status Publikasi">
            <a class="btn btn-danger btn-flat flagpublish pull-right" data-value="{{$getberita->id_berita}}"
              @if($getberita->flag_publish=="1")
                disabled
              @else
                data-toggle="modal" data-target="#modalflagedit"
              @endif
            >Publikasikan Berita Ini</a>
          </span>
        </div><!-- /.box-footer --> --}}
      </div>
    </div>
  </div>

  <!-- jQuery 2.1.4 -->
  <script src="{{asset('plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
  <!-- Tags Input -->
  <script src="{{asset('bootstrap/js/bootstrap-tagsinput.js')}}"></script>
  <!-- SlimScroll -->
  <script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('plugins/fastclick/fastclick.min.js')}}"></script>
  <!-- iCheck 1.0.1 -->
  <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/app.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>

  <script type="text/javascript">
    $(function(){
        $("a.flagpublish").click(function(){
          var a = $(this).data('value');
          $('#setflagpublish').attr('href', '{{url('admin/publish-berita/')}}/'+a);
        });
    })
  </script>


@stop
