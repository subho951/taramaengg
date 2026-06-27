@include('front.elements.page-title', [
  'pageTitle' => 'Testimonials',
  'pageIntro' => 'Client confidence earned through dependable manufacturing, disciplined quality and practical delivery.'
])

<section class="testimonials-page section">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Client Testimonials</span>
    <h2>Trusted by Industry Partners</h2>
    <p>Feedback from organizations that rely on Tarama Engineering Concern for critical fabrication and engineering support.</p>
  </div>

  <div class="container">
    @if($testimonials->isNotEmpty())
      <div class="row gy-4">
        @foreach($testimonials as $testimonial)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 100, 400) }}">
            @include('front.elements.testimonial-card', ['testimonial' => $testimonial])
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state" data-aos="fade-up">
        <i class="bi bi-chat-quote"></i>
        <h3>Testimonials coming soon</h3>
        <p>Client feedback will appear here as it is prepared for publication.</p>
      </div>
    @endif
  </div>
</section>
