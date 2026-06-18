<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $page = Page::where('page_slug', 'about-us')->first() ?? Page::find(1) ?? new Page();

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'page_name' => ['required', 'string', 'max:250'],
                'page_content' => ['required', 'string'],
                'page_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
                'page_banner_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
            ]);

            $pageImage = $this->storeUpload($request, 'page_image', 'page');
            $bannerImage = $this->storeUpload($request, 'page_banner_image', 'page');

            $page->page_name = $validated['page_name'];
            $page->page_slug = 'about-us';
            $page->page_content = $validated['page_content'];
            $page->page_image = $pageImage ?? $page->page_image;
            $page->page_banner_image = $bannerImage ?? $page->page_banner_image;
            $page->status = 1;
            $page->save();

            return redirect('admin/about-us')->with('success_message', 'About Us content updated successfully.');
        }

        echo $this->admin_after_login_layout('About Us', 'about-us.edit', compact('page'));
    }
}
