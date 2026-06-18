<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Helper;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    use HandlesUploads;

    private array $module = [
        'title' => 'Product Category',
        'controller_route' => 'product-category',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Product Categories', 'product-category.list', [
            'module' => $this->module,
            'rows' => Category::with('parent')->where('status', '!=', 3)->orderBy('parent_id')->orderBy('category_name')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new Category(), 'Add Product Category');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, Category::findOrFail((int) Helper::decoded($id)), 'Edit Product Category');
    }

    private function form(Request $request, Category $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'parent_id' => ['nullable', 'integer'],
                'category_name' => ['required', 'string', 'max:250'],
                'short_description' => ['nullable', 'string'],
                'description' => ['nullable', 'string'],
                'cover_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
                'banner_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
                'meta_title' => ['nullable', 'string'],
                'meta_description' => ['nullable', 'string'],
                'meta_keywords' => ['nullable', 'string'],
            ]);

            $parentId = (int) ($validated['parent_id'] ?? 0);
            if ($row->exists && $parentId === (int) $row->id) {
                return back()->withInput()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
            }

            $coverImage = $this->storeUpload($request, 'cover_image', 'category');
            $bannerImage = $this->storeUpload($request, 'banner_image', 'category');

            $row->fill($validated);
            $row->parent_id = $parentId;
            $row->slug = Helper::clean($validated['category_name']);
            $row->cover_image = $coverImage ?? $row->cover_image;
            $row->banner_image = $bannerImage ?? $row->banner_image;
            $row->is_feature = $request->boolean('is_feature');
            $row->status = $row->exists ? $row->status : 1;
            $row->save();

            return redirect('admin/product-category/list')->with('success_message', 'Product category saved successfully.');
        }

        $parents = Category::where('status', 1)
            ->when($row->exists, fn ($query) => $query->where('id', '!=', $row->id))
            ->orderBy('category_name')
            ->get();

        echo $this->admin_after_login_layout($title, 'product-category.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
            'parents' => $parents,
        ]);
    }

    public function delete(string $id)
    {
        $categoryId = (int) Helper::decoded($id);

        if (Category::where('parent_id', $categoryId)->where('status', '!=', 3)->exists()) {
            return back()->with('error_message', 'Move or delete the child categories first.');
        }

        if (Product::where('main_category', $categoryId)->where('status', '!=', 3)->exists()) {
            return back()->with('error_message', 'Move or delete the products in this category first.');
        }

        Category::whereKey($categoryId)->update(['status' => 3]);

        return back()->with('success_message', 'Product category deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = Category::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Product category status updated successfully.');
    }
}
