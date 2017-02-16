@extends('frontend.layouts.page')

@section('title')
<title><?php echo $getdata->judul_konten;?> | Web Terpadu Kabupaten Tangerang</title>
@stop
	@section('content')
			<div class="container">
			<div class="page-breadcrumbs">
				<h1 class="section-title">{{$getdata->namasubmenu}}</h1>
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

												<div class="post-content">
													<h2 class="entry-title">
														{{ $getdata->judul_konten }}
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
																<li class="publish-date"><i class="fa fa-calendar"></i>{{ \Carbon\Carbon::parse($getdata->konten_update)->format('d-M-y')}}</li>
																<li class="publish-date"><i class="fa fa-clock-o"></i>{{ \Carbon\Carbon::parse($getdata->konten_update)->format('h:ma')}}</li>
																<li class="publish-date"><i class="fa fa-eye"></i>{{$getdata->view_counter}} views</li>
															</ul>
														</div>
													<div class="entry-content">
														<p style="text-align:justify;"><?php echo $getdata->isi_konten?></p>
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

						</div><!--/#sitebar-->
					</div>
				</div>
			</div><!--/.section-->
		</div><!--/.container-->
	@stop
