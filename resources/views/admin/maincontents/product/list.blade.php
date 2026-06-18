@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h1 class="page-header-title">{{ $page_header }}</h1>
      <p class="page-header-text">Manage products displayed in the frontend showcase.</p>
    </div>
    <div class="col-auto"><a href="{{ url('admin/product/add') }}" class="btn btn-primary"><i class="bi-plus me-1"></i> Add product</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <div class="table-responsive">
      <table id="simpletable" class="table table-striped table-bordered align-middle">
        <thead><tr><th>#</th><th>Image</th><th>Product Name</th><th>Category</th><th>Short Description</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                @if($row->cover_image)
                  <img src="{{ env('UPLOADS_URL').'product/'.$row->cover_image }}" alt="{{ $row->name }}" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                @else
                  <img src="{{ env('NO_IMAGE') }}" alt="{{ $row->name }}" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                @endif
              </td>
              <td><strong>{{ $row->name }}</strong></td>
              <td>{{ $row->category?->category_name ?: '-' }}</td>
              <td>{{ \Illuminate\Support\Str::limit(strip_tags($row->short_description), 120) }}</td>
              <td><span class="badge {{ $row->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</span></td>
              <td class="text-nowrap">
                <a href="{{ url('admin/product/edit/'.Helper::encoded($row->id)) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('admin/product/change-status/'.Helper::encoded($row->id)) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-power-off"></i></a>
                <a href="{{ url('admin/product/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this product?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">No products found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
