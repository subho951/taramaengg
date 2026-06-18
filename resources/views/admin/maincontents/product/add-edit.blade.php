@php
  $item = $row;
  $route = $module['controller_route'];
@endphp

<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h1 class="page-header-title">{{ $page_header }}</h1>
      <p class="page-header-text">Products are displayed as showcase items on the frontend.</p>
    </div>
    <div class="col-auto"><a href="{{ url('admin/'.$route.'/list') }}" class="btn btn-white">Back to list</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    @if($categories->isEmpty())
      <div class="alert alert-warning">
        Add a product category before saving a product.
        <a href="{{ url('admin/product-category/add') }}" class="alert-link">Add category</a>
      </div>
    @endif

    <form method="POST" enctype="multipart/form-data">
      @csrf

      <div class="row mb-4">
        <label for="name" class="col-sm-3 col-form-label">Product name</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item?->name) }}" required>
        </div>
      </div>

      <div class="row mb-4">
        <label for="main_category" class="col-sm-3 col-form-label">Category</label>
        <div class="col-sm-9">
          <select class="form-select" id="main_category" name="main_category" required>
            <option value="">Select category</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" @selected((int) old('main_category', $item?->main_category) === (int) $category->id)>{{ $category->category_name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="row mb-4">
        <label for="cover_image" class="col-sm-3 col-form-label">Product image</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="cover_image" name="cover_image" accept=".jpg,.jpeg,.png,.svg,.ico" {{ $item ? '' : 'required' }}>
          <div class="form-text">One showcase image. JPG, JPEG, PNG, SVG or ICO, maximum 4 MB.</div>
          @if($item?->cover_image)
            <img src="{{ env('UPLOADS_URL').'product/'.$item->cover_image }}" alt="{{ $item->name }}" class="img-thumbnail mt-3" style="max-width: 240px; max-height: 180px; object-fit: cover;">
          @endif
        </div>
      </div>

      <div class="row mb-4">
        <label for="short_description" class="col-sm-3 col-form-label">Short description</label>
        <div class="col-sm-9">
          <textarea class="form-control" id="short_description" name="short_description" rows="5" required>{{ old('short_description', $item?->short_description) }}</textarea>
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary" {{ $categories->isEmpty() ? 'disabled' : '' }}>Save product</button>
      </div>
    </form>
  </div>
</div>
