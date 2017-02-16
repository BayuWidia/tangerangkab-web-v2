@extends('frontend.layouts.page')

@section('title')
<title>Sejarah Kabupaten Tangerang</title>
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
															@if($getdata->url_foto == null)
																<img class="img-responsive" src="{{ asset('theme/images/post/w1.jpg') }}" alt="" />
															@else
																<?php $foto = explode(".", $getdata->url_foto) ?>
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
																<li class="posted-by"><i class="fa fa-user"></i> by <a href="#">{{ $getdata->name }}</a></li>
																<li class="publish-date"><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($getdata->tanggal_publish)->format('d-M-y')}}</li>
																<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
																<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
																<li class="comments"><i class="fa fa-comment-o"></i><a href="#">189</a></li>
															</ul>
														</div>
													<div class="entry-content">
														<p style="text-align:justify;"><?php echo $getdata->isi_berita?></p>
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
							<div class="widget">
								<div class="add featured-add">
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
