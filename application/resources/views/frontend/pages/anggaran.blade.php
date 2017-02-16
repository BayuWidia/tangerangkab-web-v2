@extends('frontend.layouts.page')

@section('title')
  <title>Anggaran | Web Terpadu Kabupaten Tangerang</title>
  <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
@stop
	@section('content')
			<div class="container">
			<div class="page-breadcrumbs">
				<h1 class="section-title">Anggaran</h1>
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
													  Daftar Anggaran
													</h2>
													<div class="entry-content">
                            Berikut adalah seluruh daftar anggaran yang telah di upload. Silahkan klik tombol <span class="badge">
                              Download
                            </span> untuk mengunduh file anggaran.
                            @if (count($getanggaran)!=0)
                              <br><br>
                              <table id="table-anggaran" class="table table-bordered" style="margin-top:20px;">
                							<thead>
                                              <tr>
                                                <th style="width:50px;">No.</th>
                                                <th>Nama</th>
                                                <th>Tahun</th>
                                                <th>SKPD</th>
                                                <th>Download Dokumen</th>
                                              </tr>
                							</thead>
                							<tbody>
                                  @php
                                    $i=1;
                                  @endphp
                                  @foreach ($getanggaran as $key)
                                    <tr>
                                      <td>{{ $i }}</td>
                                      <td>{{ $key->uraian }}</td>
                                      <td>{{ $key->tahun }}</td>
                                      <td>
                                        @if ($key->id_skpd==null)
                                          KABUPATEN
                                        @else
                                          @php
                                            echo strtoupper($key->singkatan);
                                          @endphp
                                        @endif
                                      </td>
                                      <td>
                                        <a href="{{url('documents')}}/{{ $key->url_file }}">
                                          <span class="badge">
                                            Download
                                          </span>
                                        </a>
                                      </td>
                                    </tr>
                                    @php
                                    $i++;
                                    @endphp
                                  @endforeach
                                </tbody>
                              </table>
                              @else
                                <br>
                                <br>
                                    Data tidak tersedia.

                              @endif
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
