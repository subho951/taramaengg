@include('front.elements.page-title', [
  'pageTitle' => 'Contact Us',
  'pageIntro' => 'Share your requirement with our team. We will review it and respond with a practical next step.'
])

<section id="contact" class="contact section">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Get in Touch</span>
    <h2>Let Us Discuss Your Requirement</h2>
    <p>Use the form below or contact us directly. Our team will get back to you as soon as possible.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <div class="col-lg-5">
        <div class="info-wrap">
          <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="150">
            <i class="bi bi-geo-alt flex-shrink-0"></i>
            <div>
              <h3>Address</h3>
              <p>{{ strip_tags($generalSetting->description) }}</p>
            </div>
          </div>

          @if($generalSetting->site_phone)
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $generalSetting->site_phone) }}">{{ $generalSetting->site_phone }}</a></p>
                @if($generalSetting->site_phone2 && $generalSetting->site_phone2 !== $generalSetting->site_phone)
                  <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $generalSetting->site_phone2) }}">{{ $generalSetting->site_phone2 }}</a></p>
                @endif
              </div>
            </div>
          @endif

          @if($generalSetting->site_mail)
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="250">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p><a href="mailto:{{ $generalSetting->site_mail }}">{{ $generalSetting->site_mail }}</a></p>
              </div>
            </div>
          @endif

          <div class="contact-note">
            <i class="bi bi-clock-history"></i>
            <div>
              <strong>What happens next?</strong>
              <p>We review your message, identify the right person to respond and contact you to understand the requirement in more detail.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <form action="{{ route('contact-us') }}" method="post" class="contact-form" data-aos="fade-up" data-aos-delay="200">
          @csrf
          <div class="row gy-4">
            <div class="col-md-6">
              <label for="name-field" class="pb-2">Your Name</label>
              <input type="text" name="name" id="name-field" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="email-field" class="pb-2">Your Email</label>
              <input type="email" name="email" id="email-field" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="phone-field" class="pb-2">Phone Number</label>
              <input type="text" name="phone" id="phone-field" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
              @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="subject-field" class="pb-2">Subject</label>
              <input type="text" name="subject" id="subject-field" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', request('subject')) }}" required>
              @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
              <label for="message-field" class="pb-2">Message</label>
              <textarea name="description" id="message-field" class="form-control @error('description') is-invalid @enderror" rows="8" required>{{ old('description') }}</textarea>
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-12">
              <button type="submit" class="contact-submit">Send Enquiry <i class="bi bi-send"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
