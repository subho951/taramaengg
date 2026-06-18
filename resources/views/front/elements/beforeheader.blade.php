@php
  $siteName = $generalSetting->site_name ?: 'Tarama Engineering Concern';
  $logo = $generalSetting->site_logo ? env('UPLOADS_URL').$generalSetting->site_logo : null;
@endphp

<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">
    <a href="{{ route('home') }}" class="logo brand-lockup d-flex align-items-center me-auto">
      @if($logo)
        <img src="{{ $logo }}" alt="{{ $siteName }}">
      @endif
      <span>
        <strong>Tarama</strong>
        <small>Engineering Concern</small>
      </span>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('who-we-are') }}" class="{{ request()->routeIs('who-we-are') ? 'active' : '' }}">Who We Are</a></li>
        <li><a href="{{ route('products') }}" class="{{ request()->routeIs('products', 'products.category') ? 'active' : '' }}">Products</a></li>
        <li><a href="{{ route('clients') }}" class="{{ request()->routeIs('clients') ? 'active' : '' }}">Clients</a></li>
        <li><a href="{{ route('blogs') }}" class="{{ request()->routeIs('blogs', 'blog.details') ? 'active' : '' }}">Blogs</a></li>
        <li><a href="{{ route('career') }}" class="{{ request()->routeIs('career') ? 'active' : '' }}">Career</a></li>
        <li><a href="{{ route('contact-us') }}" class="{{ request()->routeIs('contact-us') ? 'active' : '' }}">Contact Us</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <a class="btn-getstarted" href="{{ route('contact-us') }}">Discuss a Project</a>
  </div>
</header>
