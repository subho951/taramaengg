<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\CareerApplication;
use App\Models\Category;
use App\Models\ClientLogo;
use App\Models\EmailLog;
use App\Models\Enquiry;
use App\Models\FaqCategory;
use App\Models\GeneralSetting;
use App\Models\HomepageCounter;
use App\Models\Page;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\WhyUsPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class FrontController extends Controller
{
    use HandlesUploads;

    public function home()
    {
        $data = [
            'banners' => Banner::where('status', 1)->orderBy('id')->get(),
            'about' => $this->aboutPage(),
            'whyChooseUs' => $this->whyChooseUsPage(),
            'whyChooseUsIntro' => $this->whyChooseUsIntro(),
            'whyUsPoints' => WhyUsPoint::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'counters' => HomepageCounter::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'clients' => ClientLogo::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'testimonials' => $this->activeTestimonials()->limit(3)->get(),
            'blogs' => $this->publishedBlogs()->with('category')->limit(3)->get(),
            'faqCategories' => $this->homeFaqCategories(),
            'meta_description' => 'Tarama Engineering Concern delivers dependable engineering solutions backed by practical experience, quality workmanship and responsive service.',
        ];

        return $this->front_before_login_layout('Home', 'home', $data);
    }

    public function blogs(Request $request)
    {
        $query = $this->publishedBlogs()->with('category');

        if ($request->filled('q')) {
            $search = trim((string) $request->query('q'));
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', '%'.$search.'%')
                    ->orWhere('short_description', 'like', '%'.$search.'%')
                    ->orWhere('long_description', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('category')) {
            $category = (string) $request->query('category');
            $query->whereHas('category', fn ($builder) => $builder->where('slug', $category));
        }

        $data = [
            'blogs' => $query->paginate(6)->withQueryString(),
            'recentBlogs' => $this->publishedBlogs()->limit(5)->get(),
            'categories' => BlogCategory::where('status', 1)
                ->withCount(['blogs' => fn ($builder) => $builder
                    ->where('status', 1)
                    ->where(function ($query) {
                        $query->whereNull('publish_date')->orWhereDate('publish_date', '<=', today());
                    })])
                ->orderBy('name')
                ->get(),
            'meta_description' => 'Read engineering insights, company updates and practical industry articles from Tarama Engineering Concern.',
        ];

        return $this->front_before_login_layout('Blogs', 'blogs', $data);
    }

    public function blogDetails(string $slug)
    {
        $blog = $this->publishedBlogs()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        $data = [
            'blog' => $blog,
            'recentBlogs' => $this->publishedBlogs()->where('id', '!=', $blog->id)->limit(5)->get(),
            'categories' => BlogCategory::where('status', 1)
                ->withCount(['blogs' => fn ($builder) => $builder
                    ->where('status', 1)
                    ->where(function ($query) {
                        $query->whereNull('publish_date')->orWhereDate('publish_date', '<=', today());
                    })])
                ->orderBy('name')
                ->get(),
            'meta_title' => $blog->meta_title ?: $blog->title,
            'meta_description' => $blog->meta_description ?: strip_tags((string) $blog->short_description),
            'meta_keywords' => $blog->meta_keywords,
        ];

        return $this->front_before_login_layout($blog->title, 'blog-details', $data);
    }

    public function whoWeAre()
    {
        $data = [
            'about' => $this->aboutPage(),
            'whyChooseUs' => $this->whyChooseUsPage(),
            'whyChooseUsIntro' => $this->whyChooseUsIntro(),
            'whyUsPoints' => WhyUsPoint::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'counters' => HomepageCounter::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'meta_description' => 'Learn about Tarama Engineering Concern, our engineering approach and the reasons clients choose to work with us.',
        ];

        return $this->front_before_login_layout('Who We Are', 'who-we-are', $data);
    }

    public function clients()
    {
        $data = [
            'clients' => ClientLogo::where('status', 1)->orderBy('rank')->orderBy('id')->get(),
            'meta_description' => 'Explore the client relationships and industries served by Tarama Engineering Concern.',
        ];

        return $this->front_before_login_layout('Clients', 'clients', $data);
    }

    public function testimonials()
    {
        return $this->front_before_login_layout('Testimonials', 'testimonials', [
            'testimonials' => $this->activeTestimonials()->get(),
            'meta_description' => 'Read client testimonials and vendor feedback for Tarama Engineering Concern.',
        ]);
    }

    public function products(?string $slug = null)
    {
        $categories = Category::where('status', 1)
            ->withCount(['products' => fn ($query) => $query->where('status', 1)])
            ->orderBy('parent_id')
            ->orderBy('category_name')
            ->get();

        $selectedCategory = null;
        $products = Product::with('category')
            ->where('status', 1)
            ->whereHas('category', fn ($query) => $query->where('status', 1));

        if ($slug !== null) {
            $selectedCategory = $categories->firstWhere('slug', $slug);
            abort_unless($selectedCategory, 404);
            $products->where('main_category', $selectedCategory->id);
        }

        $pageTitle = $selectedCategory?->category_name ?: 'Products';

        return $this->front_before_login_layout($pageTitle, 'products', [
            'categories' => $categories,
            'products' => $products->orderByDesc('id')->paginate(12),
            'selectedCategory' => $selectedCategory,
            'meta_title' => $selectedCategory?->meta_title ?: $pageTitle,
            'meta_description' => $selectedCategory?->meta_description
                ?: $selectedCategory?->short_description
                ?: 'Explore products from Tarama Engineering Concern, arranged by category for quick and convenient browsing.',
            'meta_keywords' => $selectedCategory?->meta_keywords,
        ]);
    }

    public function career(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:250'],
                'email' => ['required', 'email', 'max:250'],
                'phone' => ['required', 'string', 'max:50'],
                'position' => ['required', 'string', 'max:250'],
                'experience' => ['nullable', 'string', 'max:100'],
                'message' => ['nullable', 'string', 'max:5000'],
                'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            ], [
                'resume.required' => 'Please attach your resume.',
                'resume.mimes' => 'The resume must be a PDF, DOC or DOCX file.',
                'resume.max' => 'The resume must not be larger than 5 MB.',
            ]);

            $validated['resume'] = $this->storeUpload($request, 'resume', 'career');
            $validated['status'] = 'NEW';
            CareerApplication::create($validated);

            return redirect()->route('career')
                ->with('success_message', 'Thank you. Your application has been submitted successfully.');
        }

        return $this->front_before_login_layout('Career', 'career', [
            'meta_description' => 'Explore career opportunities and submit your application to Tarama Engineering Concern.',
        ]);
    }

    public function page(string $slug)
    {
        $page = Page::where('page_slug', $slug)->where('status', 1)->firstOrFail();

        return $this->front_before_login_layout($page->page_name ?: 'Page', 'page-content', [
            'page' => $page,
            'meta_description' => strip_tags((string) $page->page_content),
        ]);
    }

    public function contactUs(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:250'],
                'email' => ['required', 'email', 'max:250'],
                'phone' => ['required', 'string', 'max:50'],
                'subject' => ['required', 'string', 'max:250'],
                'description' => ['required', 'string', 'max:5000'],
            ]);

            Enquiry::insert([
                ...$validated,
                'question_for' => '',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->sendContactNotification($validated);

            return redirect()->route('contact-us')
                ->with('success_message', 'Thank you. Your enquiry has been submitted successfully.');
        }

        return $this->front_before_login_layout('Contact Us', 'contact-us', [
            'meta_description' => 'Contact Tarama Engineering Concern to discuss your engineering requirements, service needs or project enquiry.',
        ]);
    }

    private function publishedBlogs()
    {
        return Blog::query()
            ->where('status', 1)
            ->where(function ($query) {
                $query->whereNull('publish_date')->orWhereDate('publish_date', '<=', today());
            })
            ->orderByDesc('publish_date')
            ->orderByDesc('id');
    }

    private function activeTestimonials()
    {
        return Testimonial::where('status', 1)
            ->orderByDesc('id');
    }

    private function aboutPage(): ?Page
    {
        return Page::where('page_slug', 'about-us')->where('status', 1)->first()
            ?? Page::whereKey(1)->where('status', 1)->first();
    }

    private function whyChooseUsPage(): ?Page
    {
        return Page::where('page_slug', 'why-choose-us')->where('status', 1)->first()
            ?? Page::whereKey(4)->where('status', 1)->first();
    }

    private function whyChooseUsIntro(): array
    {
        return [
            'Choosing the right manufacturing partner is critical to the success of your industrial projects. At Tarama Engineering Concern (TEC), we combine decades of ancestral engineering expertise with modern, certified manufacturing capabilities to deliver unmatched reliability and precision.',
            'Here is why industry leaders trust us with their critical infrastructure and heavy fabrication needs:',
        ];
    }

    private function homeFaqCategories()
    {
        return FaqCategory::where('status', 1)
            ->whereHas('faqs', fn ($query) => $query
                ->where('status', 1)
                ->where('is_home_page', 1))
            ->with(['faqs' => fn ($query) => $query
                ->where('status', 1)
                ->where('is_home_page', 1)
                ->orderBy('rank')
                ->orderBy('id')])
            ->orderBy('name')
            ->get();
    }

    private function sendContactNotification(array $enquiry): void
    {
        $settings = GeneralSetting::find(1);
        if (!$settings || !$settings->system_email) {
            return;
        }

        $message = $settings->email_template_contactus ?: implode('<br>', [
            '<strong>Name:</strong> {{name}}',
            '<strong>Email:</strong> {{email}}',
            '<strong>Phone:</strong> {{phone}}',
            '<strong>Subject:</strong> {{subject}}',
            '<strong>Message:</strong> {{description}}',
        ]);

        foreach ($enquiry as $key => $value) {
            $message = str_replace('{{'.$key.'}}', e($value), $message);
        }

        $subject = ($settings->site_name ?: 'Website').' - Contact enquiry from '.$enquiry['name'];

        EmailLog::insert([
            'name' => $enquiry['name'],
            'email' => $enquiry['email'],
            'subject' => $subject,
            'message' => $message,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            $this->sendMail($settings->system_email, $subject, $message);
        } catch (Throwable $exception) {
            Log::warning('Contact enquiry email could not be sent.', [
                'email' => $enquiry['email'],
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
