@include('front.elements.page-title', [
  'pageTitle' => $selectedCategory?->category_name ?: 'Products',
  'pageIntro' => $selectedCategory?->short_description
    ? strip_tags($selectedCategory->short_description)
    : 'Browse our product showcase by category and contact us for specifications, availability or project requirements.',
  'parentTitle' => $selectedCategory ? 'Products' : null,
  'parentUrl' => $selectedCategory ? route('products') : null,
])

@if($selectedCategory?->banner_image)
  <section class="product-category-banner">
    <img src="{{ env('UPLOADS_URL').'category/'.$selectedCategory->banner_image }}" alt="{{ $selectedCategory->category_name }}">
  </section>
@endif

<section class="products-page section">
  <div class="container">
    <div class="product-category-nav" data-aos="fade-up">
      <a href="{{ route('products') }}" class="{{ $selectedCategory ? '' : 'active' }}">
        All Products
        <span>{{ $categories->sum('products_count') }}</span>
      </a>
      @foreach($categories as $category)
        <a href="{{ route('products.category', $category->slug) }}" class="{{ $selectedCategory?->id === $category->id ? 'active' : '' }}">
          {{ $category->category_name }}
          <span>{{ $category->products_count }}</span>
        </a>
      @endforeach
    </div>

    @if($selectedCategory?->description)
      <div class="product-category-copy cms-content" data-aos="fade-up">
        {!! $selectedCategory->description !!}
      </div>
    @endif

    <div class="row gy-4">
      @forelse($products as $product)
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 60, 300) }}">
          <article class="product-card">
            <div class="product-card-image">
              <img src="{{ $product->cover_image ? env('UPLOADS_URL').'product/'.$product->cover_image : env('FRONT_ASSETS_URL').'img/portfolio/portfolio-1.webp' }}" alt="{{ $product->name }}">
              @if($product->category)
                <span>{{ $product->category->category_name }}</span>
              @endif
            </div>
            <div class="product-card-content">
              <h2>{{ $product->name }}</h2>
              <p>{{ \Illuminate\Support\Str::limit(strip_tags($product->short_description), 170) }}</p>
              <a href="{{ route('contact-us', ['subject' => 'Product enquiry: '.$product->name]) }}" class="product-enquiry-link">
                Enquire About This Product <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </article>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state" data-aos="fade-up">
            <i class="bi bi-box-seam"></i>
            <h3>No products found</h3>
            <p>{{ $selectedCategory ? 'Products for this category will be published here soon.' : 'Our product catalogue is currently being prepared.' }}</p>
            @if($selectedCategory)
              <a href="{{ route('products') }}" class="btn-brand">View All Products</a>
            @endif
          </div>
        </div>
      @endforelse
    </div>

    @if($products->hasPages())
      <nav class="blog-pagination product-pagination" aria-label="Product pagination">
        <ul class="pagination justify-content-center">
          <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $products->previousPageUrl() ?: '#' }}" aria-label="Previous"><i class="bi bi-chevron-left"></i></a>
          </li>
          @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            <li class="page-item {{ $page === $products->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
          @endforeach
          <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $products->nextPageUrl() ?: '#' }}" aria-label="Next"><i class="bi bi-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
    @endif
  </div>
</section>

<section class="product-cta section light-background">
  <div class="container">
    <div class="split-cta" data-aos="fade-up">
      <div>
        <span class="section-kicker">Need More Information?</span>
        <h2>Discuss Your Product Requirement</h2>
        <p>Share the application, specification or quantity you need and our team will respond with the relevant details.</p>
      </div>
      <a href="{{ route('contact-us', ['subject' => 'Product enquiry']) }}" class="btn-brand">Contact Our Team <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>
</section>
