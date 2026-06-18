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
        <label for="name" class="col-sm-3 col-form-label">Category name</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item?->name) }}" required></div>
      </div>
      <div class="row mb-4">
        <label for="description" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9"><textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $item?->description) }}</textarea></div>
      </div>
      <div class="text-end"><button type="submit" class="btn btn-primary">Save category</button></div>
    </form>
  </div>
</div>
