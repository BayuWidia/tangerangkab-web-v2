@extends('frontend.layouts.page')

@section('title')
	@if ($getdata->judul_berita=="")
		<title>{{$getdata->nama_kategori}} | Web Terpadu Kabupaten Tangerang</title>
	@else
		<title>{{$getdata->judul_berita}} | Web Terpadu Kabupaten Tangerang</title>
	@endif
@stop
	@section('content')
			<div class="container">
			<div class="page-breadcrumbs">
				<h1 class="section-title">{{ $getdata->nama_kategori }}</h1>
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
												@if($getdata->flag_utama=="0")
													<div class="entry-header">
														<div class="entry-thumbnail">
															@if($getdata->foto_berita == null)
																<img class="img-responsive" src="{{ asset('theme/images/post/w1.jpg') }}" alt="" />
															@else
																<?php $foto = explode(".", $getdata->foto_berita) ?>
																<img class="img-responsive" src="{{url('images')}}/{{$foto[0]}}_871x497.{{$foto[1]}}" alt="" />
															@endif
														</div>
													</div>
												@endif
												<div class="post-content">
													<h2 class="entry-title">
														@if($getdata->judul_berita == null)
															{{ $getdata->keterangan_kategori }}
														@else
															{{ $getdata->judul_berita }}
														@endif
													</h2>
														<div class="entry-meta">
															<ul class="list-inline">
																<li class="posted-by"><i class="fa fa-user"></i> posted by <a href="#">
																	@if($getdata->name!="")
																		{{ $getdata->name }}
																	@else
																		{{ $getdata->email }}
																	@endif
																</a></li>
																<li class="publish-date"><i class="fa fa-calendar"></i>{{ \Carbon\Carbon::parse($getdata->updated_at)->format('d-M-y')}}</li>
																<li class="publish-date"><i class="fa fa-clock-o"></i>{{ \Carbon\Carbon::parse($getdata->updated_at)->format('h:ma')}}</li>
																<li class="publish-date"><i class="fa fa-eye"></i>{{$getdata->view_counter}} views</li>
															</ul>
														</div>
													<div class="entry-content">
														<p style="text-align:justify;"><?php echo $getdata->isi_berita?></p>

														<hr>
														<h5>Bagikan artikel ini</h5>
														<!-- Go to www.addthis.com/dashboard to customize your tools -->
														<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58a5140167663aee"></script>
														<div class="addthis_inline_share_toolbox"></div>

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
										<h1 class="section-title title">Berita Terkait</h1>
										<ul class="post-list">
											@foreach($getberitaterkait as $key)
												@if($getdata->id_berita!=$key->id_berita)
													<li>
														<div class="post small-post">
															<div class="entry-header">
																<div class="entry-thumbnail">
																	<?php $foto = explode('.', $key->url_foto); ?>
																	<img class="img-responsive" src="{{url('images')}}/{{$foto[0]}}_95x95.{{$foto[1]}}" alt="" />
																</div>
															</div>
															<div class="post-content">
																<div class="video-catagory"><a href="{{url('detail-konten/show-berita')}}/{{$key->id_berita}}">{{$key->nama_kategori}}</a></div>
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
												@endif
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
