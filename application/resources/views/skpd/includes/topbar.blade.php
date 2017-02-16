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
							<li class="home"><a href="{{url('/')}}/<?php echo strtolower($singkatan); ?>">Beranda</a></li>
							<li class="business dropdown"><a href="javascript:void(0);">Profile SKPD</a>
		            <ul class="dropdown-menu">
		              @foreach($getsekilastangerang as $key)
		                <li><a href="{{url('/')}}/{{$singkatan}}/profile-skpd/show/{{$key->id}}/{{$key->id_skpd_berita}}">{{ $key->nama_kategori }}</a></li>
		              @endforeach
		            </ul>
		          </li>
							<li class="business dropdown"><a href="javascript:void(0);">Berita</a>
								<ul class="dropdown-menu">
									@foreach($getberita as $key)
										<li><a href="{{ url('/') }}/{{$singkatan}}/berita-skpd/show/{{$key->id}}">{{ $key->nama_kategori }}</a></li>
									@endforeach
								</ul>
							</li>

							<li class="business"><a href="{{ route('skpdanggaran.view', $singkatan) }}">Anggaran</a></li>

							<li class="business"><a href="{{route('skpdpegawai.view', $singkatan)}}">Kepegawaian</a></li>

							@foreach($getmenu as $key)
			          <?php $flagsub=0; ?>
			          @foreach($getsubmenu as $check)
			            @if($key->id==$check->parent_menu)
			              <?php $flagsub=1; ?>
			            @endif
			          @endforeach
			          <li class="business dropdown"><a href="javascript:void(0);">{{$key->nama}}</a>
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

						</ul>
					</nav>
					<div class="searchNlogin">
						<ul>
							<li class="search-icon"><i class="fa fa-search"></i></li>
						</ul>
						<div class="search">
							<form role="form">
								<input type="text" class="search-form" autocomplete="off" placeholder="Cari">
							</form>
						</div> <!--/.search-->
					</div><!-- searchNlogin -->
				</div>
			</div>
		</header>
