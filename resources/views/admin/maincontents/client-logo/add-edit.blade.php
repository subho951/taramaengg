@php
  $item = $row;
  $route = $module['controller_route'];
@endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col"><h1 class="page-header-title">{{ $page_header }}</h1></div>
    <div class="col-auto"><a href="{{ url('admin/'.$route.'/list') }}" class="btn btn-white">Back to list</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row mb-4">
        <label for="name" class="col-sm-3 col-form-label">Client name</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item?->name) }}" required></div>
      </div>
      <div class="row mb-4">
        <label for="website_url" class="col-sm-3 col-form-label">Website URL</label>
        <div class="col-sm-9"><input type="url" class="form-control" id="website_url" name="website_url" value="{{ old('website_url', $item?->website_url) }}" placeholder="https://example.com"></div>
      </div>
      <div class="row mb-4">
        <label for="logo" class="col-sm-3 col-form-label">Logo</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="logo" name="logo" accept=".jpg,.jpeg,.png,.svg,.ico" {{ $item ? '' : 'required' }}>
          @if($item?->logo)
            <img src="{{ env('UPLOADS_URL').'client_logo/'.$item->logo }}" alt="{{ $item->name }}" class="img-thumbnail mt-3" style="max-width: 180px; max-height: 100px; object-fit: contain;">
          @endif
        </div>
      </div>
      <div class="row mb-4">
        <label for="rank" class="col-sm-3 col-form-label">Display order</label>
        <div class="col-sm-9"><input type="number" min="0" class="form-control" id="rank" name="rank" value="{{ old('rank', $item?->rank ?? 0) }}"></div>
      </div>
      <div class="text-end"><button type="submit" class="btn btn-primary">Save client logo</button></div>
    </form>
  </div>
</div>
