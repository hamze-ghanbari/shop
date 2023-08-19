<?php

namespace App\Http\Services\Upload\Algoritms;

use App\Http\Services\Image\ImageService;

class File implements \App\Http\Services\Upload\UploadInterface
{
    public function __construct(
    public ImageService $imageService,
    public $image
    ){}

    public function upload(): string
    {
        return $this->imageService->save($this->image);
    }

}
