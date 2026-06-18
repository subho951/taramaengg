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
        <label for="parent_id" class="col-sm-3 col-form-label">Parent category</label>
        <div class="col-sm-9">
          <select class="form-select" id="parent_id" name="parent_id">
            <option value="0">Main category</option>
            @foreach($parents as $parent)
              <option value="{{ $parent->id }}" @selected((int) old('parent_id', $item?->parent_id ?? 0) === (int) $parent->id)>{{ $parent->category_name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="row mb-4">
        <label for="category_name" class="col-sm-3 col-form-label">Category name</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="category_name" name="category_name" value="{{ old('category_name', $item?->category_name) }}" required></div>
      </div>
      <div class="row mb-4">
        <label for="short_description" class="col-sm-3 col-form-label">Short description</label>
        <div class="col-sm-9"><textarea class="form-control" id="short_description" name="short_description" rows="3">{{ old('short_description', $item?->short_description) }}</textarea></div>
      </div>
      <div class="row mb-4">
        <label for="description" class="col-sm-3 col-form-label">Description</label>
        <div class="col-sm-9"><textarea class="form-control ckeditor" id="description" name="description" rows="8">{{ old('description', $item?->description) }}</textarea></div>
      </div>
      <div class="row mb-4">
        <label for="cover_image" class="col-sm-3 col-form-label">Cover image</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="cover_image" name="cover_image" accept=".jpg,.jpeg,.png,.svg,.ico">
          @if($item?->cover_image)
            <img src="{{ env('UPLOADS_URL').'category/'.$item->cover_image }}" class="img-thumbnail mt-3" alt="{{ $item->category_name }}" style="max-width: 160px;">
          @endif
        </div>
      </div>
      <div class="row mb-4">
        <label for="banner_image" class="col-sm-3 col-form-label">Banner image</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="banner_image" name="banner_image" accept=".jpg,.jpeg,.png,.svg,.ico">
          @if($item?->banner_image)
            <img src="{{ env('UPLOADS_URL').'category/'.$item->banner_image }}" class="img-thumbnail mt-3" alt="{{ $item->category_name }}" style="max-width: 220px;">
          @endif
        </div>
      </div>
      <div class="row mb-4">
        <div class="offset-sm-3 col-sm-9">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="is_feature" name="is_feature" value="1" @checked(old('is_feature', $item?->is_feature))>
            <label class="form-check-label" for="is_feature">Show as featured category</label>
          </div>
        </div>
      </div>
      <hr>
      <h4 class="mb-4">SEO</h4>
      <div class="row mb-4">
        <label for="meta_title" class="col-sm-3 col-form-label">Meta title</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $item?->meta_title) }}"></div>
      </div>
      <div class="row mb-4">
        <label for="meta_description" class="col-sm-3 col-form-label">Meta description</label>
        <div class="col-sm-9"><textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $item?->meta_description) }}</textarea></div>
      </div>
      <div class="row mb-4">
        <label for="meta_keywords" class="col-sm-3 col-form-label">Meta keywords</label>
        <div class="col-sm-9"><input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $item?->meta_keywords) }}"></div>
      </div>
      <div class="text-end"><button type="submit" class="btn btn-primary">Save category</button></div>
    </form>
  </div>
</div>
