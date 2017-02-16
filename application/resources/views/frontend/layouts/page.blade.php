<!DOCTYPE html>
<html lang="id">
  <head>
    @yield('title')
    @include('frontend.includes.head2')
  </head>

  <body>

    <div id="main-wrapper" class="page">
      @include('frontend.includes.topbar')

      <div class="container">
      @yield('content')
      </div>

      <footer id="footer">
  		  @include('frontend.includes.footer')
  		</footer>
    </div>

  @include('frontend.includes.script')

  </body>
</html>
