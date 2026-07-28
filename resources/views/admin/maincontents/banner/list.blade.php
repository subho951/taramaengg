@php
  $controllerRoute = $module['controller_route'];
@endphp

<div class="pagetitle">
  <h1>{{ $page_header }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">{{ $page_header }}</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-xl-12">
      @if(session('success_message'))
        <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show autohide" role="alert">
          {{ session('success_message') }}
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      @if(session('error_message'))
        <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show autohide" role="alert">
          {{ session('error_message') }}
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 py-3">
            <div>
              <h5 class="card-title p-0 mb-1">Homepage banner slider</h5>
              <p class="text-muted mb-0">Active banners appear full width in oldest-to-newest order.</p>
            </div>
            <a href="{{ url('admin/'.$controllerRoute.'/add') }}" class="btn btn-success">
              <i class="bi bi-images me-1"></i> Upload Banner(s)
            </a>
          </div>

          <div class="alert alert-info py-2">
            <i class="bi bi-info-circle me-1"></i>
            The first active banner containing introduction text supplies the content section below the slider.
          </div>

          <div class="dt-responsive table-responsive">
            <table id="simpletable" class="table table-striped table-bordered align-middle nowrap">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Banner Preview</th>
                  <th scope="col">Introduction Content</th>
                  <th scope="col">Explore Link</th>
                  <th scope="col">Status</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $row)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                      @if($row->banner_image)
                        <img
                          src="{{ env('UPLOADS_URL').'banner/'.$row->banner_image }}"
                          class="img-thumbnail"
                          alt="{{ $row->banner_text }}"
                          style="width: 220px; height: 82px; object-fit: cover;"
                        >
                      @else
                        <img
                          src="{{ env('NO_IMAGE') }}"
                          alt="No banner image"
                          class="img-thumbnail"
                          style="width: 220px; height: 82px; object-fit: cover;"
                        >
                      @endif
                    </td>
                    <td style="min-width: 300px; white-space: normal;">
                      @if($contentSourceId === $row->id)
                        <span class="badge bg-primary mb-2"><i class="bi bi-file-text me-1"></i> Content shown on homepage</span>
                      @endif
                      @if($row->heading1 || $row->heading2)
                        <div class="small text-uppercase text-muted">{{ trim($row->heading1.' '.$row->heading2) }}</div>
                      @endif
                      <strong>{{ $row->banner_text }}</strong>
                      <div class="small text-muted mt-1">{{ \Illuminate\Support\Str::limit($row->banner_text2, 150) }}</div>
                    </td>
                    <td style="white-space: normal;">
                      @if($row->banner_link)
                        <a href="{{ $row->banner_link }}" target="_blank" rel="noopener" class="badge bg-info text-dark">
                          <i class="bi bi-link-45deg me-1"></i> Open link
                        </a>
                      @else
                        <span class="text-muted">Default</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge {{ $row->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                        {{ $row->status == 1 ? 'Active' : 'Inactive' }}
                      </span>
                    </td>
                    <td>
                      <div class="d-flex flex-wrap gap-1">
                        <a
                          href="{{ url('admin/'.$controllerRoute.'/edit/'.Helper::encoded($row->id)) }}"
                          class="btn btn-outline-primary btn-sm"
                          title="Edit banner"
                        ><i class="fa fa-edit"></i></a>
                        <a
                          href="{{ url('admin/'.$controllerRoute.'/delete/'.Helper::encoded($row->id)) }}"
                          class="btn btn-outline-danger btn-sm"
                          title="Delete banner"
                          onclick="return confirm('Do you want to delete this banner?');"
                        ><i class="fa fa-trash"></i></a>
                        <a
                          href="{{ url('admin/'.$controllerRoute.'/change-status/'.Helper::encoded($row->id)) }}"
                          class="btn {{ $row->status == 1 ? 'btn-outline-warning' : 'btn-outline-success' }} btn-sm"
                          title="{{ $row->status == 1 ? 'Deactivate' : 'Activate' }} banner"
                        ><i class="fa {{ $row->status == 1 ? 'fa-times' : 'fa-check' }}"></i></a>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center text-danger py-4">No banners found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
