<?php
namespace App\Repositories;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class ImageRepository
{
    public function store($request)
    {
        // Save image
        $path = Storage::disk('images')->put('', $request->file('image'));
        // Save thumb
        $image = InterventionImage::make($request->file('image'))->widen(500);
        Storage::disk('thumbs')->put($path, $image->encode());
        // Save in base
        $image = new Image;
        $image->description = $request->description;
        $image->category_id = $request->category_id;
        $image->name = $path;
        $image->user_id = auth()->id();
        $image->save();
    }

    public function getImagesForCategory($slug)
    {
        return Image::latestWithUser()->whereHas('category', function ($query) use ($slug) {
            $query->whereSlug($slug);
        })->paginate(config('app.pagination'));
    }
}