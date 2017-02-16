@extends('frontend.layouts.page')

@section('title')
  <title>Kepegawaian | Web Terpadu Kabupaten Tangerang</title>
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
                            Berikut adalah seluruh daftar pegawai:
                            <table class="table table-hover" style="margin-top:20px;">
                              <tr>
                                <th style="width:50px;">No.</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Esselon</th>
                                <th>Pangkat</th>
                              </tr>
                              @php
                                $i=1;
                              @endphp
                              @foreach ($getpegawai as $key)
                                <tr>
                                  <td>{{$i}}</td>
                                  <td>
                                    @if ($key->url_foto!=null)
                                      @php
                                        $foto = explode(".", $key->url_foto);
                                      @endphp
                                      <img src="{{url('images')}}/{{$foto[0]}}_115x155.{{$foto[1]}}" alt="Foto Pegawai" />
                                    @else
                                      <img src="{{url('images')}}/user-not-found.png" alt="Foto Pegawai" width="115px" height="155px"/>
                                    @endif
                                  </td>
                                  <td>
                                    {{$key->nama_pegawai}}
                                  </td>
                                  <td>
                                    @if ($key->jenis_kelamin==1)
                                      Pria
                                    @else
                                      Wanita
                                    @endif
                                  </td>
                                  <td>
                                    {{$key->nama_esselon}}
                                  </td>
                                  <td>
                                    {{$key->golongan}} - {{$key->pangkat}}
                                  </td>
                                </tr>
                                @php
                                  $i++;
                                @endphp
                              @endforeach
                            </table>
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
