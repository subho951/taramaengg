<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h1 class="page-header-title">{{ $page_header }}</h1>
      <p class="page-header-text">Manage the main About Us content used by the website.</p>
    </div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <form method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row mb-4">
        <label for="page_name" class="col-sm-3 col-form-label">Page title</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" id="page_name" name="page_name" value="{{ old('page_name', $page->page_name ?: 'About Us') }}" required>
        </div>
      </div>

      <div class="row mb-4">
        <label for="page_content" class="col-sm-3 col-form-label">Content</label>
        <div class="col-sm-9">
          <textarea class="form-control ckeditor" id="page_content" name="page_content" rows="12" required>{{ old('page_content', $page->page_content) }}</textarea>
        </div>
      </div>

      <div class="row mb-4">
        <label for="page_image" class="col-sm-3 col-form-label">Section image</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="page_image" name="page_image" accept=".jpg,.jpeg,.png,.svg,.ico">
          @if($page->page_image)
            <img src="{{ env('UPLOADS_URL').'page/'.$page->page_image }}" class="img-thumbnail mt-3" alt="About Us" style="max-width: 180px;">
          @endif
        </div>
      </div>

      <div class="row mb-4">
        <label for="page_banner_image" class="col-sm-3 col-form-label">Banner image</label>
        <div class="col-sm-9">
          <input type="file" class="form-control" id="page_banner_image" name="page_banner_image" accept=".jpg,.jpeg,.png,.svg,.ico">
          @if($page->page_banner_image)
            <img src="{{ env('UPLOADS_URL').'page/'.$page->page_banner_image }}" class="img-thumbnail mt-3" alt="About Us banner" style="max-width: 240px;">
          @endif
        </div>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Save About Us</button>
      </div>
    </form>
  </div>
</div>
