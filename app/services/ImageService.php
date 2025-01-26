<?php
namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function storeImage($imageFile, $model) : Image
    {
        $path = $imageFile->store('images', 'public');

        $image = new Image([
            'filename' => basename($path),
            'path' => $path,
            'size' => $imageFile->getSize(),
            'mime_type' => $imageFile->getMimeType(),
        ]);

        $model->image()->save($image);

        return $image;
    }

    public static function updateImage($newImageFile, $model): Image
    {
        $existingImage = $model->image;

        if ($existingImage) {
            Storage::disk('public')->delete($existingImage->path);
            $existingImage->delete();
        }
        return self::storeImage($newImageFile, $model);
    }
}