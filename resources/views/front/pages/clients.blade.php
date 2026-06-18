@include('front.elements.page-title', [
  'pageTitle' => 'Clients',
  'pageIntro' => 'Relationships grounded in trust, clear communication and dependable engineering support.'
])

<section class="clients-page section">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Our Clients</span>
    <h2>Partnerships We Value</h2>
    <p>Every engagement is an opportunity to build confidence through responsible work and consistent support.</p>
  </div>

  <div class="container">
    @if($clients->isNotEmpty())
      <div class="row gy-4 justify-content-center">
        @foreach($clients as $client)
          <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 75, 375) }}">
            <div class="client-logo-card">
              @if($client->website_url)<a href="{{ $client->website_url }}" target="_blank" rel="noopener">@endif
                <img src="{{ env('UPLOADS_URL').'client_logo/'.$client->logo }}" alt="{{ $client->name }}">
                <h3>{{ $client->name }}</h3>
              @if($client->website_url)</a>@endif
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state client-empty" data-aos="fade-up">
        <i class="bi bi-buildings"></i>
        <h3>Client portfolio coming soon</h3>
        <p>Our client references are currently being prepared for publication. Contact us to discuss relevant experience for your requirement.</p>
        <a href="{{ route('contact-us') }}" class="btn-brand">Contact Our Team <i class="bi bi-arrow-right"></i></a>
      </div>
    @endif
  </div>
</section>

<section class="client-principles section light-background">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" data-aos="fade-up">
        <div class="principle-card">
          <i class="bi bi-chat-check"></i>
          <h3>Clear Communication</h3>
          <p>Requirements, progress and decisions are communicated with clarity throughout the engagement.</p>
        </div>
      </div>
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="principle-card">
          <i class="bi bi-clipboard2-check"></i>
          <h3>Responsible Delivery</h3>
          <p>We take ownership of agreed work and maintain a practical focus on the intended outcome.</p>
        </div>
      </div>
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="principle-card">
          <i class="bi bi-arrow-repeat"></i>
          <h3>Long-term Support</h3>
          <p>Our aim is to build working relationships that continue beyond a single assignment.</p>
        </div>
      </div>
    </div>
  </div>
</section>
