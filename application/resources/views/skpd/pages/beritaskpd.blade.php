@extends('skpd.layouts.page')

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
												<a href="{{url('detail-konten-skpd/show-berita-skpd')}}/{{$key->id_berita}}&id_skpd={{$key->id_skpd}}">{{ $key->judul_berita }}</a>
											</h2>
											<div class="entry-content">
												<a href="{{url('detail-konten-skpd/show-berita-skpd')}}/{{$key->id_berita}}&id_skpd={{$key->id_skpd}}">
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

						<div class="pagination-wrapper">
							<ul class="pagination">
								<li><a href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous Page</span></a></li>
								<li><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li class="active"><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li><a href="#">6</a></li>
								<li><a href="#" aria-label="Next"><span aria-hidden="true">Next Page <i class="fa fa-long-arrow-right"></i></span></a></li>
							</ul>
						</div>
					</div><!--/.col-sm-9 -->

					<div class="col-sm-3">
						<div id="sitebar">
							<div class="widget follow-us">
								<h1 class="section-title title">Follow Us</h1>
								<ul class="list-inline social-icons">
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#"><i class="fa fa-youtube"></i></a></li>
								</ul>
							</div><!--/#widget-->
						</div><!--/#sitebar-->

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
														<div class="video-catagory"><a href="#">{{$key->nama_kategori}}</a></div>
														<h2 class="entry-title">
															<a href="{{url('detail-konten-skpd/show-berita-skpd')}}/{{$key->id_berita}}&id_skpd={{$key->id_skpd}}">
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
