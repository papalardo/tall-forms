<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RichTextMediaUploadController extends Controller
{
    public function upload(Request $request)
    {
        // get image from request and check validity
        $temporaryFile = $request->file('image');
        if (!$temporaryFile->isFile() || !in_array($temporaryFile->getMimeType(), ['image/png', 'image/jpeg', 'image/gif', 'image/svg+xml'])) {
            return response([
                'message' => 'Tipo de arquivo não suportado',
                'success' => false
            ], 400);
        }

        // generate path that it will be saved to
        // $savedPath = Config::get('wysiwyg-media.media_folder') . '/' . time() . $temporaryFile->getClientOriginalName();
        $savedPath = $temporaryFile->storeAs('rich-text', $temporaryFile->getClientOriginalName(), 'images');

        // create directory in which we will be uploading into
        // if (!File::isDirectory(Config::get('wysiwyg-media.media_folder'))) {
        //     File::makeDirectory(Config::get('wysiwyg-media.media_folder'), 0755, true);
        // }
      
        // resize and save image
        // Image::make($temporaryFile->path())
        //     ->resize(Config::get('wysiwyg-media.maximum_image_width'), null, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })
        //     ->save($savedPath);

        // optimize image
        // OptimizerChainFactory::create()->optimize($savedPath);

        // create related model
        // $wysiwygMedia = WysiwygMedia::create(['file_path' => $savedPath]);

        // return image's path to use in wysiwyg
        return response()->json([
            'file' => Storage::disk('images')->url($savedPath),
            // 'mediaId' => $wysiwygMedia->id,
            'success' => true
        ]);
    }
}
