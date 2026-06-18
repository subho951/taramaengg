@include('front.elements.page-title', [
  'pageTitle' => 'Blog Details',
  'parentTitle' => 'Blogs',
  'parentUrl' => route('blogs')
])

<div class="container blog-detail-wrap">
  <div class="row gy-5">
    <div class="col-lg-8">
      <section id="blog-details" class="blog-details section">
        <article class="article" data-aos="fade-up">
          <div class="hero-img" data-aos="zoom-in">
            <img src="{{ $blog->blog_image ? env('UPLOADS_URL').'blog/'.$blog->blog_image : env('FRONT_ASSETS_URL').'img/blog/blog-post-3.webp' }}" alt="{{ $blog->title }}" class="img-fluid">
            @if($blog->category)
              <div class="meta-overlay">
                <div class="meta-categories">
                  <a href="{{ route('blogs', ['category' => $blog->category->slug]) }}" class="category">{{ $blog->category->name }}</a>
                </div>
              </div>
            @endif
          </div>

          <div class="article-content">
            <div class="content-header">
              <h1 class="title">{{ $blog->title }}</h1>
              <div class="post-meta">
                <span class="date"><i class="bi bi-calendar3"></i> {{ optional($blog->publish_date)->format('F d, Y') ?: $blog->created_at?->format('F d, Y') }}</span>
                @if($blog->category)<span><i class="bi bi-folder"></i> {{ $blog->category->name }}</span>@endif
              </div>
            </div>

            @if($blog->short_description)
              <p class="lead">{{ $blog->short_description }}</p>
            @endif

            <div class="content cms-content">
              {!! $blog->long_description !!}
            </div>

            <div class="article-actions">
              <a href="{{ route('blogs') }}"><i class="bi bi-arrow-left"></i> Back to Blogs</a>
              <a href="{{ route('contact-us') }}">Discuss a Requirement <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </article>
      </section>
    </div>

    <div class="col-lg-4 sidebar">
      <div class="widgets-container" data-aos="fade-up" data-aos-delay="150">
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

        <div class="widget-item sidebar-cta">
          <i class="bi bi-chat-square-text"></i>
          <h3>Have a requirement?</h3>
          <p>Connect with our team to discuss the engineering support you need.</p>
          <a href="{{ route('contact-us') }}">Contact Us <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>
