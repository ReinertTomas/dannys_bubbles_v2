<?php
declare(strict_types=1);

namespace App\Model\File;

use App\Model\Exception\Runtime\InvalidStateException;

final class DirectoryManager
{

    private string $app;

    private string $temp;

    private string $resources;

    private string $public;

    public function __construct(string $app)
    {
        $this->app = $app;
        $this->temp = $this->isValid($app . '/../temp');
        $this->resources = $this->isValid($app . '/resources');
        $this->public = $this->isValid($app . '/../www');
    }

    public function getApp(): string
    {
        return $this->app;
    }

    public function getTemp(): string
    {
        return $this->temp;
    }

    public function getResources(): string
    {
        return $this->resources;
    }

    public function getPublic(): string
    {
        return $this->public;
    }

    private function isValid(string $path): string
    {
        $realpath = realpath($path);
        if ($realpath === false) {
            throw InvalidStateException::create()
                ->withMessage('Invalid path to directory ' . $path);
        }
        return $realpath;
    }

}