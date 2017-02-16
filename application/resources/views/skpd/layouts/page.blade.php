<!DOCTYPE html>
<html lang="id">
  <head>
    @yield('title')
    @include('skpd.includes.head')
  </head>

  <body>

    <div id="main-wrapper" class="page">
      @include('skpd.includes.topbar')

      <div class="container">
      @yield('content')
      </div>

      <footer id="footer">
  		  @include('skpd.includes.footer')
  		</footer>
    </div>

  @include('skpd.includes.script')

  </body>
</html>
