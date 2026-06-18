@php
  $fallbackWhyPoints = [
    ['icon' => 'bi bi-tools', 'title' => 'Practical Engineering', 'description' => 'Solutions shaped around real operating conditions, project needs and long-term usability.'],
    ['icon' => 'bi bi-patch-check', 'title' => 'Quality Focus', 'description' => 'Careful workmanship and a disciplined approach remain central to every engagement.'],
    ['icon' => 'bi bi-headset', 'title' => 'Responsive Support', 'description' => 'Clear communication and dependable support from initial discussion through delivery.'],
  ];
@endphp

<section id="hero" class="hero section dark-background">
  <div class="swiper init-swiper hero-swiper">
    <script type="application/json" class="swiper-config">
      {
        "loop": {{ $banners->count() > 1 ? 'true' : 'false' }},
        "speed": 700,
        "autoplay": { "delay": 6500 },
        "pagination": { "el": ".hero-pagination", "clickable": true }
      }
    </script>

    <div class="swiper-wrapper">
      @forelse($banners as $banner)
        <div class="swiper-slide">
          <div class="container">
            <div class="row gy-4 align-items-center">
              <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                @if($banner->heading1 || $banner->heading2)
                  <span class="hero-eyebrow">{{ trim($banner->heading1.' '.$banner->heading2) }}</span>
                @endif
                <h1>{{ $banner->banner_text }}</h1>
                <p>{{ $banner->banner_text2 }}</p>
                <div class="d-flex flex-wrap gap-3">
                  <a href="{{ $banner->banner_link ?: route('contact-us') }}" class="btn-get-started">Explore More</a>
                  <a href="{{ route('contact-us') }}" class="btn-watch-video d-flex align-items-center"><i class="bi bi-chat-dots"></i><span>Talk to Our Team</span></a>
                </div>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="150">
                <img src="{{ env('UPLOADS_URL').'banner/'.$banner->banner_image }}" class="img-fluid animated" alt="{{ $banner->banner_text }}">
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="swiper-slide">
          <div class="container">
            <div class="row gy-4 align-items-center">
              <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                <span class="hero-eyebrow">Tarama Engineering Concern</span>
                <h1>Engineering reliability into every solution</h1>
                <p>Practical expertise, quality-focused execution and responsive support for demanding engineering requirements.</p>
                <div class="d-flex flex-wrap gap-3">
                  <a href="{{ route('who-we-are') }}" class="btn-get-started">Discover Our Approach</a>
                  <a href="{{ route('contact-us') }}" class="btn-watch-video d-flex align-items-center"><i class="bi bi-chat-dots"></i><span>Discuss a Project</span></a>
                </div>
              </div>
              <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="150">
                <img src="{{ env('FRONT_ASSETS_URL') }}img/hero-img.png" class="img-fluid animated" alt="Engineering solutions illustration">
              </div>
            </div>
          </div>
        </div>
      @endforelse
    </div>
    @if($banners->count() > 1)
      <div class="swiper-pagination hero-pagination"></div>
    @endif
  </div>
</section>

<section id="about" class="about section">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Who We Are</span>
    <h2>{{ $about?->page_name ?: 'Built on Engineering Commitment' }}</h2>
    <p>Experience, careful execution and lasting working relationships shape the way we approach every requirement.</p>
  </div>

  <div class="container">
    <div class="row gy-4 align-items-center">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="about-visual">
          <img src="{{ $about?->page_image ? env('UPLOADS_URL').'page/'.$about->page_image : env('FRONT_ASSETS_URL').'img/illustration/illustration-10.webp' }}" class="img-fluid" alt="{{ $about?->page_name ?: 'About Tarama Engineering Concern' }}">
          <div class="about-badge"><i class="bi bi-gear-wide-connected"></i><span>Engineering with purpose</span></div>
        </div>
      </div>
      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
        <h3>Dependable thinking. Practical execution.</h3>
        <p>{{ \Illuminate\Support\Str::limit(strip_tags($about?->page_content ?: 'Tarama Engineering Concern works with a clear focus on dependable engineering, disciplined execution and responsive service.'), 650) }}</p>
        <a href="{{ route('who-we-are') }}" class="read-more"><span>Learn more about us</span><i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<section id="why-us" class="services section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Why Us</span>
    <h2>What You Can Expect</h2>
    <p>{{ \Illuminate\Support\Str::limit(strip_tags($whyChooseUs?->page_content ?: 'A straightforward engineering partner committed to clarity, quality and accountable delivery.'), 240) }}</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      @forelse($whyUsPoints as $point)
        <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
          <div class="service-item position-relative">
            <div class="icon"><i class="{{ $point->icon ?: 'bi bi-gear' }}"></i></div>
            <h4>{{ $point->title }}</h4>
            <p>{{ $point->description }}</p>
          </div>
        </div>
      @empty
        @foreach($fallbackWhyPoints as $point)
          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
            <div class="service-item position-relative">
              <div class="icon"><i class="{{ $point['icon'] }}"></i></div>
              <h4>{{ $point['title'] }}</h4>
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

<section id="clients" class="clients-showcase section">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Clients</span>
    <h2>Relationships Built on Trust</h2>
    <p>We value long-term collaboration, dependable communication and work that earns continued confidence.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    @if($clients->isNotEmpty())
      <div class="swiper init-swiper client-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 3500 },
            "slidesPerView": "auto",
            "breakpoints": {
              "320": { "slidesPerView": 2, "spaceBetween": 24 },
              "640": { "slidesPerView": 3, "spaceBetween": 32 },
              "992": { "slidesPerView": 5, "spaceBetween": 40 }
            }
          }
        </script>
        <div class="swiper-wrapper align-items-center">
          @foreach($clients as $client)
            <div class="swiper-slide">
              @if($client->website_url)<a href="{{ $client->website_url }}" target="_blank" rel="noopener">@endif
                <img src="{{ env('UPLOADS_URL').'client_logo/'.$client->logo }}" class="img-fluid" alt="{{ $client->name }}">
              @if($client->website_url)</a>@endif
            </div>
          @endforeach
        </div>
      </div>
    @else
      <div class="client-intro-card">
        <i class="bi bi-buildings"></i>
        <div>
          <h3>Serving engineering requirements with care</h3>
          <p>Our client portfolio is being prepared for publication. Speak with our team to learn how we can support your requirement.</p>
        </div>
        <a href="{{ route('clients') }}" class="btn-outline-brand">View Clients <i class="bi bi-arrow-right"></i></a>
      </div>
    @endif
  </div>
</section>

<section id="recent-blogs" class="recent-blog-postst section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Insights</span>
    <h2>Latest from Tarama</h2>
    <p>Company news, engineering observations and practical updates from our team.</p>
  </div>

  <div class="container">
    @if($blogs->isNotEmpty())
      <div class="row gy-4">
        @foreach($blogs as $blog)
          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 100) }}">
            <article class="post-item position-relative h-100">
              <div class="post-img position-relative overflow-hidden">
                <img src="{{ $blog->blog_image ? env('UPLOADS_URL').'blog/'.$blog->blog_image : env('FRONT_ASSETS_URL').'img/blog/blog-post-1.webp' }}" class="img-fluid" alt="{{ $blog->title }}">
                <span class="post-date">{{ optional($blog->publish_date)->format('M d') ?: $blog->created_at?->format('M d') }}</span>
              </div>
              <div class="post-content d-flex flex-column">
                <h3 class="post-title">{{ $blog->title }}</h3>
                <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->short_description), 130) }}</p>
                <hr>
                <a href="{{ route('blog.details', $blog->slug) }}" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
              </div>
            </article>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state" data-aos="fade-up">
        <i class="bi bi-journal-text"></i>
        <h3>Insights are on the way</h3>
        <p>New engineering articles and company updates will appear here as they are published.</p>
      </div>
    @endif

    <div class="text-center mt-5">
      <a href="{{ route('blogs') }}" class="btn-brand">View All Blogs <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
</section>

@if($faqs->isNotEmpty())
  <section id="faq" class="faq-2 section">
    <div class="container section-title" data-aos="fade-up">
      <span class="section-kicker">Common Questions</span>
      <h2>Frequently Asked Questions</h2>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="faq-container">
            @foreach($faqs as $faq)
              <div class="faq-item {{ $loop->first ? 'faq-active' : '' }}" data-aos="fade-up" data-aos-delay="{{ 100 + ($loop->index * 75) }}">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>{{ $faq->question }}</h3>
                <div class="faq-content"><p>{{ $faq->answer }}</p></div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
@endif

<section class="home-contact-cta section dark-background">
  <div class="container">
    <div class="row align-items-center gy-4" data-aos="zoom-in">
      <div class="col-lg-8">
        <span class="section-kicker light">Let Us Talk</span>
        <h2>Bring us your next engineering challenge</h2>
        <p>Tell us what you are trying to achieve. Our team will review your requirement and respond with a practical next step.</p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="{{ route('contact-us') }}" class="cta-button">Contact Our Team <i class="bi bi-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>
