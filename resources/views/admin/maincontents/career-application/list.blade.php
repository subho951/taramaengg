@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      <h1 class="page-header-title">{{ $page_header }}</h1>
      <p class="page-header-text">Review and track applications submitted from the website career form.</p>
    </div>
  </div>
</div>

@include('admin.elements.flash')

<div class="card">
  <div class="card-body pt-4">
    <div class="table-responsive">
      <table id="simpletable" class="table table-striped table-bordered align-middle">
        <thead><tr><th>#</th><th>Applicant</th><th>Position</th><th>Contact</th><th>Applied</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
          @forelse($rows as $row)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><strong>{{ $row->name }}</strong><div class="text-muted small">{{ $row->experience ?: 'Experience not specified' }}</div></td>
              <td>{{ $row->position }}</td>
              <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a><br>{{ $row->phone }}</td>
              <td>{{ $row->created_at?->format('d M Y, h:i A') }}</td>
              <td><span class="badge bg-soft-primary text-primary">{{ $statuses[$row->status] ?? $row->status }}</span></td>
              <td class="text-nowrap">
                <a href="{{ url('admin/career-application/details/'.Helper::encoded($row->id)) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i></a>
                <a href="{{ url('admin/career-application/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this application?')"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">No career applications received yet.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
