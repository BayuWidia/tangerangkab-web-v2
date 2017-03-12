@extends('backend.layouts.master')

@section('title')
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
@stop

@section('breadcrumb')
  <h1>
    Grafik Akun
    <small>Jumlah Akun SKPD</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">Lihat Grafik Akun</li>
  </ol>
@stop

@section('content')
  <div class="row">
    <div class="col-md-12">
      @if(Session::has('firsttimelogin'))
        <div class="alert alert-success panjang">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Selamat Datang!</h4>
          <p>{{ Session::get('firsttimelogin') }}</p>
        </div>
      @endif
    </div>
    <div class="col-lg-4 col-md-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{$getakunaktif}}</h3>
          <p>Jumlah Akun Aktif</p>
        </div>
        <div class="icon">
          <i class="fa fa-smile-o"></i>
        </div>
        <a class="small-box-footer">
          <i>data akun yang aktif semua SKPD</i>
        </a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-md-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>{{$getakunall}}</h3>
          <p>Jumlah Semua Akun</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <a href="{{url('admin/kelola-akun')}}"
         class="small-box-footer">Lihat Data Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-md-3 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-purple">
        <div class="inner">
          <h3>{{$getakuntdkaktif}}</h3>
          <p>Jumlah Akun Yang Tidak Aktif</p>
        </div>
        <div class="icon">
          <i class="fa fa-frown-o"></i>
        </div>
        <a class="small-box-footer">
          <i>data akun yang tidak aktif semua SKPD</i>
        </a>
      </div>
    </div><!-- ./col -->
  </div><!-- /.row -->

  <div class="row">
    <section class="col-lg-12 col-md-12 connectedSortable">
      <!-- Custom tabs (Charts with tabs)-->
      <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs pull-right">
          <li class="active"><a href="#revenue-chart" data-toggle="tab">Grafik</a></li>
          <li class="pull-left header"><i class="fa fa-area-chart">
              </i> Jumlah Akun Per SKPD</li>
        </ul>
        <div class="tab-content no-padding">
          <!-- Morris chart - Sales -->
          <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
        </div>
      </div><!-- /.nav-tabs-custom -->

     </section>
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
          url: "{{ url('akunchart') }}"
        })
        .done(function(datax) {
          $.ajax({
            type: "GET",
            url: "{{ url('countakunbyskpd') }}"
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
