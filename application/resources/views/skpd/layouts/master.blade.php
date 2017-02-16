<!DOCTYPE html>
<html lang="id">
  <head>
    @yield('title')
    @include('skpd.includes.head')
  </head>

  <body>

    <div id="main-wrapper" class="homepage-two fixed-nav">
      @include('skpd.includes.topbarnav')

      <div class="container">
      @yield('content')
      </div>

    </div>
    <footer id="footer">
      @include('skpd.includes.footer')
    </footer>
    @include('skpd.includes.script')


  </body>
</html>
