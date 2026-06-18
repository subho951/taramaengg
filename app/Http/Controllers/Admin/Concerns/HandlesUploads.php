<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

trait HandlesUploads
{
    protected function storeUpload(Request $request, string $field, string $directory): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $uploadDirectory = public_path('uploads/'.$directory);
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0775, true);
        }

        $file = $request->file($field);
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = time().'_'.Str::random(12).($extension ? '.'.$extension : '');

        try {
            $file->move($uploadDirectory, $filename);
        } catch (Throwable $exception) {
            throw ValidationException::withMessages([
                $field => 'The file could not be uploaded.',
            ]);
        }

        return $filename;
    }
}
