@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col"><h1 class="page-header-title">{{ $page_header }}</h1></div>
    <div class="col-auto"><a href="{{ url('admin/client-logo/add') }}" class="btn btn-primary"><i class="bi-plus me-1"></i> Add client</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <div class="table-responsive">
      <table id="simpletable" class="table table-striped table-bordered align-middle">
        <thead><tr><th>#</th><th>Logo</th><th>Client</th><th>Website</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><img src="{{ env('UPLOADS_URL').'client_logo/'.$row->logo }}" alt="{{ $row->name }}" class="img-thumbnail" style="width: 100px; max-height: 70px; object-fit: contain;"></td>
              <td>{{ $row->name }}</td>
              <td>@if($row->website_url)<a href="{{ $row->website_url }}" target="_blank" rel="noopener">Open website</a>@else - @endif</td>
              <td>{{ $row->rank }}</td>
              <td><span class="badge {{ $row->status == 1 ? 'bg-success' : 'bg-secondary' }}">{{ $row->status == 1 ? 'Active' : 'Inactive' }}</span></td>
              <td class="text-nowrap">
                <a href="{{ url('admin/client-logo/edit/'.Helper::encoded($row->id)) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a>
                <a href="{{ url('admin/client-logo/change-status/'.Helper::encoded($row->id)) }}" class="btn btn-outline-warning btn-sm"><i class="fa fa-power-off"></i></a>
                <a href="{{ url('admin/client-logo/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this client logo?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">No client logos added yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
