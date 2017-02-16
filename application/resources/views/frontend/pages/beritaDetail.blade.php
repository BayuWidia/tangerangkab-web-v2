@extends('frontend.layouts.page')

@section('title')
<title>Berita Kabupaten Tangerang</title>
@stop
@section('content')
  <div class="page-breadcrumbs">
		<h1 class="section-title">Berita</h1>
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
												<img class="img-responsive" src="{{ asset('theme/images/post/w1.jpg') }}" alt="" />
											</div>
										</div>
										<div class="post-content">
											<div class="entry-meta">
												<ul class="list-inline">
													<li class="posted-by"><i class="fa fa-user"></i> by <a href="#">Owen Williams</a></li>
													<li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i> Nov 15, 2015 </a></li>
													<li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
													<li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a></li>
													<li class="comments"><i class="fa fa-comment-o"></i><a href="#">189</a></li>
												</ul>
											</div>
											<h2 class="entry-title">
												We Are Seeing The Effects Of The Minimum Wage Rise In San Francisco
											</h2>
											<div class="entry-content">
												<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p><br>
												<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.</p>

												<div class="row post-inner-image">
													<div class="col-sm-4">
														<img class="img-responsive" src="{{ asset('theme/images/post/inner1.jpg') }}" alt="" />
													</div>
													<div class="col-sm-4">
														<img class="img-responsive" src="{{ asset('theme/images/post/inner2.jpg') }}" alt="" />
													</div>
													<div class="col-sm-4">
														<img class="img-responsive" src="{{ asset('theme/images/post/inner3.jpg') }}" alt="" />
													</div>
												</div><!-- post-inner-image -->

												<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
												<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

												<ul class="list-inline share-link">
													<li><a href="#"><img src="{{ asset('theme/images/others/s1.png') }}" alt="" /></a></li>
													<li><a href="#"><img src="{{ asset('theme/images/others/s2.png') }}" alt="" /></a></li>
													<li><a href="#"><img src="{{ asset('theme/images/others/s3.png') }}" alt="" /></a></li>
													<li><a href="#"><img src="{{ asset('theme/images/others/s4.png') }}" alt="" /></a></li>
												</ul>
											</div>
										</div>
									</div><!--/post-->
								</div><!--/.section-->
							</div><!--/.left-content-->
						</div>
					</div>
				</div><!--/#site-content-->

				<div class="row">
					<div class="col-sm-12">
						<div class="comments-wrapper">
							<h1 class="section-title title">Comments</h1>
							<ul class="media-list">
								<li class="media">
									<div class="media-left">
										<a href="#"><img class="media-object" src="{{ asset('theme/images/others/author2.png') }}" alt=""></a>
									</div>
									<div class="media-body">
										<h2><a href="#">Axel Bouaziz</a></h2>
										<h3 class="date"><a href="#">15 December 2015</a></h3>
										<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
										<a class="replay" href="#">Replay</a>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#"><img class="media-object" src="{{ asset('theme/images/others/author.png') }}" alt=""></a>
									</div>
									<div class="media-body">
										<h2><a href="#">Axel Bouaziz</a></h2>
										 <h3 class="date"><a href="#">15 December 2015</a></h3>
										<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
										<a class="replay" href="#">Replay</a>
									</div>
								</li>

								<li class="media">
									<div class="media-left">
										<a href="#"><img class="media-object" src="{{ asset('theme/images/others/author1.png') }}" alt=""></a>
									</div>
									<div class="media-body">
										<h2><a href="#">Axel Bouaziz</a></h2>
										 <h3 class="date"><a href="#">15 December 2015</a></h3>
										<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. </p>
										<a class="replay" href="#">Replay</a>
									</div>
								</li>

								<div class="media media-child">
									<div class="media-left">
										<a href="#"><img class="media-object" src="{{ asset('theme/images/others/author3.png') }}" alt=""></a>
									</div>
									<div class="media-body">
										<h2><a href="#">Axel Bouaziz</a></h2>
										 <h3 class="date"><a href="#">15 December 2015</a></h3>
										<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.</p>
										<a class="replay" href="#">Replay</a>
									</div>
								</div>
							</ul>

							<div class="comments-box">
								<h1 class="section-title title">Leave a Comment</h1>
								<form id="comment-form" name="comment-form" method="post">
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<label for="name">Name</label>
												<input type="text" name="name" class="form-control" required="required">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="email">Email</label>
												<input type="email" name="email" class="form-control" required="required">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<label for="subject">Subject</label>
												<input type="subject" name="subject" class="form-control">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label for="comment" >Your Text</label>
												<textarea name="comment" id="comment" required="required" class="form-control" rows="5"></textarea>
											</div>
											<div class="text-center">
												<button type="submit" class="btn btn-primary">Send </button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.col-sm-9 -->

			<div class="col-sm-3">
				<div id="sitebar">
					{{-- <div class="widget">
						<div class="add featured-add">
							<a href="#"><img class="img-responsive" src="{{ asset('') }}theme/images/post/add/add1.jpg" alt="" /></a>
						</div>
					</div><!--/#widget--> --}}
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

					<div class="widget">
						<h1 class="section-title title">This is Rising!</h1>
						<ul class="post-list">
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/1.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">World</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/2.jpg') }}" alt="" />
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
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/3.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Sports</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/4.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Technology</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/5.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Politics</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/6.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Health</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/7.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Lifestyle</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/rising/8.jpg') }}" alt="" />
										</div>
									</div>
									<div class="post-content">
										<div class="video-catagory"><a href="#">Entertainment</a></div>
										<h2 class="entry-title">
											<a href="news-details.html">3 students arrested after body-slamming principal</a>
										</h2>
									</div>
								</div><!--/post-->
							</li>
							<li>
								<div class="post small-post">
									<div class="entry-header">
										<div class="entry-thumbnail">
											<img class="img-responsive" src="{{ asset('theme/images/post/7.jpg') }}" alt="" />
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

						</ul>
					</div><!--/#widget-->
				</div><!--/#sitebar-->
			</div>
		</div>
	</div>
@stop
