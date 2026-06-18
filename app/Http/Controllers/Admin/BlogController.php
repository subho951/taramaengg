<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    use HandlesUploads;

    private array $module = [
        'title' => 'Blog / News Post',
        'controller_route' => 'blog',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Blogs / News', 'blog.list', [
            'module' => $this->module,
            'rows' => Blog::with('category')->where('status', '!=', 3)->orderByDesc('publish_date')->orderByDesc('id')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new Blog(), 'Add Blog / News Post');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, Blog::findOrFail((int) Helper::decoded($id)), 'Edit Blog / News Post');
    }

    private function form(Request $request, Blog $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'blog_category_id' => [
                    'required',
                    'integer',
                    Rule::exists('blog_categories', 'id')->where(fn ($query) => $query->where('status', 1)),
                ],
                'title' => ['required', 'string', 'max:250'],
                'blog_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg,ico', 'max:8192'],
                'short_description' => ['nullable', 'string'],
                'long_description' => ['required', 'string'],
                'publish_date' => ['required', 'date_format:Y-m-d'],
                'meta_title' => ['nullable', 'string'],
                'meta_description' => ['nullable', 'string'],
                'meta_keywords' => ['nullable', 'string'],
            ], [
                'blog_category_id.required' => 'Please select a blog category.',
                'blog_category_id.exists' => 'The selected blog category is not active.',
                'long_description.required' => 'Please enter the blog content.',
                'publish_date.date_format' => 'Please enter a valid publish date.',
                'blog_image.mimes' => 'The featured image must be a JPG, JPEG, PNG, WebP, SVG or ICO file.',
                'blog_image.max' => 'The featured image must not be larger than 8 MB.',
            ]);

            $image = $this->storeUpload($request, 'blog_image', 'blog');

            $row->fill($validated);
            $row->slug = Helper::clean($validated['title']);
            $row->blog_image = $image ?? $row->blog_image;
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/blog/list')->with('success_message', 'Blog / news post saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'blog.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
            'categories' => BlogCategory::where('status', 1)->orderBy('name')->get(),
        ]);
    }

    public function delete(string $id)
    {
        Blog::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return back()->with('success_message', 'Blog / news post deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = Blog::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Blog / news post status updated successfully.');
    }
}
