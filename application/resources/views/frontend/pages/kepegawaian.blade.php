@extends('frontend.layouts.page')

@section('title')
  <title>Kepegawaian | Web Terpadu Kabupaten Tangerang</title>
  <script type="text/javascript" src="{{ asset('theme/js/jquery.js') }}"></script>
  <script src="{{url('/')}}/plugins/highcharts/highcharts.js"></script>
  <script src="{{url('/')}}/plugins/highcharts/exporting.js"></script>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@stop
	@section('content')
			<div class="container">
			<div class="page-breadcrumbs">
				<h1 class="section-title">Kepegawaian</h1>
			</div>
			<div class="section">
				<div class="row">
					<div class="col-sm-9">
						<div id="site-content" class="site-content">
							<div class="row">
								<div class="col-sm-12">
									<div class="left-content">
										<div class="details-news">
											<div class="post">
												<div class="post-content">
													<h2 class="entry-title">
													  Daftar Pegawai
													</h2>
													<div class="entry-content">
                            Berikut adalah seluruh daftar pegawai di Pemerintahan Kabupaten Tangerang:
                            <br><br>
                            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                            <br><br>

                            <table class="table table-bordered" style="margin-top:20px">
                              <thead>
                                <tr>
                                  <th rowspan="2">No.</th>
                                  <th rowspan="2">Nama SKPD</th>
                                  <th rowspan="2" style="text-align:center;">Jumlah Pegawai</th>
                                  <th colspan="8" style="text-align:center;">Esselon</th>
                                </tr>
                                <tr>
                                  <th>II/a</th>
                                  <th>II/b</th>
                                  <th>III/a</th>
                                  <th>III/b</th>
                                  <th>IV/a</th>
                                  <th>IV/b</th>
                                  <th>V/a</th>
                                  <th>Non</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $no=1;
                                  $id_skpd_before=0;
                                  $flagfirst=0;
                                  $tdtable = ["<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>"];
                                @endphp
                                @foreach ($detailtable2 as $key)
                                  @if ($id_skpd_before!=$key->id_skpd)

                                    @php
                                    $id_skpd_before=$key->id_skpd;
                                    @endphp

                                    @if ($flagfirst==0)
                                      <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$key->nama_skpd}}</td>
                                        <td style="text-align:center;">
                                          @foreach ($getjumlahpegawaiperskpd as $x)
                                            @if ($key->id_skpd==$x->id_skpd)
                                              {{$x->jumlah}}
                                            @endif
                                          @endforeach
                                        </td>

                                        @for ($i=1; $i <= 8; $i++)
                                          @if ($key->id_esselon==$i)
                                            @php
                                            $tdtable[$i-1] = "<td>".$key->jumlah_pegawai."</td>";
                                            @endphp
                                          @endif
                                        @endfor

                                        @php
                                          $flagfirst++;
                                        @endphp
                                    @else
                                        @foreach ($tdtable as $keys)
                                          @php
                                            echo $keys;
                                          @endphp
                                        @endforeach
                                        @php
                                          $tdtable = ["<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>","<td>-</td>"];
                                          $no++;
                                        @endphp
                                      </tr>
                                      <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$key->nama_skpd}}</td>
                                        <td style="text-align:center;">
                                          @foreach ($getjumlahpegawaiperskpd as $x)
                                            @if ($key->id_skpd==$x->id_skpd)
                                              {{$x->jumlah}}
                                            @endif
                                          @endforeach
                                        </td>

                                        @for ($i=1; $i <= 8; $i++)
                                          @if ($key->id_esselon==$i)
                                            @php
                                            $tdtable[$i-1] = "<td>".$key->jumlah_pegawai."</td>";
                                            @endphp
                                          @endif
                                        @endfor

                                        @php
                                          $flagfirst++;
                                        @endphp
                                    @endif
                                  @else
                                    @php
                                    $id_skpd_before=$key->id_skpd;
                                    @endphp

                                    @for ($i=1; $i <= 8; $i++)
                                      @if ($key->id_esselon==$i)
                                        @php
                                        $tdtable[$i-1] = "<td>".$key->jumlah_pegawai."</td>";
                                        @endphp
                                      @endif
                                    @endfor
                                  @endif
                                @endforeach
                                @foreach ($tdtable as $keys)
                                  @php
                                    echo $keys;
                                  @endphp
                                @endforeach
                              </tbody>
                            </table>

                            {{-- <table class="table table-bordered" style="margin-top:20px;">
                              <thead>
                                <tr>
                                  <th style="width:50px;">No.</th>
                                  <th>Nama SKPD</th>
                                  <th>Esselon</th>
                                  <th>Jumlah Pegawai</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $countskpd = array();
                                  foreach ($detailtable as $key) {
                                    $countskpd[] = $key->nama_skpd;
                                  }
                                  $countvalues = array_count_values($countskpd);
                                  $flagrowspan = 0;
                                  $no = 1;
                                @endphp
                                @foreach ($detailtable as $key)
                                  @if ($flagrowspan==0)
                                    <tr>
                                      <td rowspan="{{$countvalues[$key->nama_skpd]}}" style="width:50px;">{{$no}}</td>
                                      <td rowspan="{{$countvalues[$key->nama_skpd]}}">{{$key->nama_skpd}}</td>
                                      <td>{{$key->nama_esselon}}</td>
                                      <td>{{$key->jumlah_pegawai}}</td>
                                    </tr>
                                    @php
                                      $flagrowspan++;
                                      $no++;
                                      if ($flagrowspan==$countvalues[$key->nama_skpd]) {
                                        $flagrowspan=0;
                                      }
                                    @endphp
                                  @else
                                    <tr>
                                      <td>{{$key->nama_esselon}}</td>
                                      <td>{{$key->jumlah_pegawai}}</td>
                                    </tr>
                                    @php
                                      $flagrowspan++;
                                      if ($flagrowspan==$countvalues[$key->nama_skpd]) {
                                        $flagrowspan=0;
                                      }
                                    @endphp
                                  @endif
                                @endforeach
                              </tbody>
                            </table> --}}
													</div>
												</div>
											</div><!--/post-->
										</div><!--/.section-->
									</div><!--/.left-content-->
								</div>
							</div>
						</div><!--/#site-content-->
					</div><!--/.col-sm-9 -->

					<div class="col-sm-3">
						<div id="sitebar">
              <div class="widget meta-widget">
								<div class="meta-tab">
									<div class="tab-content">
										<div class="add featured-add">
											<div class="widget follow-us">
                        {{-- google translate --}}
                        <div id="google_translate_element"></div>
                        <br>
                        <script type="text/javascript">
                        function googleTranslateElementInit() {
                          new google.translate.TranslateElement({pageLanguage: 'id'}, 'google_translate_element');
                        }
                        </script>
                        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                        {{-- google translate --}}

												<h1 class="section-title title">Follow Us</h1>
												<ul class="list-inline social-icons">
													@foreach ($getsosmed as $key)
														@if (strpos($key->link_sosmed, 'http') !== false)
															<li><a href="{{$key->link_sosmed}}" target="_blank"><i class="fa fa-{{$key->nama_sosmed}}"></i></a></li>
														@else
															<li><a href="http://{{$key->link_sosmed}}" target="_blank"><i class="fa fa-{{$key->nama_sosmed}}"></i></a></li>
														@endif
													@endforeach
												</ul>
											</div><!--/#widget-->
											<div class="widget weather-widget">
												<div id="weather-widget"></div>
											</div><!--/#widget-->
										</div>
									</div>
								</div>
							</div><!--/#widget-->

							@if(!$getberitaterkait->isEmpty())
									<div class="widget">
										<h1 class="section-title title">Berita Lainnya</h1>
										<ul class="post-list">
											@foreach($getberitaterkait as $key)
												<li>
													<div class="post small-post">
														<div class="entry-header">
															<div class="entry-thumbnail">
																<?php $foto = explode('.', $key->url_foto); ?>
																<img class="img-responsive" src="{{url('images')}}/{{$foto[0]}}_95x95.{{$foto[1]}}" alt="" />
															</div>
														</div>
														<div class="post-content">
															<div class="video-catagory"><a href="#">{{$key->nama_kategori}}</a></div>
															<h2 class="entry-title">
																<a href="{{url('detail-konten/show-berita')}}/{{$key->id_berita}}">
																	<?php $judul = explode(" ", $key->judul_berita); ?>
																	@if(count($judul)<6)
																		{{$key->judul_berita}}
																	@else
																		@for($i=0; $i < 6; $i++)
																			{{$judul[$i]}}
																		@endfor
																		...
																	@endif
																</a>
															</h2>
														</div>
													</div><!--/post-->
												</li>
											@endforeach
										</ul>
									</div><!--/#widget-->
							@endif
						</div><!--/#sitebar-->
					</div>
				</div>
			</div><!--/.section-->
		</div><!--/.container-->

    <script type="text/javascript">
			$(function () {
			    Highcharts.chart('container', {
			        chart: {
			            type: 'column'
			        },
			        title: {
			            text: 'Jumlah Pegawai Pada Pemerintahan Kabupaten Tangerang'
			        },
			        subtitle: {
			            text: 'Esselon dan Non-Esselon'
			        },
			        xAxis: {
			            categories: [
                    @php
  			              foreach ($skpd as $key) {
  			                echo "'".$key."',";
  			              }
  			            @endphp
                  ],
			            crosshair: true
			        },
			        yAxis: {
			            min: 0,
			            title: {
			                text: 'Jumlah Pegawai'
			            }
			        },
			        tooltip: {
			            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			                           '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
			            footerFormat: '</table>',
			            shared: true,
			            useHTML: true
			        },
			        plotOptions: {
			            column: {
			                pointPadding: 0.2,
			                borderWidth: 0
			            }
			        },
			        series: [{
			            name: 'Esselon',
			            data: [
                    @php
                      foreach ($esselon as $key) {
                        echo $key.',';
                      }
                    @endphp
                  ]

			        }, {
			            name: 'Non-Esselon',
			            data: [
                    @php
                      foreach ($nonesselon as $key) {
                        echo $key.',';
                      }
                    @endphp
                  ]
			        }]
			    });
			});
		</script>
	@stop

  @section('script')
	<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
	<script>
	  $(function () {
		$("#table-anggaran").DataTable();
	  });
	</script>
	@stop
