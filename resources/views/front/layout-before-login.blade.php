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
  @if(config('services.recaptcha.site_key') && request()->routeIs('contact-us', 'career'))
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
      document.querySelectorAll('form[data-recaptcha-action]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
          event.preventDefault();

          var submitButton = form.querySelector('[type="submit"]');
          var tokenField = form.querySelector('input[name="recaptcha_token"]');
          var action = form.dataset.recaptchaAction;

          if (!tokenField || !action || form.dataset.recaptchaSubmitting === 'true') {
            return;
          }

          function resetSubmission() {
            form.dataset.recaptchaSubmitting = 'false';
            if (submitButton) {
              submitButton.disabled = false;
            }
          }

          if (typeof grecaptcha === 'undefined') {
            resetSubmission();
            window.alert('The security check could not be loaded. Please refresh the page and try again.');
            return;
          }

          form.dataset.recaptchaSubmitting = 'true';
          if (submitButton) {
            submitButton.disabled = true;
          }

          grecaptcha.ready(function () {
            grecaptcha.execute(@json(config('services.recaptcha.site_key')), { action: action })
              .then(function (token) {
                tokenField.value = token;
                form.submit();
              })
              .catch(function () {
                resetSubmission();
                window.alert('The security check could not be completed. Please refresh the page and try again.');
              });
          });
        });
      });
    </script>
  @endif
</body>
</html>
