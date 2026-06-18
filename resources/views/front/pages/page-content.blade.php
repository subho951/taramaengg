@include('front.elements.page-title', ['pageTitle' => $page->page_name])

<section class="section">
  <div class="container">
    <div class="row gy-5 align-items-start">
      @if($page->page_image)
        <div class="col-lg-4" data-aos="fade-up">
          <img src="{{ env('UPLOADS_URL').'page/'.$page->page_image }}" class="img-fluid rounded-4 shadow-sm" alt="{{ $page->page_name }}">
        </div>
      @endif
      <div class="{{ $page->page_image ? 'col-lg-8' : 'col-lg-10 mx-auto' }}" data-aos="fade-up" data-aos-delay="100">
        <div class="cms-content content-page-card">{!! $page->page_content !!}</div>
      </div>
    </div>
  </div>
</section>
