@include('front.elements.page-title', [
  'pageTitle' => $selectedCategory?->category_name ?: 'Products',
  'pageIntro' => $selectedCategory?->short_description
    ? strip_tags($selectedCategory->short_description)
    : 'Browse our products by category and contact us for specifications, availability or project requirements.',
  'parentTitle' => $selectedCategory ? 'Products' : null,
  'parentUrl' => $selectedCategory ? route('products') : null,
])

<section class="products-page product-listing-page section">
  <div class="container">
    <div class="product-listing">
      @forelse($productCategories as $category)
        <section class="product-list-group" id="category-{{ $category->id }}">
          <h2>
            @if($selectedCategory)
              {{ $category->category_name }}
            @else
              <a href="{{ route('products.category', $category->slug) }}">{{ $category->category_name }}</a>
            @endif
          </h2>

          @if($category->products->isNotEmpty())
            <ol class="product-name-list">
              @foreach($category->products as $product)
                <li>{{ $product->name }}</li>
              @endforeach
            </ol>
          @else
            <p class="product-list-empty">Products for this category will be published here soon.</p>
          @endif
        </section>
      @empty
        <div class="empty-state">
          <i class="bi bi-list-ol"></i>
          <h3>No products found</h3>
          <p>{{ $selectedCategory ? 'Products for this category will be published here soon.' : 'Our product catalogue is currently being prepared.' }}</p>
          @if($selectedCategory)
            <a href="{{ route('products') }}" class="btn-brand">View All Products</a>
          @endif
        </div>
      @endforelse
    </div>
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
