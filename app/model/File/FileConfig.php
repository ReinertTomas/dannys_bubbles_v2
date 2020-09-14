<?php
declare(strict_types=1);

namespace App\Model\File;

class FileConfig
{

    protected string $publicPath;

    public function __construct()
    {
        $this->publicPath = '/uploads/$type/';
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

}