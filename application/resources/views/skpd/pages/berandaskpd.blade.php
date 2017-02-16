@extends('skpd.layouts.master')

@section('title')
	<title>Kabupaten Tangerang</title>
@stop


@section('content')
	<div id="breaking-news">
		<span>
			@if ($singkatan=="englishpage")
				Latest News
			@else
				Berita Terkini
			@endif
		</span>
		<div class="breaking-news-scroll">
			<ul>
				@if(!$getberitaterbaru->isEmpty())
					@foreach($getberitaterbaru as $key)
						<li><i class="fa fa-angle-double-right"></i>
							<a href="{{url('detail-konten/show-berita')}}/{{$key->id}}" title=""><?php echo substr($key->judul_berita,0,120) ?></a>
						</li>
					@endforeach
				@else
					<li><i class="fa fa-angle-double-right"></i>
						<a href="#" title="">--</a>
					</li>
				@endif
			</ul>
		</div>
	</div><!--#breaking-news-->

	<div class="section">
		<div class="row">
			<div class="site-content col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<div id="home-slider">
							@if(!$getslider->isEmpty())
								@foreach($getslider as $key)
									<div class="post feature-post">
										<div class="entry-header">
											<div class="entry-thumbnail">
												<img class="img-responsive" src="{{url('images')}}/{{$key->url_slider}}" alt="" />
											</div>
										</div>
										<div class="post-content">
											<h2 class="entry-title" style="font-size:20pt;">
												<a>{{$key->keterangan_slider}}</a>
											</h2>
										</div>
									</div><!--/post-->
								@endforeach
							@endif
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-sm-3">
						@if(!$getheadline->isEmpty())
							<?php $i=1; ?>
							@foreach($getheadline as $key)
								@if($i==1)
									<div class="post feature-post">
										<div class="entry-header">
											<div class="entry-thumbnail">
												<?php $photo270 = explode(".", $key->url_foto); ?>
												<img class="img-responsive" src="{{url('images')}}/{{$photo270[0]}}_270x225.{{$photo270[1]}}" alt="" />
											</div>
											<div class="catagory"><span><a>{{$key->nama_kategori}}</a></span></div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i><a>
														{{ \Carbon\Carbon::parse($key->created_at)->format('d-M-y')}}
													</a></li>
													<li class="publish-date"><i class="fa fa-clock-o"></i><a>
														{{ \Carbon\Carbon::parse($key->created_at)->format('h:ma')}}
													</a></li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id}}/{{$key->id_skpd}}">{{$key->judul_berita}}</a>
											</h2>
										</div>
									</div><!--/post-->
								@endif
								<?php $i++; ?>
							@endforeach
						@endif
					</div>

					@if(!$getheadline->isEmpty())
						<?php $i=1; ?>
						@foreach($getheadline as $key)
							@if($i!=1 && $i<=4)
								<div class="col-sm-3">
									<div class="post feature-post">
										<div class="entry-header">
											<div class="entry-thumbnail">
												<?php $photo270 = explode(".", $key->url_foto); ?>
												<img class="img-responsive" src="{{url('images')}}/{{$photo270[0]}}_270x225.{{$photo270[1]}}" alt="" />
											</div>
											<div class="catagory"><a>{{$key->nama_kategori}}</a></div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a>
															{{ \Carbon\Carbon::parse($key->created_at)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a>
															{{ \Carbon\Carbon::parse($key->created_at)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id}}/{{$key->id_skpd}}">{{$key->judul_berita}}</a>
											</h2>
										</div>
									</div><!--/post-->
								</div>
							@endif
							<?php $i++; ?>
						@endforeach
					@endif
				</div>
			</div><!--/#content-->
		</div>
	</div><!--/.section-->

	{{-- CEK BERITA TERBARU --}}
	@php
		$flagberitaterbaru=0;
	@endphp
	@foreach ($getberitaterbaru as $key)
		@if ($key->flag_headline!="1")
			@php
				$flagberitaterbaru++;
			@endphp
		@endif
	@endforeach

	@if ($flagberitaterbaru!=0)
		@if(!$getberitaterbaru->isEmpty())
			<div class="section">
				<div class="latest-news-wrapper">
					<h1 class="section-title">
						@if ($singkatan=="englishpage")
							<span>Latest News</span>
						@else
							<span>Berita Terbaru</span>
						@endif
					</h1>
					<div id="latest-news-berita-baru">
							@foreach($getberitaterbaru as $key)
								@if($key->flag_headline!="1")
									<div class="post medium-post">
										<div class="entry-header">
											<div class="entry-thumbnail">
												<img class="img-responsive" src="{{url('images')}}/{{$key->url_foto}}" alt="" />
											</div>
											<div class="catagory"><span><a>{{$key->nama_kategori}}</a></span></div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a>
															{{ \Carbon\Carbon::parse($key->created_at)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a>
															{{ \Carbon\Carbon::parse($key->created_at)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id}}/{{$key->id_skpd}}">{{$key->judul_berita}}</a>
											</h2>
										</div>
									</div><!--/post-->
								@endif
							@endforeach
					</div>
				</div><!--/.latest-news-wrapper-->
			</div><!--/.section-->
		@endif
	@endif

	@if(!$getaplikasi->isEmpty())
		<div class="section">
			<h1 class="section-title">
				<span>
					@if ($singkatan=="englishpage")
						Tangerang Information Systems
					@else
						Sistem Informasi Tangerang Gemilang
					@endif
				</span>
			</h1>
			<div class="latest-news-wrapper">
				<div id="latest-news-aplikasi">
						@foreach($getaplikasi as $key)
							<div class="post medium-post">
								<div class="entry-header">
									<div class="entry-thumbnail">
										<img class="img-responsive" src="{{url('images')}}/{{$key->url_logo}}" alt="" />
									</div>
								</div>
								<div class="post-content" style="padding:5px 15px;">
									<h2 class="entry-title">
										<a href="http://{{$key->domain_aplikasi}}" target="_blank">{{$key->nama_aplikasi}}</a>
									</h2>
								</div>
							</div><!--/post-->
						@endforeach
				</div>
			</div><!--/.latest-news-wrapper-->
		</div><!--/.section-->
	@endif

	<div class="section">
		<div class="latest-news-wrapper">
			<h1 class="section-title">
				<span>
					@if ($singkatan=="englishpage")
						Regional Work Unit Website
					@else
						Link SKPD
					@endif
				</span>
			</h1>
			<div id="latest-news-jejaring" style="padding-top:25px;">
				@foreach (array_chunk($getjejaring->all(), 4) as $jejaringRow)
					<div class="league-result" style="margin-right:10%">
						<ul>
		        @foreach ($jejaringRow as $jejaring)
							<li>
								<div class="row">
									<div>
										<a class="team-name" href="{{url('/')}}/{{$jejaring->singkatan}}" target="_blank">{{$jejaring->nama_skpd}}</a>
									</div>
								</div>
							</li>
		        @endforeach
						</ul>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div class="section">
		<div class="row">
			@if (!$getgaleri->isEmpty())
				<div class="site-content col-md-6">
					<div class="section photo-gallery">
						<h1 class="section-title title">
							@if ($singkatan=="englishpage")
								Photo Gallery
              @else
								Galeri Foto
              @endif
						</h1>
						<div id="photo-gallery" class="carousel slide carousel-fade post" data-ride="carousel">
							<div class="carousel-inner">
								<?php $x=1; ?>
								@foreach($getgaleri as $key)
									@if($x==1)
										<div class="item active">
											<a><img class="img-responsive" src="{{url('images')}}/{{$key->url_gambar}}" alt="" /></a>
											<h2><a>{{$key->keterangan_gambar}}</a></h2>
										</div>
									@else
										<div class="item">
											<a><img class="img-responsive" src="{{url('images')}}/{{$key->url_gambar}}" alt="" /></a>
											<h2><a>{{$key->keterangan_gambar}}</a></h2>
										</div>
									@endif
									<?php $x++; ?>
								@endforeach

							</div><!--/carousel-inner-->

							<ol class="gallery-indicators carousel-indicators">
								<?php $x=0; ?>
								@foreach($getgaleri as $key)
									<li data-target="#photo-gallery" data-slide-to="{{$x}}" class="active">
										<?php $gambar = explode(".", $key->url_gambar) ?>
										<img class="img-responsive" src="{{url('images')}}/{{$gambar[0]}}_40x40.{{$gambar[1]}}" alt="" />
									</li>
									<?php $x++; ?>
								@endforeach
							</ol><!--/gallery-indicators-->

							<div class="gallery-turner">
								<a class="left-photo" href="#photo-gallery" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
								<a class="right-photo" href="#photo-gallery" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
							</div>
						</div>
					</div><!--/photo-gallery-->
				</div>
			@endif

			@if (!$getvideo->isEmpty())
				<div class="site-content col-md-6">
					<div class="section">
						<h1 class="section-title" style="margin-bottom:50px;"><span>Video</span></h1>
						<div class="latest-news-wrapper">
							<div style="width:94%;">
								<div class="section photo-gallery" style="margin-top:-1%">
									<?php $i=1; ?>
									@foreach($getvideo as $key)
										@if($i==1)
											<div class="post" style="border-bottom:0px;">
												<div class="entry-header">
													<div class="entry-thumbnail embed-responsive embed-responsive-16by9">
														<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo substr($key->url_video,-11,23)?>" allowfullscreen></iframe>
													</div>
												</div>
												<div class="post-content" style="padding:20px 15px 10px 15px;">
													<div class="video-catagory">
														<h2 class="entry-title">
															<a>{{$key->judul_video}}</a>
														</h2>
													</div>
												</div>
											</div><!--/post-->
										@endif
										<?php $i++; ?>
									@endforeach
									<div class="list-post" style="padding-bottom:5px;padding-top:5px;background:#fff;">
										<ul>
											<?php $i=1; ?>
											@foreach($getvideo as $key)
												@if($i>1 && $i<=3)
													<li><a href="{{$key->url_video}}" style="padding:10px 15px;" target="_blank">{{$key->judul_video}}<i class="fa fa-angle-right"></i></a></li>
												@endif
												<?php $i++; ?>
											@endforeach
											{{-- <li><a href="#" style="padding:10px 15px;">Baaa <i class="fa fa-angle-right"></i></a></li> --}}
										</ul>
										<ul>
											<li style="padding:10px 15px; text-align:center;">
													<span class="badge">
														<a href="{{route('skpdvideo.view', $singkatan)}}" style="padding:0px; color:white;">
															Lihat Semua Video
														</a>
													</span>
											</li>
										</ul>
									</div><!--/list-post-->
								</div> <!-- /.video-section -->
							</div>
						</div><!--/.section-->
					</div>
				</div>
			@endif

		<div class="col-md-12 col-sm-8">
			<div id="site-content">
				<div class="row">
					<div class="col-md-9 col-sm-6">
						<div class="left-content">
							@if(count($getberitabykategori)>=1)
								<div class="section world-news">
									<h1 class="section-title title">{{$getberitabykategori[0][0]->nama_kategori}}</h1>
									<div class="cat-menu">
										<ul class="list-inline">
											<li><a href="{{url('/')}}/{{$getberitabykategori[0][0]->singkatan}}/berita-skpd/show/{{$getberitabykategori[0][0]->id_kategori}}">
												@if ($singkatan=="englishpage")
													Read More
												@else
													Lihat Semua
												@endif
											</a></li>
										</ul>
									</div>
									<div class="post">
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[0][0]->tanggal_posting)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[0][0]->tanggal_posting)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$getberitabykategori[0][0]->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$getberitabykategori[0][0]->id_berita}}/{{$key->id_skpd}}">
													{{$getberitabykategori[0][0]->judul_berita}}
												</a>
											</h2>
											<div class="entry-content">
												<?php $konten = explode(" ", strip_tags($getberitabykategori[0][0]->isi_berita)) ?>
												@if(count($konten)<40)
													<?php echo $getberitabykategori[0][0]->isi_berita?>
												@else
													@for($i=0; $i < 40; $i++)
														{{$konten[$i]}}
													@endfor
													...
												@endif
											</div>
										</div>
										<div class="list-post">
											<ul>
												<?php $i=1; ?>
												@foreach($getberitabykategori[0] as $key)
													@if($i!=1 && $i<=4)
														<li><a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{$key->judul_berita}} <i class="fa fa-angle-right"></i></a></li>
													@endif
													<?php $i++; ?>
												@endforeach
											</ul>
										</div><!--/list-post-->
									</div><!--/post-->
								</div><!--/.section-->
							@endif
						</div><!--/.left-content-->

						<div class="left-content">
							@if(count($getberitabykategori)>=2)
								<div class="section world-news">
									<h1 class="section-title title">{{$getberitabykategori[1][0]->nama_kategori}}</h1>
									<div class="cat-menu">
										<ul class="list-inline">
											<li><a href="{{url('/')}}/{{$getberitabykategori[1][0]->singkatan}}/berita-skpd/show/{{$getberitabykategori[1][0]->id_kategori}}">
												@if ($singkatan=="englishpage")
													Read More
												@else
													Lihat Semua
												@endif
											</a></li>
										</ul>
									</div>
									<div class="post">
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[1][0]->tanggal_posting)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[1][0]->tanggal_posting)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>

											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$getberitabykategori[1][0]->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$getberitabykategori[1][0]->id_berita}}/{{$key->id_skpd}}">
													{{$getberitabykategori[1][0]->judul_berita}}
												</a>
											</h2>
											<div class="entry-content">
												<?php $konten = explode(" ", strip_tags($getberitabykategori[1][0]->isi_berita)) ?>
												@if(count($konten)<40)
													<?php echo $getberitabykategori[1][0]->isi_berita?>
												@else
													@for($i=0; $i < 40; $i++)
														{{$konten[$i]}}
													@endfor
													...
												@endif
											</div>
										</div>
										<div class="list-post">
											<ul>
												<?php $i=1; ?>
												@foreach($getberitabykategori[1] as $key)
													@if($i!=1 && $i<=4)
														<li><a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{$key->judul_berita}} <i class="fa fa-angle-right"></i></a></li>
													@endif
													<?php $i++; ?>
												@endforeach
											</ul>
										</div><!--/list-post-->
									</div><!--/post-->
								</div><!--/.section-->
							@endif
						</div><!--/.left-content-->

						<div class="left-content">
							@if(count($getberitabykategori)>=3)
								<div class="section world-news">
									<h1 class="section-title title">{{$getberitabykategori[2][0]->nama_kategori}}</h1>
									<div class="cat-menu">
										<ul class="list-inline">
											<li><a href="{{url('/')}}/{{$getberitabykategori[2][0]->singkatan}}/berita-skpd/show/{{$getberitabykategori[2][0]->id_kategori}}">
												@if ($singkatan=="englishpage")
													Read More
												@else
													Lihat Semua
												@endif
											</a></li>
										</ul>
									</div>
									<div class="post">
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[2][0]->tanggal_posting)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[2][0]->tanggal_posting)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$getberitabykategori[2][0]->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$getberitabykategori[2][0]->id_berita}}/{{$key->id_skpd}}">
													{{$getberitabykategori[2][0]->judul_berita}}
												</a>
											</h2>
											<div class="entry-content">
												<?php $konten = explode(" ", strip_tags($getberitabykategori[2][0]->isi_berita)) ?>
												@if(count($konten)<40)
													<?php echo $getberitabykategori[2][0]->isi_berita; ?>
												@else
													@for($i=0; $i < 40; $i++)
														{{$konten[$i]}}
													@endfor
													...
												@endif
											</div>
										</div>
										<div class="list-post">
											<ul>
												<?php $i=1; ?>
												@foreach($getberitabykategori[2] as $key)
													@if($i!=1 && $i<=4)
														<li><a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{$key->judul_berita}} <i class="fa fa-angle-right"></i></a></li>
													@endif
													<?php $i++; ?>
												@endforeach
											</ul>
										</div><!--/list-post-->
									</div><!--/post-->
								</div><!--/.section-->
							@endif
						</div><!--/.left-content-->

						<div class="left-content">
							@if(count($getberitabykategori)>=4)
								<div class="section world-news">
									<h1 class="section-title title">{{$getberitabykategori[3][0]->nama_kategori}}</h1>
									<div class="cat-menu">
										<ul class="list-inline">
											<li><a href="{{url('/')}}/{{$getberitabykategori[3][0]->singkatan}}/berita-skpd/show/{{$getberitabykategori[3][0]->id_kategori}}">
												@if ($singkatan=="englishpage")
													Read More
												@else
													Lihat Semua
												@endif
											</a></li>
										</ul>
									</div>
									<div class="post">
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="publish-date"><i class="fa fa-calendar"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[3][0]->tanggal_posting)->format('d-M-y')}}
														</a>
													</li>
													<li class="publish-date"><i class="fa fa-clock-o"></i>
														<a href="#">
															{{ \Carbon\Carbon::parse($getberitabykategori[3][0]->tanggal_posting)->format('h:ma')}}
														</a>
													</li>
												</ul>
											</div>
											<h2 class="entry-title">
												<a href="{{url('/')}}/{{$getberitabykategori[3][0]->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$getberitabykategori[3][0]->id_berita}}/{{$key->id_skpd}}">
													{{$getberitabykategori[3][0]->judul_berita}}
												</a>
											</h2>
											<div class="entry-content">
												<?php $konten = explode(" ", strip_tags($getberitabykategori[3][0]->isi_berita)) ?>
												@if(count($konten)<40)
													<?php echo $getberitabykategori[3][0]->isi_berita; ?>
												@else
													@for($i=0; $i < 40; $i++)
														{{$konten[$i]}}
													@endfor
													...
												@endif
											</div>
										</div>
										<div class="list-post">
											<ul>
												<?php $i=1; ?>
												@foreach($getberitabykategori[3] as $key)
													@if($i!=1 && $i<=4)
														<li><a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id_berita}}/{{$key->id_skpd}}">{{$key->judul_berita}} <i class="fa fa-angle-right"></i></a></li>
													@endif
													<?php $i++; ?>
												@endforeach
											</ul>
										</div><!--/list-post-->
									</div><!--/post-->
								</div><!--/.section-->
							@endif
						</div><!--/.left-content-->
					</div>

					<div class="col-md-3 col-sm-6">
						<div id="sitebar">
							<div class="section sports-section widget">
								<h1 class="section-title title">
									@if ($singkatan=="englishpage")
										SKPD News
		              @else
										Berita SKPD
		              @endif
								</h1>
								<div class="cat-menu">
									<ul class="list-inline">
										<li><a href="{{url('/')}}/{{$singkatan}}/berita-skpd/show">
											@if ($singkatan=="englishpage")
												Read More
				              @else
												Lihat Semua
				              @endif
										</a></li>
									</ul>
								</div>
								<ul class="post-list">
									@if(!$getberitaskpd->isEmpty())
										@foreach($getberitaskpd as $key)
											<li>
												<div class="post small-post">
													<div class="entry-header">
														<div class="entry-thumbnail">
															@if($key->url_foto!="")
																<?php $photo95 = explode(".", $key->url_foto); ?>
																<img class="img-responsive" src="{{url('images')}}/{{$photo95[0]}}_95x95.{{$photo95[1]}}" />
															@endif
														</div>
													</div>
													<div class="post-content">
														<div class="video-catagory"><a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id}}/{{$key->id_skpd}}">@php
															echo strtoupper($key->singkatan);
														@endphp</a></div>
														<h2 class="entry-title">
															<a href="{{url('/')}}/{{$key->singkatan}}/detail-konten-skpd/show-berita-skpd/{{$key->id}}/{{$key->id_skpd}}">
																<?php $konten = explode(" ", strip_tags($key->judul_berita)) ?>
																@if(count($konten)<=4)
																	<?php echo $key->judul_berita; ?>
																@else
																	@for($i=0; $i < 4; $i++)
																		{{$konten[$i]}}
																	@endfor
																	...
																@endif
															</a>
														</h2>
													</div>
												</div><!--/post-->
											</li>
										@endforeach
									@else
										<li>
											<div class="post small-post">
												<div class="entry-header">
													<div class="entry-thumbnail">
														<img class="img-responsive" src="theme/images/post/rising/1.jpg" alt="" />
													</div>
												</div>
												<div class="post-content">
													<div class="video-catagory"><a href="#">--</a></div>
													<h2 class="entry-title">
														<a href="#">--</a>
													</h2>
												</div>
											</div><!--/post-->
										</li>
									@endif
								</ul>
							</div><!--/#widget-->

							<div class="widget meta-widget">
								<div class="meta-tab">
									<div class="tab-content">
										<div class="add featured-add">
											<div class="widget follow-us">
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

						</div><!--/#sitebar-->
					</div>
				</div>
			</div><!--/#site-content-->
		</div>

	</div>

@stop
