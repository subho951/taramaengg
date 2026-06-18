@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col"><h1 class="page-header-title">{{ $page_header }}</h1></div>
    <div class="col-auto"><a href="{{ url('admin/blog-category/add') }}" class="btn btn-primary"><i class="bi-plus me-1"></i> Add category</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <div class="table-responsive">
      <table id="simpletable" class="table table-striped table-bordered align-middle">
        <thead><tr><th>#</th><th>Category</th><th>Description</th><th>Posts</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $row->name }}</td>
              <td>{{ \Illuminate\Support\Str::limit(strip_tags($row->description), 100) }}</td>
              <td>{{ $row->blogs()->where('status', '!=', 3)->count() }}</td>
              <td><span class="badge {{ $row->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</span></td>
              <td class="text-nowrap">
                <a href="{{ url('admin/blog-category/edit/'.Helper::encoded($row->id)) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('admin/blog-category/change-status/'.Helper::encoded($row->id)) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-power-off"></i></a>
                <a href="{{ url('admin/blog-category/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this blog category?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted">No blog categories found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
