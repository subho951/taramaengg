@php use App\Helpers\Helper; @endphp
<div class="page-header">
  <div class="row align-items-center">
    <div class="col"><h1 class="page-header-title">{{ $page_header }}</h1></div>
    <div class="col-auto"><a href="{{ url('admin/career-application/list') }}" class="btn btn-white">Back to applications</a></div>
  </div>
</div>

@include('admin.elements.flash')

<div class="row">
  <div class="col-lg-8">
    <div class="card mb-4">
      <div class="card-header"><h4 class="card-header-title">Applicant details</h4></div>
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Name</dt><dd class="col-sm-8">{{ $row->name }}</dd>
          <dt class="col-sm-4">Position</dt><dd class="col-sm-8">{{ $row->position }}</dd>
          <dt class="col-sm-4">Experience</dt><dd class="col-sm-8">{{ $row->experience ?: '-' }}</dd>
          <dt class="col-sm-4">Email</dt><dd class="col-sm-8"><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></dd>
          <dt class="col-sm-4">Phone</dt><dd class="col-sm-8">{{ $row->phone }}</dd>
          <dt class="col-sm-4">Applied on</dt><dd class="col-sm-8">{{ $row->created_at?->format('d M Y, h:i A') }}</dd>
        </dl>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h4 class="card-header-title">Cover message</h4></div>
      <div class="card-body">{!! nl2br(e($row->message ?: 'No message supplied.')) !!}</div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card mb-4">
      <div class="card-header"><h4 class="card-header-title">Application status</h4></div>
      <div class="card-body">
        <form method="POST" action="{{ url('admin/career-application/status/'.Helper::encoded($row->id)) }}">
          @csrf
          <select class="form-select mb-3" name="status" required>
            @foreach($statuses as $value => $label)
              <option value="{{ $value }}" @selected($row->status === $value)>{{ $label }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-primary w-100">Update status</button>
        </form>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h4 class="card-header-title">Resume</h4></div>
      <div class="card-body">
        @if($row->resume)
          <a href="{{ env('UPLOADS_URL').'career/'.$row->resume }}" target="_blank" class="btn btn-outline-primary w-100"><i class="fa fa-download me-1"></i> View resume</a>
        @else
          <p class="text-muted mb-0">No resume uploaded.</p>
        @endif
      </div>
    </div>

    <a href="{{ url('admin/career-application/delete/'.Helper::encoded($row->id)) }}" class="btn btn-outline-danger w-100" onclick="return confirm('Delete this application?')">Delete application</a>
  </div>
</div>
