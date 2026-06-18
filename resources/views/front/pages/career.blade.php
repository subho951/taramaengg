@include('front.elements.page-title', [
  'pageTitle' => 'Career',
  'pageIntro' => 'Bring your skills, discipline and ideas to a team focused on dependable engineering work.'
])

<section class="career-intro section">
  <div class="container">
    <div class="row gy-5 align-items-center">
      <div class="col-lg-6" data-aos="fade-up">
        <span class="section-kicker">Work With Us</span>
        <h2 class="content-heading">Build Practical Solutions That Matter</h2>
        <p>We value people who approach their work responsibly, communicate clearly and keep learning. Tell us where you can contribute and our team will review your application.</p>
        <div class="career-values">
          <div><i class="bi bi-lightbulb"></i><span>Practical problem solving</span></div>
          <div><i class="bi bi-people"></i><span>Collaborative teamwork</span></div>
          <div><i class="bi bi-graph-up-arrow"></i><span>Continuous development</span></div>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="career-visual">
          <img src="{{ env('FRONT_ASSETS_URL').'img/illustration/illustration-10.webp' }}" alt="Career at Tarama Engineering Concern">
          <div class="career-visual-note">
            <i class="bi bi-person-workspace"></i>
            <span>People, skills and responsible execution</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="apply" class="career-application section light-background">
  <div class="container section-title" data-aos="fade-up">
    <span class="section-kicker">Apply Now</span>
    <h2>Submit Your Application</h2>
    <p>Complete the form and attach your latest resume. Applications are available to the administration team for review.</p>
  </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-9">
        <form action="{{ route('career') }}" method="post" enctype="multipart/form-data" class="career-form" data-aos="fade-up" data-aos-delay="100">
          @csrf
          <div class="row gy-4">
            <div class="col-md-6">
              <label for="career-name">Full Name</label>
              <input type="text" name="name" id="career-name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="career-email">Email Address</label>
              <input type="email" name="email" id="career-email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="career-phone">Phone Number</label>
              <input type="text" name="phone" id="career-phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
              @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="career-position">Position Applied For</label>
              <input type="text" name="position" id="career-position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}" placeholder="e.g. Site Engineer" required>
              @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="career-experience">Experience</label>
              <input type="text" name="experience" id="career-experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience') }}" placeholder="e.g. 3 years">
              @error('experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-md-6">
              <label for="career-resume">Resume</label>
              <input type="file" name="resume" id="career-resume" class="form-control @error('resume') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
              <div class="form-text">PDF, DOC or DOCX, maximum 5 MB.</div>
              @error('resume')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12">
              <label for="career-message">Cover Message</label>
              <textarea name="message" id="career-message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Briefly tell us about your skills and the work you are interested in.">{{ old('message') }}</textarea>
              @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-12 career-form-action">
              <p><i class="bi bi-shield-check"></i> Your information will only be used to review your application.</p>
              <button type="submit" class="contact-submit">Submit Application <i class="bi bi-send"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
