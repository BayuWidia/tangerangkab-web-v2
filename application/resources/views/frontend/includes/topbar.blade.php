<header id="navigation">
			<div class="navbar sticky-nav" role="banner">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="{{ url('/') }}">
							<img class="main-logo img-responsive" src="{{ asset('images/logo-kecil-2.png') }}" alt="logo">
						</a>
					</div>
					<nav id="mainmenu" class="navbar-left collapse navbar-collapse">
						<ul class="nav navbar-nav">
							@if(isset($singkatan))
								<li class="home"><a href="{{url('/')}}/<?php echo strtolower($singkatan); ?>">Beranda</a></li>
								<li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Profile SKPD</a>
			            <ul class="dropdown-menu">
			              @foreach($getsekilastangerang as $key)
			                <li><a href="{{url('/')}}/{{$singkatan}}/profile-skpd/show/{{$key->id}}/{{$key->id_skpd_berita}}">{{ $key->nama_kategori }}</a></li>
			              @endforeach
			            </ul>
			          </li>
							@else
								<li class="home"><a href="{{ url('/') }}">Beranda</a></li>
								<li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Sekilas Tangerang</a>
									<ul class="dropdown-menu">
										@foreach($getsekilastangerang as $key)
											<li><a href="{{url('sekilas-tangerang/show', $key->id)}}">{{ $key->nama_kategori }}</a></li>
										@endforeach
									</ul>
								</li>
							@endif

							@if(isset($singkatan))
								<li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Berita</a>
									<ul class="dropdown-menu">
										@foreach($getberita as $key)
											<li><a href="{{ url('/') }}/{{$singkatan}}/berita-skpd/show/{{$key->id}}">{{ $key->nama_kategori }}</a></li>
										@endforeach
									</ul>
								</li>
							@else
								<li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Berita</a>
									<ul class="dropdown-menu">
										@foreach($getberita as $key)
											<li><a href="{{ url('berita/show', $key->id) }}">{{ $key->nama_kategori }}</a></li>
										@endforeach
									</ul>
								</li>

								<li class="business"><a href="{{ route('frontanggaran.view') }}">Anggaran</a></li>
								<li class="business"><a href="{{route('frontpegawai.view')}}">Kepegawaian</a></li>
							@endif

							{{-- <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Anggaran</a>
								<ul class="dropdown-menu">
									@foreach($getanggaran as $key)
										<li><a href="{{ url('documents') }}/{{$key->url_file}}">{{$key->uraian}} {{$key->tahun}}</a></li>
									@endforeach
								</ul>
							</li> --}}


							{{-- kalo ada singkatan berarti punya skpd, kalo engga ada berarti web utama --}}
							@if(isset($singkatan))
								<li class="business"><a href="{{ route('skpdanggaran.view', $singkatan) }}">Anggaran</a></li>
								<li class="business"><a href="{{route('skpdpegawai.view', $singkatan)}}">Kepegawaian</a></li>

								@foreach($getmenu as $key)
				          <?php $flagsub=0; ?>
				          @foreach($getsubmenu as $check)
				            @if($key->id==$check->parent_menu)
				              <?php $flagsub=1; ?>
				            @endif
				          @endforeach
				          <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">{{$key->nama}}</a>
				            @if($flagsub!=0)
				              <ul class="dropdown-menu">
				                @foreach($getsubmenu as $keys)
				                  @if($keys->parent_menu==$key->id)
				                    <li><a href="{{url('/')}}/{{$singkatan}}/menu-konten-skpd/show-berita/{{$keys->menukontenid}}">{{$keys->nama}}</a></li>
				                  @endif
				                @endforeach
				              </ul>
				            @endif
				          </li>
				        @endforeach
							@else
								@foreach($getmenu as $key)
									<?php $flagsub=0; ?>
									@foreach($getsubmenu as $check)
										@if($key->id==$check->parent_menu)
											<?php $flagsub=1; ?>
										@endif
									@endforeach
									<li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">{{$key->nama}}</a>
										@if($flagsub!=0)
											<ul class="dropdown-menu">
												@foreach($getsubmenu as $keys)
													@if($keys->parent_menu==$key->id)
														<li><a href="{{url('menu-konten/show-berita/')}}/{{$keys->menukontenid}}">{{$keys->nama}}</a></li>
													@endif
												@endforeach
											</ul>
										@endif
									</li>
								@endforeach
							@endif

						</ul>
					</nav>
					<div class="searchNlogin">
						<ul>
							<li class="search-icon"><i class="fa fa-search"></i></li>
						</ul>
						<div class="search">
							<form role="form"
								@if ($singkatan)
									action="{{route('skpdberita.search', $singkatan)}}"
								@else
									action="{{route('berita.search')}}"
								@endif
							method="get">
								<input type="text" class="search-form" autocomplete="off" placeholder="Cari" name="param">
							</form>
						</div> <!--/.search-->
					</div><!-- searchNlogin -->
				</div>
			</div>
		</header>
