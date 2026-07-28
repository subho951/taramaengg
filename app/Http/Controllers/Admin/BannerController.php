<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class BannerController extends Controller
{
    private array $module = [
        'title' => 'Banner',
        'controller' => 'BannerController',
        'controller_route' => 'banner',
        'primary_key' => 'id',
    ];

    public function list()
    {
        $rows = Banner::where('status', '!=', 3)->orderByDesc('id')->get();
        $contentSource = $rows
            ->where('status', 1)
            ->sortBy('id')
            ->first(fn (Banner $banner) => collect([
                $banner->heading1,
                $banner->heading2,
                $banner->banner_text,
                $banner->banner_text2,
            ])->contains(fn ($value) => filled($value)));

        echo $this->admin_after_login_layout('Banner List', 'banner.list', [
            'module' => $this->module,
            'rows' => $rows,
            'contentSourceId' => $contentSource?->id,
        ]);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                ...$this->contentRules(),
                'banner_images' => ['required', 'array', 'min:1', 'max:20'],
                'banner_images.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,svg,ico', 'max:10240'],
            ], $this->validationMessages());

            $content = $this->contentFields($validated);
            $uploadedCount = 0;

            foreach ($request->file('banner_images', []) as $image) {
                Banner::create([
                    ...$content,
                    'banner_image' => $this->storeBannerImage($image, 'banner_images'),
                ]);
                $uploadedCount++;
            }

            return redirect('admin/banner/list')->with(
                'success_message',
                $uploadedCount.' '.Str::plural('banner', $uploadedCount).' uploaded successfully.'
            );
        }

        echo $this->admin_after_login_layout('Banner Add', 'banner.add-edit', [
            'module' => $this->module,
            'row' => null,
        ]);
    }

    public function edit(Request $request, string $id)
    {
        $row = Banner::findOrFail((int) Helper::decoded($id));

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                ...$this->contentRules(),
                'banner_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg,ico', 'max:10240'],
            ], $this->validationMessages());

            $row->fill($this->contentFields($validated));

            if ($request->hasFile('banner_image')) {
                $row->banner_image = $this->storeBannerImage($request->file('banner_image'), 'banner_image');
            }

            $row->save();

            return redirect('admin/banner/list')->with('success_message', 'Banner updated successfully.');
        }

        echo $this->admin_after_login_layout('Banner Update', 'banner.add-edit', [
            'module' => $this->module,
            'row' => $row,
        ]);
    }

    public function delete(Request $request, string $id)
    {
        Banner::whereKey((int) Helper::decoded($id))->update(['status' => 3]);

        return redirect('admin/banner/list')->with('success_message', 'Banner deleted successfully.');
    }

    public function change_status(Request $request, string $id)
    {
        $banner = Banner::findOrFail((int) Helper::decoded($id));
        $banner->status = $banner->status == 1 ? 0 : 1;
        $banner->save();

        return redirect('admin/banner/list')->with(
            'success_message',
            'Banner '.($banner->status == 1 ? 'activated' : 'deactivated').' successfully.'
        );
    }

    private function contentRules(): array
    {
        return [
            'heading1' => ['nullable', 'string'],
            'heading2' => ['nullable', 'string'],
            'banner_text' => ['required', 'string'],
            'banner_text2' => ['required', 'string'],
            'banner_link' => ['nullable', 'string', 'max:250'],
        ];
    }

    private function validationMessages(): array
    {
        return [
            'banner_images.required' => 'Please select at least one banner image.',
            'banner_images.max' => 'You can upload up to 20 banner images at a time.',
            'banner_images.*.mimes' => 'Each banner must be a JPG, JPEG, PNG, WEBP, SVG or ICO image.',
            'banner_images.*.max' => 'Each banner image must not be larger than 10 MB.',
            'banner_image.mimes' => 'The banner must be a JPG, JPEG, PNG, WEBP, SVG or ICO image.',
            'banner_image.max' => 'The banner image must not be larger than 10 MB.',
        ];
    }

    private function contentFields(array $validated): array
    {
        return [
            'heading1' => $validated['heading1'] ?? null,
            'heading2' => $validated['heading2'] ?? null,
            'banner_text' => $validated['banner_text'],
            'banner_text2' => $validated['banner_text2'],
            'banner_link' => $validated['banner_link'] ?? null,
        ];
    }

    private function storeBannerImage(UploadedFile $image, string $errorField): string
    {
        $uploadDirectory = public_path('uploads/banner');

        if (! is_dir($uploadDirectory) && ! mkdir($uploadDirectory, 0775, true) && ! is_dir($uploadDirectory)) {
            throw ValidationException::withMessages([
                $errorField => 'The banner upload directory could not be created.',
            ]);
        }

        $extension = strtolower($image->getClientOriginalExtension());
        $filename = now()->format('YmdHisv').'_'.Str::random(12).($extension ? '.'.$extension : '');

        try {
            $image->move($uploadDirectory, $filename);
        } catch (Throwable $exception) {
            throw ValidationException::withMessages([
                $errorField => 'A banner image could not be uploaded.',
            ]);
        }

        return $filename;
    }
}
