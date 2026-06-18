<div class="page-title" data-aos="fade">
  <div class="container">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        @if(!empty($parentTitle))
          <li><a href="{{ $parentUrl }}">{{ $parentTitle }}</a></li>
        @endif
        <li class="current">{{ $pageTitle }}</li>
      </ol>
    </nav>
    <h1>{{ $pageTitle }}</h1>
    @if(!empty($pageIntro))
      <p>{{ $pageIntro }}</p>
    @endif
  </div>
</div>
