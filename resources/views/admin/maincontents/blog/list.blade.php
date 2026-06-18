@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col"><h1 class="page-header-title">{{ $page_header }}</h1></div>
    <div class="col-auto"><a href="{{ url('admin/blog/add') }}" class="btn btn-primary"><i class="bi-plus me-1"></i> Add post</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <div class="table-responsive">
      <table id="simpletable" class="table table-striped table-bordered align-middle">
        <thead><tr><th>#</th><th>Image</th><th>Title</th><th>Category</th><th>Publish date</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                @if($row->blog_image)
                  <img src="{{ env('UPLOADS_URL').'blog/'.$row->blog_image }}" alt="{{ $row->title }}" class="img-thumbnail" style="width: 90px; height: 65px; object-fit: cover;">
                @else
                  <img src="{{ env('NO_IMAGE') }}" alt="{{ $row->title }}" class="img-thumbnail" style="width: 90px; height: 65px; object-fit: cover;">
                @endif
              </td>
              <td>
                <strong>{{ $row->title }}</strong>
                <div class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($row->short_description), 80) }}</div>
              </td>
              <td>{{ $row->category?->name ?: '-' }}</td>
              <td>{{ $row->publish_date?->format('d M Y') ?: '-' }}</td>
              <td><span class="badge {{ $row->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $row->status == 1 ? 'Published' : 'Draft' }}</span></td>
              <td class="text-nowrap">
                <a href="{{ url('admin/blog/edit/'.Helper::encoded($row->id)) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('admin/blog/change-status/'.Helper::encoded($row->id)) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-power-off"></i></a>
                <a href="{{ url('admin/blog/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this post?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">No blog or news posts found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
