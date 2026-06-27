@php
  $rating = max(0, min(5, (int) ($testimonial->rate ?: 5)));
  $companyName = $testimonial->company_name ?: 'Client';
  $initials = collect(explode(' ', $companyName))
    ->filter()
    ->map(fn ($part) => \Illuminate\Support\Str::substr($part, 0, 1))
    ->take(2)
    ->implode('');
@endphp

<article class="testimonial-card h-100">
  <div class="testimonial-card-head">
    <div class="testimonial-mark">
      @if($testimonial->company_logo)
        <img src="{{ env('UPLOADS_URL').'testimonial/'.$testimonial->company_logo }}" alt="{{ $companyName }}">
      @elseif($testimonial->image)
        <img src="{{ env('UPLOADS_URL').'testimonial/'.$testimonial->image }}" alt="{{ $testimonial->name ?: $companyName }}">
      @else
        <span>{{ $initials ?: 'TE' }}</span>
      @endif
    </div>
    <div>
      <h3>{{ $companyName }}</h3>
      <div class="testimonial-stars" aria-label="{{ $rating }} out of 5 rating">
        @for($star = 1; $star <= 5; $star++)
          <i class="bi {{ $star <= $rating ? 'bi-star-fill' : 'bi-star' }}"></i>
        @endfor
      </div>
    </div>
  </div>

  <p class="testimonial-quote">"{{ $testimonial->review }}"</p>

  @if($testimonial->name || $testimonial->designation)
    <footer class="testimonial-author">
      @if($testimonial->name)<strong>{{ $testimonial->name }}</strong>@endif
      @if($testimonial->designation)<span>{{ $testimonial->designation }}</span>@endif
    </footer>
  @endif
</article>
