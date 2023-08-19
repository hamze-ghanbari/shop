<?php

namespace App\Http\Services\Upload;

class Upload
{

    public function __construct(
        public UploadInterface $upload
    )
    {
    }

    public function upload(): string
    {
        return $this->upload->upload();
    }
}
