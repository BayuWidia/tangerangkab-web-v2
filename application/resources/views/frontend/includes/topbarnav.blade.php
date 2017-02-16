    <div class="topbar">
      <div class="container">
        <div id="date-time"></div>

        {{-- english page --}}
        &nbsp;
        <a href="{{url('/')}}/englishpage">
          <img src="{{asset('/images/1487230468_Flag_of_United_Kingdom.png')}}" style="width:24px;" title="English Language"/>
        </a>
        {{-- english page --}}

        <div id="topbar-right">
          {{-- google translate --}}
          <div id="google_translate_element" style="float:left;"></div>
          <script type="text/javascript">
            function googleTranslateElementInit() {
              new google.translate.TranslateElement({pageLanguage: 'id'}, 'google_translate_element');
            }
          </script>
          <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
          {{-- google translate --}}

          <div id="weather"></div>
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
    </div>
    <div id="navigation">
      <div class="navbar" role="banner">
        <div class="container">
          <div class="top-add">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

              <a class="navbar-brand" href="{{ url('/') }}">
                <img class="main-logo img-responsive" id="logocustom" src="{{ asset('images/logo-gede.png') }}" alt="logo">
              </a>
            </div>
            {{-- <div class="navbar-right">
              <a href="#"><img class="img-responsive" src="{{ asset('theme/images/post/google-add.jpg') }}" alt="" /></a>
            </div> --}}
          </div>
        </div>
        <div id="menubar">
          <div class="container">
              <nav id="mainmenu" class="navbar-left collapse navbar-collapse">
                <ul class="nav navbar-nav">
                  <li class="home"><a href="{{ url('/') }}">Beranda</a></li>
                  <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Sekilas Tangerang</a>
                    <ul class="dropdown-menu">
                      @foreach($getsekilastangerang as $key)
                        <li><a href="{{url('sekilas-tangerang/show', $key->id)}}">{{ $key->nama_kategori }}</a></li>
                      @endforeach
                    </ul>
                  </li>
                  <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Berita</a>
                    <ul class="dropdown-menu">
                      @foreach($getberita as $key)
                        <li><a href="{{ url('berita/show', $key->id) }}">{{ $key->nama_kategori }}</a></li>
                      @endforeach
                    </ul>
                  </li>

                  {{-- <li class="business dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">Anggaran</a>
                    <ul class="dropdown-menu">
                      @foreach($getanggaran as $key)
                        <li><a href="{{ url('documents') }}/{{$key->url_file}}">{{$key->uraian}} {{$key->tahun}}</a></li>
                      @endforeach
                    </ul>
                  </li> --}}

                  <li class="business"><a href="{{ route('frontanggaran.view') }}">Anggaran</a></li>
                  <li class="business"><a href="{{route('frontpegawai.view')}}">Kepegawaian</a></li>

                @foreach($getmenu as $key)
                  <?php $flagsub=0; ?>
                  @foreach($getsubmenu as $check)
                    @if($key->id==$check->parent_menu)
                      <?php $flagsub=1; ?>
                    @endif
                  @endforeach
                  <li class="business dropdown">
                    @if ($key->linkmainmenu=="")
                      <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">{{$key->nama}}</a>
                    @else
                      <a href="{{$key->linkmainmenu}}" target="_blank">{{$key->nama}}</a>
                    @endif
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
              </ul>
            </nav>
          </div>
        </div><!--/#navigation-->
      </div><!--/#navigation-->
    </div><!--/#navigation-->
