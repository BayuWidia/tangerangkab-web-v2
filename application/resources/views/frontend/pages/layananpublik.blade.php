@extends('frontend.layouts.page')

@section('title')
<title>Layanan Publik Kabupaten Tangerang</title>
@stop
@section('content')
	<div class="page-breadcrumbs">
		<h1 class="section-title">Layanan Publik</h1>
	</div>
	<div class="section">
		<div class="row">
			<div class="col-sm-9">
				<div id="site-content" class="site-content">
					<div class="lifestyle-news">
						<div class="post">
							<div class="entry-header">
								<div class="entry-thumbnail">
									<img class="img-responsive" src="{{ asset('theme/images/post/w3.jpg')}}" alt="" />
								</div>
							</div>
							<div class="post-content">
								<div class="entry-meta">
									<ul class="list-inline">
										<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
										<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
										<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
										<li class="comments"><i class="fa fa-comment-o"></i><a href="#">189</a></li>
									</ul>
								</div>
								<h2 class="entry-title">
									<a href="{{ url('layanan-publik/detail') }}">We Are Seeing The Effects Of The Minimum Wage Rise In San Francisco</a>
								</h2>
								<div class="entry-content">
									<p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled it to make a type specimen book dummy text ever since ......</p>
								</div>
							</div>
						</div><!--/post-->
					</div><!--/.section-->
					<div class="section listing-news">
						<div class="post">
							<div class="entry-header">
								<div class="entry-thumbnail">
									<img class="img-responsive" src="{{ asset('theme/images/post/life1.jpg') }}" alt="" />
								</div>
							</div>
							<div class="post-content">
								<div class="entry-meta">
									<ul class="list-inline">
										<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
										<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
										<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
									</ul>
								</div>
								<h2 class="entry-title">
									<a href="news-details.html">'Final Fantasy' star Lightning will be the new face of Louis Vuitton next year</a>
								</h2>
								<div class="entry-content">
									<p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled.</p>
								</div>
							</div>
						</div><!--/post-->
						<div class="post">
							<div class="entry-header">
								<div class="entry-thumbnail">
									<img class="img-responsive" src="{{ asset('theme/images/post/life2.jpg') }}" alt="" />
								</div>
							</div>
							<div class="post-content">
								<div class="entry-meta">
									<ul class="list-inline">
										<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
										<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
										<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
									</ul>
								</div>
								<h2 class="entry-title">
									<a href="news-details.html">Wearable tech made strides in 2015, but it still has a long way to go</a>
								</h2>
								<div class="entry-content">
									<p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled.</p>
								</div>
							</div>
						</div><!--/post-->

						<div class="post">
							<div class="entry-header">
								<div class="entry-thumbnail">
									<img class="img-responsive" src="{{ asset('theme/images/post/life3.jpg') }}" alt="" />
								</div>
							</div>
							<div class="post-content">
								<div class="entry-meta">
									<ul class="list-inline">
										<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
										<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
										<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
									</ul>
								</div>
								<h2 class="entry-title">
									<a href="news-details.html">Wet wedding: Yorkshire couple dons wellies to tie the knot in flooded town</a>
								</h2>
								<div class="entry-content">
									<p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled.</p>
								</div>
							</div>
						</div><!--/post-->

						<div class="post">
							<div class="entry-header">
								<div class="entry-thumbnail">
									<img class="img-responsive" src="{{ asset('theme/images/post/life4.jpg') }}" alt="" />
								</div>
							</div>
							<div class="post-content">
								<div class="entry-meta">
									<ul class="list-inline">
										<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
										<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
										<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
									</ul>
								</div>
								<h2 class="entry-title">
									<a href="news-details.html">We Are Seeing The Effects Of The Minimum Wage Rise In San Francisco</a>
								</h2>
								<div class="entry-content">
									<p>Text of the printing and typesetting industry orem Ipsum has been the industry standard dummy text ever since the when an unknown printer took a galley of type and scrambled.</p>
								</div>
							</div>
						</div><!--/post-->

					</div>
				</div><!--/#site-content-->

				<div class="pagination-wrapper">
					<ul class="pagination">
						<li><a href="#" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous Page</span></a></li>
						<li class="active"><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#" aria-label="Next"><span aria-hidden="true">Next Page <i class="fa fa-long-arrow-right"></i></span></a></li>
					</ul>
				</div>
			</div><!--/.col-sm-9 -->

			<div class="col-md-3 col-sm-6">
				<div id="sitebar">
					<div class="widget">
						<h1 class="section-title title">Site Links</h1>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
						</br>
						<div class="featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/t1.jpg') }}" alt="" /></a>
						</div>
					</div>
					<div class="widget">
						<div class="section video-section">
							<h1 class="section-title title">Watch Video</h1>
							<div class="cat-menu">
								<a href="listing.html">See all</a>
							</div>
							<div class="post video-post medium-post">
								<div class="entry-header">
									<div class="entry-thumbnail embed-responsive embed-responsive-16by9">
										<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-WlqrkXImsk" allowfullscreen></iframe>
									</div>
								</div>
								<div class="post-content">
									<div class="video-catagory"><a href="#">World</a></div>
									<h2 class="entry-title">
										<a href="news-details.html">Our closest relatives aren't fans of daylight saving time</a>
									</h2>
								</div>
							</div><!--/post-->

							<div class="video-post-list">
								<ul>
									<li>
										<div class="post video-post small-post">
											<div class="entry-header">
												<div class="entry-thumbnail embed-responsive embed-responsive-16by9">
													<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-WlqrkXImsk" allowfullscreen></iframe>
												</div>
											</div>
											<div class="post-content">
												<div class="video-catagory"><a href="#">World</a></div>
												<h2 class="entry-title">
													<a href="news-details.html">Our closest relatives aren't fans of daylight saving time</a>
												</h2>
											</div>
										</div><!--/post-->
									</li>
									<li>
										<div class="post video-post small-post">
											<div class="entry-header">
												<div class="entry-thumbnail embed-responsive embed-responsive-16by9">
													<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-WlqrkXImsk" allowfullscreen></iframe>
												</div>
											</div>
											<div class="post-content">
												<div class="video-catagory"><a href="#">Business</a></div>
												<h2 class="entry-title">
													<a href="news-details.html">3 students arrested after body-slamming principal</a>
												</h2>
											</div>
										</div><!--/post-->
									</li>
									<li>
										<div class="post video-post small-post">
											<div class="entry-header">
												<div class="entry-thumbnail embed-responsive embed-responsive-16by9">
													<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-WlqrkXImsk" allowfullscreen></iframe>
												</div>
											</div>
											<div class="post-content">
												<div class="video-catagory"><a href="#">World</a></div>
												<h2 class="entry-title">
													<a href="news-details.html">Our closest relatives aren't fans of daylight saving time</a>
												</h2>
											</div>
										</div><!--/post-->
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
