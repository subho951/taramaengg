@php
  $websiteOpen = request()->is('admin/banner*')
    || request()->is('admin/about-us*')
    || request()->is('admin/why-us-point*')
    || request()->is('admin/homepage-counter*')
    || request()->is('admin/client-logo*');
  $catalogOpen = request()->is('admin/product-category*') || request()->is('admin/product*');
  $blogOpen = request()->is('admin/blog-category*') || request()->is('admin/blog*');
  $otherOpen = request()->is('admin/page*')
    || request()->is('admin/testimonial*')
    || request()->is('admin/gallery-category*')
    || request()->is('admin/gallery*')
    || request()->is('admin/faq-category*')
    || request()->is('admin/faq*')
    || request()->is('admin/notice*')
    || request()->is('admin/enquiry*');
  $adminOpen = request()->is('admin/settings*')
    || request()->is('admin/email-logs*')
    || request()->is('admin/login-logs*');
@endphp

<div class="navbar-vertical-container">
  <div class="navbar-vertical-footer-offset">
    <a class="navbar-brand" href="{{ url('admin/dashboard') }}" aria-label="{{ $generalSetting->site_name }}">
      <img class="navbar-brand-logo" src="{{ env('UPLOADS_URL').$generalSetting->site_logo }}" alt="{{ $generalSetting->site_name }}" data-hs-theme-appearance="default" style="margin: 0 auto;">
      <img class="navbar-brand-logo" src="{{ env('UPLOADS_URL').$generalSetting->site_logo }}" alt="{{ $generalSetting->site_name }}" data-hs-theme-appearance="dark" style="margin: 0 auto;">
      <img class="navbar-brand-logo-mini" src="{{ env('UPLOADS_URL').$generalSetting->site_logo }}" alt="{{ $generalSetting->site_name }}" data-hs-theme-appearance="default" style="margin: 0 auto;">
      <img class="navbar-brand-logo-mini" src="{{ env('UPLOADS_URL').$generalSetting->site_logo }}" alt="{{ $generalSetting->site_name }}" data-hs-theme-appearance="dark" style="margin: 0 auto;">
    </a>

    <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
      <i class="bi-arrow-bar-left navbar-toggler-short-align" data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
      <i class="bi-arrow-bar-right navbar-toggler-full-align" data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
    </button>

    <div class="navbar-vertical-content">
      <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
        <div class="nav-item">
          <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
            <i class="fa fa-home nav-icon"></i>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </div>

        <span class="dropdown-header mt-4">Content Management</span>

        <div class="nav-item">
          <a class="nav-link dropdown-toggle {{ $websiteOpen ? '' : 'collapsed' }}" href="#websiteContentMenu" role="button" data-bs-toggle="collapse" data-bs-target="#websiteContentMenu" aria-expanded="{{ $websiteOpen ? 'true' : 'false' }}">
            <i class="fa fa-globe nav-icon"></i>
            <span class="nav-link-title">Website Content</span>
          </a>
          <div id="websiteContentMenu" class="nav-collapse collapse {{ $websiteOpen ? 'show' : '' }}" data-bs-parent="#navbarVerticalMenu">
            <a class="nav-link {{ request()->is('admin/banner*') ? 'active' : '' }}" href="{{ url('admin/banner/list') }}">Homepage Banners</a>
            <a class="nav-link {{ request()->is('admin/about-us*') ? 'active' : '' }}" href="{{ url('admin/about-us') }}">About Us</a>
            <a class="nav-link {{ request()->is('admin/why-us-point*') ? 'active' : '' }}" href="{{ url('admin/why-us-point/list') }}">Why Us Points</a>
            <a class="nav-link {{ request()->is('admin/homepage-counter*') ? 'active' : '' }}" href="{{ url('admin/homepage-counter/list') }}">Why Us Counters</a>
            <a class="nav-link {{ request()->is('admin/client-logo*') ? 'active' : '' }}" href="{{ url('admin/client-logo/list') }}">Client Logos</a>
          </div>
        </div>

        <div class="nav-item">
          <a class="nav-link dropdown-toggle {{ $catalogOpen ? '' : 'collapsed' }}" href="#catalogMenu" role="button" data-bs-toggle="collapse" data-bs-target="#catalogMenu" aria-expanded="{{ $catalogOpen ? 'true' : 'false' }}">
            <i class="fa fa-boxes-stacked nav-icon"></i>
            <span class="nav-link-title">Products</span>
          </a>
          <div id="catalogMenu" class="nav-collapse collapse {{ $catalogOpen ? 'show' : '' }}" data-bs-parent="#navbarVerticalMenu">
            <a class="nav-link {{ request()->is('admin/product-category*') ? 'active' : '' }}" href="{{ url('admin/product-category/list') }}">Product Categories</a>
            <a class="nav-link {{ request()->is('admin/product*') && !request()->is('admin/product-category*') ? 'active' : '' }}" href="{{ url('admin/product/list') }}">Products</a>
          </div>
        </div>

        <div class="nav-item">
          <a class="nav-link {{ request()->is('admin/career-application*') ? 'active' : '' }}" href="{{ url('admin/career-application/list') }}">
            <i class="fa fa-file-lines nav-icon"></i>
            <span class="nav-link-title">Career Applications</span>
          </a>
        </div>

        <div class="nav-item">
          <a class="nav-link dropdown-toggle {{ $blogOpen ? '' : 'collapsed' }}" href="#blogMenu" role="button" data-bs-toggle="collapse" data-bs-target="#blogMenu" aria-expanded="{{ $blogOpen ? 'true' : 'false' }}">
            <i class="fa fa-newspaper nav-icon"></i>
            <span class="nav-link-title">Blogs &amp; News</span>
          </a>
          <div id="blogMenu" class="nav-collapse collapse {{ $blogOpen ? 'show' : '' }}" data-bs-parent="#navbarVerticalMenu">
            <a class="nav-link {{ request()->is('admin/blog-category*') ? 'active' : '' }}" href="{{ url('admin/blog-category/list') }}">Categories</a>
            <a class="nav-link {{ request()->is('admin/blog*') && !request()->is('admin/blog-category*') ? 'active' : '' }}" href="{{ url('admin/blog/list') }}">Posts</a>
          </div>
        </div>

        <div class="nav-item">
          <a class="nav-link dropdown-toggle {{ $otherOpen ? '' : 'collapsed' }}" href="#otherContentMenu" role="button" data-bs-toggle="collapse" data-bs-target="#otherContentMenu" aria-expanded="{{ $otherOpen ? 'true' : 'false' }}">
            <i class="fa fa-folder-open nav-icon"></i>
            <span class="nav-link-title">Other Content</span>
          </a>
          <div id="otherContentMenu" class="nav-collapse collapse {{ $otherOpen ? 'show' : '' }}" data-bs-parent="#navbarVerticalMenu">
            <!-- <a class="nav-link {{ request()->is('admin/page*') ? 'active' : '' }}" href="{{ url('admin/page/list') }}">Pages</a> -->
            <a class="nav-link {{ request()->is('admin/testimonial*') ? 'active' : '' }}" href="{{ url('admin/testimonial/list') }}">Testimonials</a>
            <a class="nav-link {{ request()->is('admin/gallery-category*') || request()->is('admin/gallery*') ? 'active' : '' }}" href="{{ url('admin/gallery/list') }}">Gallery</a>
            <a class="nav-link {{ request()->is('admin/faq*') ? 'active' : '' }}" href="{{ url('admin/faq/list') }}">FAQs</a>
            <a class="nav-link {{ request()->is('admin/notice*') ? 'active' : '' }}" href="{{ url('admin/notice/list') }}">Notices</a>
            <a class="nav-link {{ request()->is('admin/enquiry*') ? 'active' : '' }}" href="{{ url('admin/enquiry/list') }}">Contact Enquiries</a>
          </div>
        </div>

        <span class="dropdown-header mt-4">Administration</span>

        <div class="nav-item">
          <a class="nav-link dropdown-toggle {{ $adminOpen ? '' : 'collapsed' }}" href="#administrationMenu" role="button" data-bs-toggle="collapse" data-bs-target="#administrationMenu" aria-expanded="{{ $adminOpen ? 'true' : 'false' }}">
            <i class="fa fa-gear nav-icon"></i>
            <span class="nav-link-title">Administration</span>
          </a>
          <div id="administrationMenu" class="nav-collapse collapse {{ $adminOpen ? 'show' : '' }}" data-bs-parent="#navbarVerticalMenu">
            <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ url('admin/settings') }}">Settings</a>
            <a class="nav-link {{ request()->is('admin/email-logs*') ? 'active' : '' }}" href="{{ url('admin/email-logs') }}">Email Logs</a>
            <a class="nav-link {{ request()->is('admin/login-logs*') ? 'active' : '' }}" href="{{ url('admin/login-logs') }}">Login Logs</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
