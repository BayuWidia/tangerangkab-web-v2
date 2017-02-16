@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Berita
    <small>Seluruh Berita</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Seluruh Berita</li>
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

  <div class="modal fade" id="modalflagheadlineutama" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Status Headline Utama</h4>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin untuk mengubah status headline utama untuk konten ini?</p>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tidak</button>
          <a class="btn btn-danger btn-flat" id="setflagheadlineutama">Ya, saya yakin</a>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modaldelete" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Info Utama</h4>
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
          <h3 class="box-title">Seluruh Berita</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table id="tabelinfo" class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Post</th>
                <th>Pembuat Berita</th>
                <th>Headline
                  @if (Auth::user()->level=="1")
                    SKPD
                  @endif
                </th>
                @if (Auth::user()->level=="1")
                  <th>Headline Utama</th>
                @endif
                <th>Publikasi Web Utama</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; ?>
              <?php $no=1; ?>
              @foreach($getberita as $key)
                <tr>
                  <td>{{$no}}</td>
                    <?php $judulexplode = explode(' ', $key->judul_berita); ?>
                  <td>
                    @if(count($judulexplode)>4)
                      @for($i=0; $i < 4; $i++)
                        {{$judulexplode[$i]}}
                      @endfor
                      ...
                    @else
                      {{$key->judul_berita}}
                    @endif
                  </td>
                  <td>{{$key->nama_kategori}}</td>
                  <td>
                    <?php $date = explode(" ", $key->tanggal_posting); echo $date[0]; ?>
                  </td>
                  <td>
                    @if($key->nama_skpd=="")
                      Admin Web Utama
                    @else
                      {{$key->nama_skpd}}
                    @endif
                  </td>
                  <td>
                    @if ($key->nama_skpd=="")
                      -
                    @else
                      @if (Auth::user()->level=="1")
                        @if($key->flag_headline)
                          <span class="badge bg-green" data-toggle="tooltip" title="Artikel ini adalah Headline pada Web SKPD"><i class="fa fa-thumbs-up"></i></span>
                        @else
                          <span class="badge bg-red" data-toggle="tooltip" title="Artikel ini bukan Headline pada Web SKPD"><i class="fa fa-thumbs-down"></i></span>
                        @endif
                      @else
                        @if($key->flag_headline)
                          <span class="badge bg-green" data-toggle="tooltip" title="Artikel ini adalah Headline"><i class="fa fa-thumbs-up"></i></span>
                        @else
                          <span class="badge bg-red" data-toggle="tooltip" title="Artikel ini bukan Headline"><i class="fa fa-thumbs-down"></i></span>
                        @endif
                      @endif
                    @endif
                  </td>
                  @if (Auth::user()->level=="1")
                    <td>
                      @if($key->flag_headline_utama)
                          <span class="badge bg-green" data-toggle="tooltip" title="Artikel ini adalah Headline pada Web Utama. Klik icon ini untuk mengubah status Headline.">
                            <a href="#" class="flagheadlineutama" style="color:#fff;" data-toggle="modal" data-target="#modalflagheadlineutama" data-value="{{$key->id_berita}}">
                              <i class="fa fa-thumbs-up"></i>
                            </a>
                          </span>
                      @else
                          <span class="badge bg-red" data-toggle="tooltip" title="Artikel ini bukan Headline pada Web Utama. Klik icon ini untuk mengubah status Headline.">
                            <a href="#" class="flagheadlineutama" style="color:#fff;" data-toggle="modal" data-target="#modalflagheadlineutama" data-value="{{$key->id_berita}}">
                              <i class="fa fa-thumbs-down"></i>
                            </a>
                          </span>
                      @endif
                    </td>
                  @endif
                  <td>
                    @if(Auth::user()->level=="1")
                      @if($key->flag_publish=="1")
                        <span class="badge bg-green" data-toggle="tooltip" title="Artikel telah dipublikasi. Klik icon ini untuk mengubah status publikasi.">
                          <a href="#" class="flagpublish" style="color:#fff;" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_berita}}"><i class="fa fa-thumbs-up"></i></a>
                        </span>
                      @elseif($key->flag_publish=="0")
                        <span class="badge bg-red" data-toggle="tooltip" title="Artikel belum dipublikasi.  Klik icon ini untuk mengubah status publikasi.  ">
                          <a href="#" class="flagpublish" style="color:#fff;" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_berita}}"><i class="fa fa-thumbs-down"></i></a>
                        </span>
                      @endif
                    @else
                      @if($key->flag_publish=="1")
                        <span class="badge bg-green" data-toggle="tooltip" title="Artikel telah dipublikasi"><i class="fa fa-thumbs-up"></i></span>
                      @elseif($key->flag_publish=="0")
                        <span class="badge bg-red" data-toggle="tooltip" title="Menunggu persetujuan Administrator Web Utama"><i class="fa fa-thumbs-down"></i></span>
                      @endif
                    @endif
                  </td>
                  <td>
                    {{-- @if(Auth::user()->level=="1")
                      @if($key->flag_publish=="1")
                        <span data-toggle="tooltip" title="Ubah Status Publikasi">
                          <a href="#" class="btn btn-xs btn-danger btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_berita}}"><i class="fa fa-heartbeat"></i></a>
                        </span>
                      @elseif($key->flag_publish=="0")
                        <span data-toggle="tooltip" title="Ubah Status Publikasi">
                          <a href="#" class="btn btn-xs btn-success btn-flat flagpublish" data-toggle="modal" data-target="#modalflagedit" data-value="{{$key->id_berita}}"><i class="fa fa-heart"></i></a>
                        </span>
                      @endif
                    @endif --}}

                    @if(Auth::user()->level!="1")
                      @if($key->flag_publish=="1")
                        <span data-toggle="tooltip" title="Artikel yang telah dipublikasikan tidak dapat di edit">
                          <a class="btn btn-xs btn-warning btn-flat" disabled><i class="fa fa-edit"></i></a>
                        </span>
                        <span data-toggle="tooltip" title="Artikel yang telah dipublikasikan tidak dapat di hapus">
                          <a class="btn btn-xs btn-danger btn-flat hapus" disabled><i class="fa fa-remove"></i></a>
                        </span>
                      @else
                        <span data-toggle="tooltip" title="Edit">
                          <a href="{{route('berita.edit', $key->id_berita)}}" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                        </span>
                        <span data-toggle="tooltip" title="Hapus">
                          <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id_berita}}"><i class="fa fa-remove"></i></a>
                        </span>
                      @endif
                    @else
                      <span data-toggle="tooltip" title="Edit">
                        <a href="{{route('berita.edit', $key->id_berita)}}" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-edit"></i></a>
                      </span>
                      <span data-toggle="tooltip" title="Hapus">
                        <a href="#" class="btn btn-xs btn-danger btn-flat hapus" data-toggle="modal" data-target="#modaldelete" data-value="{{$key->id_berita}}"><i class="fa fa-remove"></i></a>
                      </span>
                    @endif
                    <span data-toggle="tooltip" title="Lihat Konten">
                      <a href="{{route('berita.preview', $key->id_berita)}}" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></a>
                    </span>
                  </td>
                </tr>
                <?php $i++; ?>
                <?php $no++; ?>
              @endforeach
              @for($i=0; $i < 10; $i++)

              @endfor
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
        $('#setflagpublish').attr('href', '{{url('admin/publish-berita/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.flagheadlineutama", function(){
        var a = $(this).data('value');
        $('#setflagheadlineutama').attr('href', '{{url('admin/headline-utama/')}}/'+a);
      });

      $("#tabelinfo").on("click", "a.hapus", function(){
        var a = $(this).data('value');
        $('#sethapus').attr('href', '{{url('admin/delete-berita/')}}/'+a);
      });
    });
  </script>

@stop
