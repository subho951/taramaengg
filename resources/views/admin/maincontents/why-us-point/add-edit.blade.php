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
    <form method="POST">
      @csrf
      <div class="row mb-4">
        <label for="title" class="col-sm-3 col-form-label">Title</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="title" name="title" value="{{ old('title', $item?->title) }}" required></div>
      </div>
      <div class="row mb-4">
        <label for="description" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9"><textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $item?->description) }}</textarea></div>
      </div>
      <div class="row mb-4">
        <label for="icon" class="col-sm-3 col-form-label">Icon class</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $item?->icon) }}" placeholder="Example: bi bi-gear">
          <div class="form-text">Use a Bootstrap Icons or Font Awesome class.</div>
        </div>
      </div>
      <div class="row mb-4">
        <label for="rank" class="col-sm-3 col-form-label">Display order</label>
        <div class="col-sm-9"><input type="number" min="0" class="form-control" id="rank" name="rank" value="{{ old('rank', $item?->rank ?? 0) }}"></div>
      </div>
      <div class="text-end"><button type="submit" class="btn btn-primary">Save point</button></div>
    </form>
  </div>
</div>
