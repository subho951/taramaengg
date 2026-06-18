@include('front.elements.page-title', [
  'pageTitle' => 'Blogs',
  'pageIntro' => 'Engineering insights, company news and practical perspectives from our team.'
])

<div class="container blog-page-wrap">
  <div class="row gy-5">
    <div class="col-lg-8">
      <section id="blog-posts" class="blog-posts section">
        @forelse($blogs as $blog)
          <article class="blog-list-card" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 75, 300) }}">
            <div class="row g-0">
              <div class="col-md-5">
                <a href="{{ route('blog.details', $blog->slug) }}" class="blog-list-image">
                  <img src="{{ $blog->blog_image ? env('UPLOADS_URL').'blog/'.$blog->blog_image : env('FRONT_ASSETS_URL').'img/blog/blog-post-1.webp' }}" alt="{{ $blog->title }}">
                </a>
              </div>
              <div class="col-md-7">
                <div class="blog-list-content">
                  <div class="blog-meta">
                    @if($blog->category)<span><i class="bi bi-folder"></i> {{ $blog->category->name }}</span>@endif
                    <span><i class="bi bi-calendar3"></i> {{ optional($blog->publish_date)->format('M d, Y') ?: $blog->created_at?->format('M d, Y') }}</span>
                  </div>
                  <h2><a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a></h2>
                  <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->short_description ?: $blog->long_description), 190) }}</p>
                  <a href="{{ route('blog.details', $blog->slug) }}" class="read-more-link">Read Article <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </article>
        @empty
          <div class="empty-state" data-aos="fade-up">
            <i class="bi bi-journal-text"></i>
            <h3>No articles found</h3>
            <p>{{ request()->filled('q') || request()->filled('category') ? 'Try changing the search or category filter.' : 'Our first articles and company updates will be published here soon.' }}</p>
            @if(request()->filled('q') || request()->filled('category'))
              <a href="{{ route('blogs') }}" class="btn-brand">Clear Filters</a>
            @endif
          </div>
        @endforelse
      </section>

      @if($blogs->hasPages())
        <nav class="blog-pagination" aria-label="Blog pagination">
          <ul class="pagination justify-content-center">
            <li class="page-item {{ $blogs->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $blogs->previousPageUrl() ?: '#' }}" aria-label="Previous"><i class="bi bi-chevron-left"></i></a>
            </li>
            @foreach($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
              <li class="page-item {{ $page === $blogs->currentPage() ? 'active' : '' }}"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endforeach
            <li class="page-item {{ $blogs->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $blogs->nextPageUrl() ?: '#' }}" aria-label="Next"><i class="bi bi-chevron-right"></i></a>
            </li>
          </ul>
        </nav>
      @endif
    </div>

    <div class="col-lg-4 sidebar">
      <div class="widgets-container" data-aos="fade-up" data-aos-delay="150">
        <div class="search-widget widget-item">
          <h3 class="widget-title">Search</h3>
          <form action="{{ route('blogs') }}" method="get">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search articles">
            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            <button type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
          </form>
        </div>

        @if($recentBlogs->isNotEmpty())
          <div class="recent-posts-widget widget-item">
            <h3 class="widget-title">Recent Posts</h3>
            @foreach($recentBlogs as $recent)
              <div class="post-item">
                <img src="{{ $recent->blog_image ? env('UPLOADS_URL').'blog/'.$recent->blog_image : env('FRONT_ASSETS_URL').'img/blog/blog-post-square-1.webp' }}" alt="{{ $recent->title }}">
                <div>
                  <h4><a href="{{ route('blog.details', $recent->slug) }}">{{ $recent->title }}</a></h4>
                  <time>{{ optional($recent->publish_date)->format('M d, Y') ?: $recent->created_at?->format('M d, Y') }}</time>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        @if($categories->isNotEmpty())
          <div class="categories-widget widget-item">
            <h3 class="widget-title">Categories</h3>
            <ul class="mt-3">
              @foreach($categories as $category)
                <li><a href="{{ route('blogs', ['category' => $category->slug]) }}">{{ $category->name }} <span>({{ $category->blogs_count }})</span></a></li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
