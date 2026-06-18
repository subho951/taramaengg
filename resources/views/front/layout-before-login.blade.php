<!DOCTYPE html>
<html lang="en">
<head>
  {!! $before_head !!}
</head>
<body class="{{ request()->routeIs('home') ? 'index-page' : 'inner-page' }}">
  {!! $before_header !!}

  <main class="main">
    @if(session('success_message') || session('error_message') || $errors->any())
      <div class="site-alerts container">
        @if(session('success_message'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if(session('error_message'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please review the highlighted fields and try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
    @endif

    {!! $maincontent !!}
  </main>

  {!! $before_footer !!}

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Back to top">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <div id="preloader"></div>

  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/aos/aos.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/glightbox/js/glightbox.min.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/swiper/swiper-bundle.min.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/waypoints/noframework.waypoints.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="{{ env('FRONT_ASSETS_URL') }}js/main.js"></script>
</body>
</html>
