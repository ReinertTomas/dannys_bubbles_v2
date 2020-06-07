<?php
declare(strict_types=1);

namespace App\Model\File;

interface FileInfoInterface
{

    /**
     * Returns the file real name.
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the filename without any path information.
     * @return string
     */
    public function getFilename(): string;

    /**
     * Returns the path to the file, omitting the filename and any trailing slash.
     * @return string
     */
    public function getPath(): string;

    /**
     * Returns the path to the file.
     * @return string
     */
    public function getPathname(): string;

    /**
     * Returns the file extension.
     * @return string
     */
    public function getExtension(): string;

    /**
     * Returns file size.
     * @return int
     */
    public function getSize(): int;

    /**
     * Returns the MIME content type of an uploaded file.
     * @return string
     */
    public function getMime(): string;

    /**
     * @return bool
     */
    public function isImage(): bool;

}