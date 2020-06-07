<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Exception\Runtime\InvalidStateException;
use App\Model\File\FileInfoInterface;
use App\Model\Utils\FileSystem;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractFile
{

    protected const DIR_FILES = '/files';

    use TId;
    use TCreatedAt;
    use TUpdatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $path;

    /**
     * @ORM\Column(type="string", length=16)
     */
    protected string $extension;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $size;

    protected ?FileInfoInterface $file = null;

    protected ?string $namespace = null;

    public function __construct(FileInfoInterface $file, string $namespace)
    {
        $this->file = $file;
        $this->namespace = $namespace;
    }

    public function update(FileInfoInterface $file): void
    {
        $oldPath = null;
        if ($file->getExtension() !== $this->extension) {
            $oldPath = $this->getPathAbsolute();
            $this->path = str_replace('.' . $this->extension, '.' . $file->getExtension(), $this->path);
        }
        $this->name = $file->getName();
        $this->extension = $file->getExtension();
        $this->size = $file->getSize();
        $this->file = null;
        // Overwrite file
        FileSystem::rename($file->getPathname(), $this->getPathAbsolute());
        // Remove file when extension change
        if ($oldPath !== null) {
            FileSystem::delete($oldPath);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getPathAbsolute(): string
    {
        return $this->getDirectoryPublic() . $this->getPathWeb();
    }

    public function getPathWeb(): string
    {
        return self::DIR_FILES . $this->path;
    }

    public function getNamespace(): ?string
    {
        $str = dirname($this->path);
        if (substr($str, 1) === '') {
            return null;
        }
        return $str;
    }

    protected function getDirectoryPublic(): string
    {
        $path = realpath(__DIR__ . '/../../../../www');
        if ($path === false) {
            throw InvalidStateException::create()
                ->withMessage('Invalid path to public directory ' . $path);
        }
        return $path;
    }

    protected function hasFile(): bool
    {
        return $this->file !== null;
    }

    /**
     * @internal
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preFile(): void
    {
        if ($this->hasFile()) {
            $this->path = $this->namespace . '/' . $this->file->getFilename();
            $this->name = $this->file->getName();
            $this->extension = $this->file->getExtension();
            $this->size = $this->file->getSize();
        }
    }

    /**
     * @internal
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postFile(): void
    {
        if ($this->hasFile()) {
            FileSystem::rename($this->file->getPathname(), $this->getPathAbsolute());
        }
        $this->file = null;
    }

    /**
     * @internal
     * @ORM\PreRemove()
     */
    public function preRemoveFile(): void
    {
    }

    /**
     * @internal
     * @ORM\PostRemove()
     */
    public function postRemoveFile(): void
    {
        $path = realpath($this->getPathAbsolute());
        if ($path !== false) {
            unlink($path);
        }
    }

}