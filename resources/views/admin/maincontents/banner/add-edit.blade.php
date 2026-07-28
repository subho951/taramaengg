@php
  $controllerRoute = $module['controller_route'];
  $isEdit = (bool) $row;
@endphp

<div class="pagetitle">
  <h1>{{ $page_header }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ url('admin/'.$controllerRoute.'/list') }}">{{ $module['title'] }} List</a></li>
      <li class="breadcrumb-item active">{{ $page_header }}</li>
    </ol>
  </nav>
</div>

<section class="section profile">
  <div class="row">
    <div class="col-xl-12">
      @if($errors->any())
        <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
          <strong>Please review the banner details.</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error_message'))
        <div class="alert alert-danger border-0 alert-dismissible fade show" role="alert">
          {{ session('error_message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>

    <div class="col-xl-12">
      <div class="card">
        <div class="card-body pt-4">
          <div class="alert alert-info">
            <div class="d-flex gap-2">
              <i class="bi bi-info-circle-fill mt-1"></i>
              <div>
                <strong>Full-width homepage slider</strong>
                <div>
                  {{ $isEdit
                    ? 'Replace this slide image or update the introduction content shown below the slider.'
                    : 'Select several images to create multiple slides in one upload. The introduction fields are displayed once in the section below the slider.' }}
                </div>
              </div>
            </div>
          </div>

          <form method="POST" action="" enctype="multipart/form-data">
            @csrf

            <h5 class="card-title pt-0">Content below the slider</h5>

            <div class="row mb-3">
              <label for="heading1" class="col-md-3 col-lg-3 col-form-label">Introduction Heading 1</label>
              <div class="col-md-9 col-lg-9">
                <input
                  type="text"
                  name="heading1"
                  class="form-control"
                  id="heading1"
                  value="{{ old('heading1', $row?->heading1) }}"
                >
              </div>
            </div>

            <div class="row mb-3">
              <label for="heading2" class="col-md-3 col-lg-3 col-form-label">Introduction Heading 2</label>
              <div class="col-md-9 col-lg-9">
                <input
                  type="text"
                  name="heading2"
                  class="form-control"
                  id="heading2"
                  value="{{ old('heading2', $row?->heading2) }}"
                >
              </div>
            </div>

            <div class="row mb-3">
              <label for="banner_text" class="col-md-3 col-lg-3 col-form-label">Introduction Title</label>
              <div class="col-md-9 col-lg-9">
                <input
                  type="text"
                  name="banner_text"
                  class="form-control"
                  id="banner_text"
                  value="{{ old('banner_text', $row?->banner_text) }}"
                  required
                >
              </div>
            </div>

            <div class="row mb-3">
              <label for="banner_text2" class="col-md-3 col-lg-3 col-form-label">Introduction Description</label>
              <div class="col-md-9 col-lg-9">
                <textarea
                  name="banner_text2"
                  class="form-control"
                  id="banner_text2"
                  rows="6"
                  required
                >{{ old('banner_text2', $row?->banner_text2) }}</textarea>
              </div>
            </div>

            <div class="row mb-4">
              <label for="banner_link" class="col-md-3 col-lg-3 col-form-label">Explore More Link</label>
              <div class="col-md-9 col-lg-9">
                <input
                  type="text"
                  name="banner_link"
                  class="form-control"
                  id="banner_link"
                  value="{{ old('banner_link', $row?->banner_link) }}"
                  placeholder="/who-we-are or https://example.com/page"
                >
                <small class="text-muted">Optional. If left blank, the button opens the Who We Are page.</small>
              </div>
            </div>

            <hr>
            <h5 class="card-title">{{ $isEdit ? 'Slide image' : 'Slider images' }}</h5>

            <div class="row mb-4">
              <label for="{{ $isEdit ? 'banner_image' : 'banner_images' }}" class="col-md-3 col-lg-3 col-form-label">
                {{ $isEdit ? 'Banner Image' : 'Banner Images' }}
              </label>
              <div class="col-md-9 col-lg-9">
                @if($isEdit)
                  <input
                    type="file"
                    name="banner_image"
                    class="form-control"
                    id="banner_image"
                    accept=".jpg,.jpeg,.png,.webp,.svg,.ico"
                  >
                @else
                  <input
                    type="file"
                    name="banner_images[]"
                    class="form-control"
                    id="banner_images"
                    accept=".jpg,.jpeg,.png,.webp,.svg,.ico"
                    multiple
                    required
                  >
                  <div id="selected-banner-count" class="small text-success mt-2" aria-live="polite"></div>
                  <ul id="selected-banner-files" class="small text-muted mt-2 mb-0 ps-3"></ul>
                @endif

                <small class="text-info d-block mt-2">
                  Use wide images (recommended 1920 × 650 px). JPG, JPEG, PNG, WEBP, SVG and ICO are accepted; maximum 10 MB each.
                </small>

                @if($isEdit && $row->banner_image)
                  <div class="mt-3">
                    <img
                      src="{{ env('UPLOADS_URL').'banner/'.$row->banner_image }}"
                      class="img-thumbnail"
                      alt="{{ $row->banner_text }}"
                      style="width: 360px; max-width: 100%; aspect-ratio: 16 / 5.5; object-fit: cover;"
                    >
                  </div>
                @endif
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <i class="bi {{ $isEdit ? 'bi-save' : 'bi-cloud-arrow-up' }} me-1"></i>
                {{ $isEdit ? 'Save Banner' : 'Upload Banner(s)' }}
              </button>
              <a href="{{ url('admin/'.$controllerRoute.'/list') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@unless($isEdit)
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('banner_images');
      const count = document.getElementById('selected-banner-count');
      const list = document.getElementById('selected-banner-files');

      input.addEventListener('change', function () {
        const files = Array.from(input.files);
        count.textContent = files.length
          ? files.length + (files.length === 1 ? ' banner selected' : ' banners selected')
          : '';
        list.replaceChildren(...files.map(function (file) {
          const item = document.createElement('li');
          item.textContent = file.name;
          return item;
        }));
      });
    });
  </script>
@endunless
