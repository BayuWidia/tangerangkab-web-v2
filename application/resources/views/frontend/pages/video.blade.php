@extends('frontend.layouts.page')

@section('title')
<title>Galeri Video Kabupaten Tangerang</title>
@stop

@section('content')
	<div class="container">
			<div class="page-breadcrumbs">
				<h1 class="section-title">Galeri Video Kabupaten Tangerang</h1>
			</div>
			<div class="section">
				<div class="row">
					<div class="col-sm-9">
						<div id="site-content" class="site-content">
							<div class="section listing-news">
								@foreach($getdata as $key)
								<div class="post">
										<div class="entry-header">
                      <div class="entry-thumbnail embed-responsive embed-responsive-16by9">
												<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo substr($key->url_video,-11,23)?>" allowfullscreen></iframe>
											</div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<?php $date = explode(' ', $key->created_at) ?>
													<li class="publish-date"><a href="#"><i class="fa fa-calendar"></i>{{ \Carbon\Carbon::parse($key->created_at)->format('d-M-y')}}</a></li>
													<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>{{$date[1]}}</a></li>
												</ul>
											</div>
											<h2 class="entry-title">
													<a href="https://www.youtube.com/embed/<?php echo substr($key->url_video,-11,23)?>" target="_blank">{{$key->judul_video}}</a>
											</h2>
										</div>
								</div><!--/post-->
							@endforeach

							</div>
						</div><!--/#site-content-->


						{{ $getdata->links() }}


					</div><!--/.col-sm-9 -->




					<div class="col-sm-3">
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
						@if(!$getrandom->isEmpty())
								<div class="widget">
									<h1 class="section-title title">Berita Lainnya</h1>
									<ul class="post-list">
										@foreach($getrandom as $key)
											<li>
												<div class="post small-post">
													<div class="entry-header">
														<div class="entry-thumbnail">
															<?php $foto = explode('.', $key->url_foto); ?>
															<img class="img-responsive" src="{{url('images')}}/{{$foto[0]}}_95x95.{{$foto[1]}}" alt="" />
														</div>
													</div>
													<div class="post-content">
														<div class="video-catagory">
															@if (isset($singkatan))
																<a href="{{url('/')}}/{{$singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{$key->nama_kategori}}</a>
															@else
																<a href="{{url('detail-konten/show-berita')}}/{{$key->id_berita}}">{{$key->nama_kategori}}</a>
															@endif
														</div>
														<h2 class="entry-title">
															@if (isset($singkatan))
																<a href="{{url('/')}}/{{$singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">
															@else
																<a href="{{url('detail-konten/show-berita')}}/{{$key->id_berita}}">
															@endif
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
					</div>
				</div>
			</div><!--/.section-->
		</div><!--/.container-->
@stop
