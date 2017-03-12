@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Grafik Kategori Berita
    <small>Jumlah Kategori Berita SKPD</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Lihat Grafik Kategori Berita</li>
  </ol>
@stop

@section('content')


  <div class="row">
    <section class="col-lg-7 col-md-7 connectedSortable">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="active"><a href="#revenue-chart" data-toggle="tab">Grafik</a></li>
          <li class="pull-left header"><i class="fa fa-area-chart">
              </i> Jumlah Kategori Per SKPD</li>
        </ul>
        <div class="tab-content no-padding">
          <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
        </div>
      </div>
     </section>

     <section class="col-lg-5 col-md-5 connectedSortable">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-pie-chart"></i>Total Kategori</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-footer no-padding">
          <ul class="nav nav-pills nav-stacked">
            <li>
              <a>
                <b>SKPD Terkait</b>
                <span class="pull-right">
                  <b>
                    Jumlah Kategori
                  </b>
                </span>
              </a>
            </li>
              @if($getkategoriskpd->isEmpty())
                <tr>
                  <td colspan="5" class="text-muted" style="text-align:center;"><i>Data SKPD tidak tersedia.</i></td>
                </tr>
                @elseif(isset($getkategoriskpd))
                  @foreach($getkategoriskpd as $key)
                    <li>
                      <a href="{{route('kategori.by.skpd', $key->id)}}">
                        {{$key->nama_skpd}}
                        <span class="pull-right text-red">
                          <b>{{$key->jumlahkategori}}</b>
                        </span>
                      </a>
                    </li>
                  @endforeach
              @endif
              <div class="box-footer">
                <div class="pagination pagination-sm no-margin pull-right">
                  {{ $getkategoriskpd->links() }}
                </div>
              </div>
          </ul>
        </div><!-- /.footer -->
      </div><!-- /.box -->
    </section><!-- right col -->
  </div>

  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
  {{-- <script src="{{ asset('/plugins/jQueryUI/jquery-ui.min.js') }}"></script> --}}
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.5 -->
  <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- Morris.js charts -->
  <script src="{{ asset('/bootstrap/js/raphael-min.js') }}"></script>
  <script src="{{ asset('/plugins/morris/morris.min.js') }}"></script>
  <!-- Sparkline -->
  <script src="{{ asset('/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
  <!-- jvectormap -->
  <script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
  <script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('/plugins/knob/jquery.knob.js') }}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('/bootstrap/js/moment.min.js') }}"></script>
  <script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
  <!-- datepicker -->
  <script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
  <!-- Slimscroll -->
  <script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
  {{-- Chart JS --}}
  <script src="{{asset('plugins/chartjs/Chart.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{ asset('plugins/fastclick/fastclick.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/app.min.js') }}"></script>

  <!-- <script type="text/javascript">
      $(function () {
        var area = new Morris.Area({
        element: 'revenue-chart',
        resize: true,
        data: [
          {y: '2011 Q1', item1: 2666, item2: 2666},
          {y: '2011 Q2', item1: 2778, item2: 2294},
          {y: '2011 Q3', item1: 4912, item2: 1969},
          {y: '2011 Q4', item1: 3767, item2: 3597},
          {y: '2012 Q1', item1: 6810, item2: 1914},
          {y: '2012 Q2', item1: 5670, item2: 4293},
          {y: '2012 Q3', item1: 4820, item2: 3795},
          {y: '2012 Q4', item1: 15073, item2: 5967},
          {y: '2013 Q1', item1: 10687, item2: 4460},
          {y: '2013 Q2', item1: 8432, item2: 5713}
        ],
        xkey: 'y',
        ykeys: ['item1', 'item2'],
        labels: ['Item 1', 'Item 2'],
        lineColors: ['#a0d0e0', '#3c8dbc'],
        hideHover: 'auto'
      });

      });
    </script> -->
    <script type="text/javascript">
      $(function () {
        'use strict';
        $.ajax({
          type: "GET",
          url: "{{ url('kategoriberitachart') }}"
        })
        .done(function(datax) {
          $.ajax({
            type: "GET",
            url: "{{ url('countkategoriberitabyskpd') }}"
          })
          .done(function( dataxx ) {
            var area = new Morris.Area({
              element: 'revenue-chart',
              data: datax,
              xkey: 'y',
              ykeys: ['a', 'b', 'c', 'd', 'e'],
              labels: [dataxx[0], dataxx[1], dataxx[2], dataxx[3], dataxx[4]],
              lineColors: ['#FF0000', '#4169E1', '#2E8B57', '#FF1493', '#FFFF00'],
              hideHover: 'auto'
            });
          })
          .fail(function() {
            alert( "error parsing" );
          });
        })
        .fail(function() {
          alert( "error parsing" );
        });


      });
    </script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('dist/js/demo.js')}}"></script>
@stop
