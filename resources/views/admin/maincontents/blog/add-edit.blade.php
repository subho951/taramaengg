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

<form method="POST" enctype="multipart/form-data" id="blog-post-form">
  @csrf
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-body pt-4">
          <div class="mb-4">
            <label for="title" class="form-label">Post title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $item?->title) }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label for="short_description" class="form-label">Summary</label>
            <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="4">{{ old('short_description', $item?->short_description) }}</textarea>
            @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-0">
            <label for="long_description" class="form-label">Content</label>
            <textarea class="form-control ckeditor @error('long_description') is-invalid @enderror" id="long_description" name="long_description" rows="14" data-editor-required="true">{{ old('long_description', $item?->long_description) }}</textarea>
            <div class="invalid-feedback editor-invalid-feedback @error('long_description') d-block @enderror">
              @error('long_description'){{ $message }}@else Please enter the blog content. @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header"><h4 class="card-header-title">SEO</h4></div>
        <div class="card-body">
          <div class="mb-3">
            <label for="meta_title" class="form-label">Meta title</label>
            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $item?->meta_title) }}">
          </div>
          <div class="mb-3">
            <label for="meta_description" class="form-label">Meta description</label>
            <textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $item?->meta_description) }}</textarea>
          </div>
          <div class="mb-0">
            <label for="meta_keywords" class="form-label">Meta keywords</label>
            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $item?->meta_keywords) }}">
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h4 class="card-header-title">Publishing</h4></div>
        <div class="card-body">
          <div class="mb-4">
            <label for="blog_category_id" class="form-label">Category</label>
            <select class="form-select @error('blog_category_id') is-invalid @enderror" id="blog_category_id" name="blog_category_id" required>
              <option value="">Select category</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('blog_category_id', $item?->blog_category_id) === (int) $category->id)>{{ $category->name }}</option>
              @endforeach
            </select>
            @error('blog_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @if($categories->isEmpty())
              <div class="alert alert-warning mt-3 mb-0">
                Add an active blog category before saving a post.
                <a href="{{ url('admin/blog-category/add') }}" class="alert-link">Add category</a>
              </div>
            @endif
          </div>
          <div class="mb-0">
            <label for="publish_date" class="form-label">Publish date</label>
            <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ old('publish_date', $item?->publish_date?->format('Y-m-d') ?? date('Y-m-d')) }}" required>
            @error('publish_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header"><h4 class="card-header-title">Featured image</h4></div>
        <div class="card-body">
          <input type="file" class="form-control @error('blog_image') is-invalid @enderror" id="blog_image" name="blog_image" accept=".jpg,.jpeg,.png,.webp,.svg,.ico">
          <div class="form-text">JPG, JPEG, PNG, WebP, SVG or ICO, maximum 8 MB.</div>
          @error('blog_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
          @if($item?->blog_image)
            <img src="{{ env('UPLOADS_URL').'blog/'.$item->blog_image }}" alt="{{ $item->title }}" class="img-thumbnail mt-3 w-100">
          @endif
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100" @disabled($categories->isEmpty())>Save post</button>
    </div>
  </div>
</form>
