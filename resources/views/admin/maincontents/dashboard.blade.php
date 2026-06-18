<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h1 class="page-header-title">{{ $page_header }}</h1>
      <p class="page-header-text">Manage the website content from one place.</p>
    </div>
  </div>
</div>

<div class="row">
  @php
    $cards = [
      ['label' => 'Homepage Banners', 'count' => $banner_count, 'url' => 'admin/banner/list', 'icon' => 'fa-images', 'color' => 'primary'],
      ['label' => 'Product Categories', 'count' => $category_count, 'url' => 'admin/product-category/list', 'icon' => 'fa-layer-group', 'color' => 'info'],
      ['label' => 'Products', 'count' => $product_count, 'url' => 'admin/product/list', 'icon' => 'fa-box', 'color' => 'success'],
      ['label' => 'Career Applications', 'count' => $career_count, 'url' => 'admin/career-application/list', 'icon' => 'fa-file-lines', 'color' => 'warning'],
      ['label' => 'Client Logos', 'count' => $client_count, 'url' => 'admin/client-logo/list', 'icon' => 'fa-handshake', 'color' => 'secondary'],
      ['label' => 'Blogs / News', 'count' => $blog_count, 'url' => 'admin/blog/list', 'icon' => 'fa-newspaper', 'color' => 'danger'],
      ['label' => 'Content Pages', 'count' => $page_count, 'url' => 'admin/page/list', 'icon' => 'fa-file', 'color' => 'dark'],
      ['label' => 'Contact Enquiries', 'count' => $enquiry_count, 'url' => 'admin/enquiry/list', 'icon' => 'fa-envelope', 'color' => 'primary'],
    ];
  @endphp

  @foreach($cards as $card)
    <div class="col-sm-6 col-xl-3 mb-4">
      <a class="card card-hover-shadow h-100" href="{{ url($card['url']) }}">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <span class="avatar avatar-lg avatar-soft-{{ $card['color'] }} avatar-circle">
                <span class="avatar-initials"><i class="fa {{ $card['icon'] }}"></i></span>
              </span>
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="card-subtitle mb-1">{{ $card['label'] }}</h6>
              <h2 class="card-title text-inherit mb-0">{{ number_format($card['count']) }}</h2>
            </div>
          </div>
        </div>
      </a>
    </div>
  @endforeach
</div>

<div class="card">
  <div class="card-header"><h4 class="card-header-title">Quick actions</h4></div>
  <div class="card-body">
    <div class="d-flex flex-wrap gap-2">
      <a href="{{ url('admin/banner/add') }}" class="btn btn-outline-primary"><i class="bi-plus me-1"></i> Add banner</a>
      <a href="{{ url('admin/product/add') }}" class="btn btn-outline-primary"><i class="bi-plus me-1"></i> Add product</a>
      <a href="{{ url('admin/blog/add') }}" class="btn btn-outline-primary"><i class="bi-plus me-1"></i> Add blog / news</a>
      <a href="{{ url('admin/about-us') }}" class="btn btn-outline-primary"><i class="bi-pencil me-1"></i> Edit About Us</a>
    </div>
  </div>
</div>
