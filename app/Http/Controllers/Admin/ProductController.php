<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Helper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use HandlesUploads;

    private array $module = [
        'title' => 'Product',
        'controller_route' => 'product',
    ];

    public function list()
    {
        echo $this->admin_after_login_layout('Products', 'product.list', [
            'module' => $this->module,
            'rows' => Product::with('category')->where('status', '!=', 3)->orderByDesc('id')->get(),
        ]);
    }

    public function add(Request $request)
    {
        return $this->form($request, new Product(), 'Add Product');
    }

    public function edit(Request $request, string $id)
    {
        return $this->form($request, Product::findOrFail((int) Helper::decoded($id)), 'Edit Product');
    }

    private function form(Request $request, Product $row, string $title)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:250'],
                'main_category' => ['required', 'integer', 'exists:categories,id'],
                'short_description' => ['required', 'string'],
                'cover_image' => [$row->exists ? 'nullable' : 'required', 'file', 'mimes:jpg,jpeg,png,svg,ico', 'max:4096'],
            ]);

            $coverImage = $this->storeUpload($request, 'cover_image', 'product');

            $row->name = $validated['name'];
            $row->main_category = $validated['main_category'];
            $row->short_description = $validated['short_description'];
            $row->product_nature = 'Physical';
            $row->sub_category = 0;
            $row->slug = Helper::clean($validated['name']);
            $row->cover_image = $coverImage ?? $row->cover_image;
            $row->status = $row->exists ? $row->status : 1;
            $row->created_by = $row->exists ? $row->created_by : (int) session('user_id');
            $row->updated_by = (int) session('user_id');
            $row->save();

            return redirect('admin/product/list')->with('success_message', 'Product saved successfully.');
        }

        echo $this->admin_after_login_layout($title, 'product.add-edit', [
            'module' => $this->module,
            'row' => $row->exists ? $row : null,
            'categories' => Category::where('status', 1)->orderBy('category_name')->get(),
        ]);
    }

    public function delete(string $id)
    {
        Product::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return back()->with('success_message', 'Product deleted successfully.');
    }

    public function changeStatus(string $id)
    {
        $row = Product::findOrFail((int) Helper::decoded($id));
        $row->status = $row->status == 1 ? 0 : 1;
        $row->save();

        return back()->with('success_message', 'Product status updated successfully.');
    }
}
