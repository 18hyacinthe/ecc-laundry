<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


trait ImageUploadTrait
{
    public function uploadImage(Request $request, $inputName, $path)
    {
        if ($request->hasFile($inputName)) {

            $image = $request->file($inputName);

            $extension = $image->getClientOriginalExtension();

            $imageName = 'profil_'.uniqid() . '.' . $extension;
            
            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
            
        }
    }

    public function updateImage(Request $request, $inputName, $path, $oldPath = null)
    {
        if ($request->hasFile($inputName)) {
            // Delete the old image if it exists
            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }

            // Upload the new image
            $image = $request->file($inputName);
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $extension;
            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }

        // Return the old path if no new image is uploaded
        return $oldPath;
    }
    public function deleteImage(string $path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}