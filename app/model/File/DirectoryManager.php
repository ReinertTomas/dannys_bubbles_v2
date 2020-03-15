<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\Database\Entity\File;

final class DirectoryManager
{

    private string $app;

    private string $temp;

    private string $resources;

    private string $www;

    private string $upload;

    private string $files;

    public function __construct(string $app, string $upload, string $files)
    {
        $this->app = $app;
        $this->temp = PathBuilder::create($this->app)
            ->addSuffix('/../temp')
            ->exists()
            ->getPathAbs();
        $this->resources = PathBuilder::create($this->app)
            ->addSuffix('/resources')
            ->exists()
            ->getPathAbs();
        $this->www = PathBuilder::create($this->app)
            ->addSuffix('/../www')
            ->exists()
            ->getPathAbs();
        $this->upload = $upload;
        $this->files = $files;
    }

    public function getWWW(): string
    {
        return $this->www;
    }

    public function getUpload(): string
    {
        return PathBuilder::create($this->www)
            ->addSuffix($this->upload)
            ->exists()
            ->getPathAbs();
    }

    public function getFiles(): string
    {
        return PathBuilder::create($this->www)
            ->addSuffix($this->files)
            ->exists()
            ->getPathAbs();
    }

    public function findInUpload(string $filename): PathBuilderInterface
    {
        return PathBuilder::create($this->www)
            ->addSuffix($this->upload)
            ->addSuffix('/')
            ->addSuffix($filename)
            ->exists();
    }

    public function findInFiles(File $file): PathBuilderInterface
    {
        return PathBuilder::create($this->www)
            ->addSuffix($file->getPath())
            ->exists();
    }

    public function createInFiles(string $filename, string $namespace = null): PathBuilderInterface
    {
        $pb = PathBuilder::create($this->www)
            ->addSuffix($this->files);

        if ($namespace) {
            $pb->addSuffix('/')
                ->addSuffix($namespace)
                ->generatePath()
                ->exists();
        }

        return $pb->addSuffix('/')
            ->addSuffix($filename);
    }

    public function move(PathBuilderInterface $old, PathBuilderInterface $new): void
    {
        rename($old->getPathAbs(), $new->getPathAbs());
    }

}