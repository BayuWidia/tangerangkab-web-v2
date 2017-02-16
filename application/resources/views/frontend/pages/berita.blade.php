@extends('frontend.layouts.page')

@section('title')
<title>Berita Kabupaten Tangerang</title>
@stop

@section('content')
	<div class="container">
			<div class="page-breadcrumbs">
				@if(isset($beritaskpd))
					<h1 class="section-title">Berita SKPD</h1>
				@else
					@foreach($getdata as $key)
						<h1 class="section-title">{{ $key->nama_kategori }}</h1>
						@break;
					@endforeach
				@endif
			</div>
			<div class="section">
				<div class="row">
					<div class="col-sm-9">
						<div id="site-content" class="site-content">
							<div class="section listing-news">
								@foreach($getdata as $key)
								<div class="post">
										<div class="entry-header">
											<div class="entry-thumbnail">
												@if($key->foto_berita == null)
													<img class="img-responsive" src="{{ asset('theme/images/post/life1.jpg') }}" alt="" />
												@else
													<img class="img-responsive" src="{{ asset('/images/'.$key->foto_berita) }}" alt="" />
												@endif
											</div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<?php $date = explode(' ', $key->tanggal_posting) ?>
													<li class="publish-date"><a href="#"><i class="fa fa-calendar"></i>{{ \Carbon\Carbon::parse($key->tanggal_posting)->format('d-M-y')}}</a></li>
													<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>{{$date[1]}}</a></li>
												</ul>
											</div>
											<h2 class="entry-title">
												@if (isset($singkatan))
													<a href="{{url('/')}}/{{$singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{ $key->judul_berita }}</a>
												@else
													<a href="{{url('detail-konten/show-berita')}}/{{$key->id_berita}}">{{$key->judul_berita}}</a>
												@endif
											</h2>
											<div class="entry-content">
												@if (isset($singkatan))
													<a href="{{url('/')}}/{{$singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">
												@else
													<a href="{{ url('detail-konten/show-berita', $key->id_berita) }}">
												@endif
													<?php $konten = explode(' ', strip_tags($key->isi_berita)); ?>
													@if(count($konten)<20)
														<?php echo $key->isi_berita?>
													@else
														@for($i=0; $i < 20; $i++)
															{{$konten[$i]}}
														@endfor
														...
													@endif
												</a></p>
											</div>
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
