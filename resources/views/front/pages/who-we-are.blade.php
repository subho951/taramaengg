@php
  $fallbackWhyPoints = [
    ['icon' => 'bi bi-rulers', 'title' => 'Requirement-led Approach', 'description' => 'We begin by understanding the operating need, constraints and expected outcome.'],
    ['icon' => 'bi bi-shield-check', 'title' => 'Quality-led Execution', 'description' => 'Attention to detail and disciplined workmanship guide the delivery process.'],
    ['icon' => 'bi bi-people', 'title' => 'Collaborative Service', 'description' => 'Clear communication keeps clients informed and decisions aligned throughout the work.'],
  ];
@endphp

@include('front.elements.page-title', [
  'pageTitle' => 'Who We Are',
  'pageIntro' => 'Get to know our company, our working principles and what guides our engineering approach.'
])

<section id="about-us" class="about section">
  <div class="container">
    <div class="row gy-5 align-items-center">
      <div class="col-lg-5" data-aos="fade-right">
        <div class="about-visual inner-about-visual">
          <img src="{{ $about?->page_image ? env('UPLOADS_URL').'page/'.$about->page_image : env('FRONT_ASSETS_URL').'img/illustration/illustration-10.webp' }}" class="img-fluid" alt="{{ $about?->page_name ?: 'About us' }}">
          <div class="about-badge"><i class="bi bi-gear-wide-connected"></i><span>Driven by engineering discipline</span></div>
        </div>
      </div>
      <div class="col-lg-7" data-aos="fade-left">
        <span class="section-kicker">About Us</span>
        <h2 class="content-heading">{{ $about?->page_name ?: 'Tarama Engineering Concern' }}</h2>
        <div class="cms-content about-copy">
          {!! $about?->page_content ?: '<p>Tarama Engineering Concern provides dependable engineering support with a focus on practical solutions, disciplined execution and responsive client service.</p>' !!}
        </div>
      </div>
    </div>
  </div>
</section>

<section id="why-us" class="why-us-page section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Why Us</span>
    <h2>{{ $whyChooseUs?->page_name ?: 'Why Choose Tarama' }}</h2>
    @foreach($whyChooseUsIntro as $introParagraph)
      <p>{{ $introParagraph }}</p>
    @endforeach
  </div>

  <div class="container">
    <div class="row gy-4">
      @forelse($whyUsPoints as $point)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
          <div class="why-card h-100">
            <div class="why-card-icon"><i class="{{ $point->icon ?: 'bi bi-gear' }}"></i></div>
            <span class="why-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <h3>{{ $point->title }}</h3>
            <div class="why-card-description cms-content">{!! $point->description !!}</div>
          </div>
        </div>
      @empty
        @foreach($fallbackWhyPoints as $point)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
            <div class="why-card h-100">
              <div class="why-card-icon"><i class="{{ $point['icon'] }}"></i></div>
              <span class="why-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
              <h3>{{ $point['title'] }}</h3>
              <p>{{ $point['description'] }}</p>
            </div>
          </div>
        @endforeach
      @endforelse
    </div>
  </div>
</section>

@if($counters->isNotEmpty())
  <section class="stats-strip section dark-background">
    <div class="container">
      <div class="row gy-4">
        @foreach($counters as $counter)
          <div class="col-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="stat-item">
              <i class="{{ $counter->icon ?: 'bi bi-bar-chart' }}"></i>
              <strong>{{ number_format($counter->value) }}{{ $counter->suffix }}</strong>
              <span>{{ $counter->label }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endif

<section class="section">
  <div class="container">
    <div class="split-cta" data-aos="fade-up">
      <div>
        <span class="section-kicker">Work With Us</span>
        <h2>Looking for a dependable engineering partner?</h2>
        <p>Tell us about your requirement and let us explore the right next step together.</p>
      </div>
      <a href="{{ route('contact-us') }}" class="btn-brand">Start a Conversation <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
</section>
