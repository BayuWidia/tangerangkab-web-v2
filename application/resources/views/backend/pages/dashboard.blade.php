@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
@stop

@section('content')
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-list-alt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Berita</span>
          <span class="info-box-number">{{$countberita}}</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-building"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah SKPD</span>
          <span class="info-box-number">{{$countskpd}}</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-mouse-pointer"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah Aplikasi</span>
          <span class="info-box-number">{{$countaplikasi}}</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Jumlah User</span>
          <span class="info-box-number">{{$countuser}}</span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="box box-success box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">
            @if(Auth::user()->level=="1")
              Seluruh Berita Terbaru
            @else
              Seluruh Berita {{Auth::user()->masterskpd->singkatan}}
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th style="width: 10px">#</th>
                <th>Judul</th>
                <th>Pembuat Berita</th>
                <th>Tanggal</th>
                <th>Views</th>
              </tr>
              @if(!$beritaterbaru->isEmpty())
                <?php $j=1; ?>
                @foreach($beritaterbaru as $key)
                  @if($j<=10)
                    <tr>
                      <td>{{$j}}</td>
                      <td>
                        <?php $judul = explode(" ", $key->judul_berita); ?>
                        @if(count($judul)<=5)
                          {{$key->judul_berita}}
                        @else
                          @for($i=0; $i < 5; $i++)
                            {{$judul[$i]}}
                          @endfor
                          ...
                        @endif
                      </td>
                      <td>
                        @if($key->nama_skpd=="")
                          Admin Web Utama
                        @else
                          @if($key->singkatan!="")
                            {{$key->singkatan}}
                          @else
                            {{$key->nama_skpd}}
                          @endif
                        @endif
                      </td>
                      <td>
                        <?php $date = explode(" ", $key->created_at); echo $date[0]; ?>
                      </td>
                      <td>
                        <span class="badge bg-blue">
                          @if($key->view_counter=="")
                            0
                          @else
                            {{$key->view_counter}}
                          @endif
                        </span>
                      </td>
                    </tr>
                  @endif
                  <?php $j++; ?>
                @endforeach
              @else
                <tr>
                  <td colspan="5" style="text-align:center" class="text-muted">
                    Data tidak tersedia.
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
        <div class="box-footer text-center">
          <a href="{{route('berita.lihat')}}" class="uppercase">Lihat Seluruh Berita</a>
        </div><!-- /.box-footer -->
      </div>
    </div>

    <div class="col-md-4">
      <div class="box box-success box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">
            @if(Auth::user()->level=="1")
              Headline Web Utama
            @else
              Headline Web {{Auth::user()->masterskpd->singkatan}}
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            @if(!$beritaheadline->isEmpty())
              @if(Auth::user()->level=="1")
                @foreach($beritaheadline as $key)
                  <li class="item">
                    <div class="product-img">
                      <?php $foto = explode(".", $key->url_foto) ?>
                      <img src="{{url('images')}}/{{$foto[0]}}_95x95.{{$foto[1]}}" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="{{route('berita.preview', $key->id_berita)}}" class="product-title">
                        <?php $judul = explode(" ", $key->judul_berita) ?>
                        @if(count($judul)<=3)
                          {{$key->judul_berita}}
                        @else
                          @for($i=0; $i < 3; $i++)
                            {{$judul[$i]}}
                          @endfor
                          ...
                        @endif
                        <span class="label label-warning pull-right">{{$key->nama_kategori}}</span>
                      </a>
                      <span class="product-description">
                        <?php $isi = explode(" ", strip_tags($key->isi_berita)); ?>
                        @if(count($isi)<=6)
                          <?php echo strip_tags($key->isi_berita); ?>
                        @else
                          @for($i=0; $i < 6; $i++)
                            {{$isi[$i]}}
                          @endfor
                          ...
                        @endif
                      </span>
                    </div>
                  </li><!-- /.item -->
                @endforeach
              @else
                <?php $j=1; ?>
                @foreach($beritaheadline as $key)
                  <li class="item">
                    <div class="product-img">
                      <?php $foto = explode(".", $key->url_foto) ?>
                      <img src="{{url('images')}}/{{$foto[0]}}_95x95.{{$foto[1]}}" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="{{route('berita.preview', $key->id_berita)}}" class="product-title">
                        <?php $judul = explode(" ", $key->judul_berita) ?>
                        @if(count($judul)<=3)
                          {{$key->judul_berita}}
                        @else
                          @for($i=0; $i < 3; $i++)
                            {{$judul[$i]}}
                          @endfor
                          ...
                        @endif
                        <span class="label label-warning pull-right">{{$key->nama_kategori}}</span>
                      </a>
                      <span class="product-description">
                        <?php $isi = explode(" ", strip_tags($key->isi_berita)); ?>
                        @if(count($isi)<=6)
                          <?php echo strip_tags($key->isi_berita); ?>
                        @else
                          @for($i=0; $i < 6; $i++)
                            {{$isi[$i]}}
                          @endfor
                          ...
                        @endif
                      </span>
                    </div>
                  </li><!-- /.item -->
                @endforeach
              @endif
            @else
              <li class="item text-muted" style="text-align:center;">Data tidak tersedia.</li>
            @endif
          </ul>
        </div><!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="{{route('berita.lihat')}}" class="uppercase">Lihat Seluruh Berita</a>
        </div><!-- /.box-footer -->
      </div>
    </div>
  </div>

  <div class="row">
    <section class="col-md-12">

    </section>
  </div><!-- /.row (main row) -->

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

@stop
