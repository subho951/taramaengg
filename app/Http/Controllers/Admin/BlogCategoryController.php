<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    private array $module = [
        'title' => 'Blog Category',
        'controller_route' => 'blog-category',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Blog Categories', 'blog-category.list', [
            'module' => $this->module,
            'rows' => BlogCategory::where('status', '!=', 3)->orderBy('name')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new BlogCategory(), 'Add Blog Category');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, BlogCategory::findOrFail((int) Helper::decoded($id)), 'Edit Blog Category');
    }

    private function form(Request $request, BlogCategory $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:250', Rule::unique('blog_categories')->ignore($row->id)],
                'description' => ['nullable', 'string'],
            ]);

            $row->fill($validated);
            $row->slug = Helper::clean($validated['name']);
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/blog-category/list')->with('success_message', 'Blog category saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'blog-category.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
        ]);
    }

    public function delete(string $id)
    {
        $category = BlogCategory::findOrFail((int) Helper::decoded($id));
        if ($category->blogs()->where('status', '!=', 3)->exists()) {
            return back()->with('error_message', 'Move or delete the posts in this category first.');
        }

        $category->update(['status' => 3]);

        return back()->with('success_message', 'Blog category deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = BlogCategory::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Blog category status updated successfully.');
    }
}
