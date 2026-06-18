@php
  $siteName = $generalSetting->site_name ?: 'Tarama Engineering Concern';
  $footerLogo = $generalSetting->site_footer_logo ?: $generalSetting->site_logo;
  $socialLinks = [
    ['url' => $generalSetting->twitter_profile, 'icon' => 'bi-twitter-x', 'label' => 'X'],
    ['url' => $generalSetting->facebook_profile, 'icon' => 'bi-facebook', 'label' => 'Facebook'],
    ['url' => $generalSetting->instagram_profile, 'icon' => 'bi-instagram', 'label' => 'Instagram'],
    ['url' => $generalSetting->linkedin_profile, 'icon' => 'bi-linkedin', 'label' => 'LinkedIn'],
    ['url' => $generalSetting->youtube_profile, 'icon' => 'bi-youtube', 'label' => 'YouTube'],
  ];
@endphp

<footer id="footer" class="footer">
  <div class="footer-newsletter footer-cta">
    <div class="container">
      <div class="row align-items-center gy-3">
        <div class="col-lg-8">
          <h4>Have an engineering requirement in mind?</h4>
          <p>Share the scope with our team and we will help you identify the right way forward.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="{{ route('contact-us') }}" class="footer-cta-button">Start a Conversation <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-5 col-md-6 footer-about">
        <a href="{{ route('home') }}" class="footer-brand d-flex align-items-center">
          @if($footerLogo)
            <img src="{{ env('UPLOADS_URL').$footerLogo }}" alt="{{ $siteName }}">
          @endif
          <span class="sitename">{{ $siteName }}</span>
        </a>
        <p class="footer-summary">
          {{ strip_tags($generalSetting->footer_description ?: 'Dependable engineering solutions built around quality, practical execution and responsive service.') }}
        </p>
        <div class="social-links d-flex">
          @foreach($socialLinks as $social)
            @if($social['url'])
              <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                <i class="bi {{ $social['icon'] }}"></i>
              </a>
            @endif
          @endforeach
        </div>
      </div>

      <div class="col-lg-3 col-md-3 footer-links">
        <h4>Explore</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}">Home</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('who-we-are') }}">Who We Are</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('products') }}">Products</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('clients') }}">Clients</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('blogs') }}">Blogs</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('career') }}">Career</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{ route('contact-us') }}">Contact Us</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-3 footer-contact">
        <h4>Contact</h4>
        <p>{{ strip_tags($generalSetting->description) }}</p>
        @if($generalSetting->site_phone)
          <p class="mt-3"><strong>Phone:</strong> <a href="tel:{{ preg_replace('/[^0-9+]/', '', $generalSetting->site_phone) }}">{{ $generalSetting->site_phone }}</a></p>
        @endif
        @if($generalSetting->site_mail)
          <p><strong>Email:</strong> <a href="mailto:{{ $generalSetting->site_mail }}">{{ $generalSetting->site_mail }}</a></p>
        @endif
      </div>
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    @if($generalSetting->copyright_statement)
      {!! $generalSetting->copyright_statement !!}
    @else
      <p>&copy; {{ date('Y') }} <strong class="px-1 sitename">{{ $siteName }}</strong>. All Rights Reserved.</p>
    @endif
  </div>
</footer>
