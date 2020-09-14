<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\File\Exception\DirectoryNotFoundException;
use App\Model\File\FileConfig;
use App\Model\File\FileInfo;
use App\Model\Utils\FileSystem;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

abstract class File
{

    public const TYPE_USER = 1;
    public const TYPE_ALBUM = 2;
    public const TYPE_CONFIG = 3;
    public const TYPE_OFFER = 4;
    public const TYPE_PRODUCT = 5;
    public const TYPE_REVIEW = 6;

    public const TYPES = [
        self::TYPE_USER => 'user',
        self::TYPE_ALBUM => 'album',
        self::TYPE_CONFIG => 'config',
        self::TYPE_OFFER => 'offer',
        self::TYPE_PRODUCT => 'product',
        self::TYPE_REVIEW => 'review'
    ];

    use TId;
    use TCreatedAt;
    use TUpdatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $originalName;

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

    /**
     * @ORM\Column(type="smallint")
     */
    protected int $type;

    protected ?FileInfo $file = null;

    public function __construct(FileInfo $file, int $type)
    {
        if (!array_key_exists($type, self::TYPES)) {
            throw new InvalidArgumentException(sprintf('Unsupported type %d', $type));
        }

        $this->type = $type;
        $this->file = $file;
    }

    public function update(FileInfo $file): void
    {
        // When extension change
        if ($file->getExtension() !== $this->extension) {
            // Remove file
            FileSystem::delete($this->getPathAbsolute());
            $this->path = str_replace('.' . $this->extension, '.' . $file->getExtension(), $this->path);
        }

        $this->originalName = $file->getOriginalName();
        $this->extension = $file->getExtension();
        $this->size = $file->getSize();
        // Overwrite file
        FileSystem::rename($file->getPathname(), $this->getPathAbsolute());
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getPathAbsolute(): string
    {
        $path = realpath(__DIR__ . '/../../../../www');
        if ($path === false) {
            throw new DirectoryNotFoundException('Invalid path to public directory.');
        }
        return $path . $this->path;
    }

    public function getPathWeb(): string
    {
        return $this->path;
    }

    protected function hasFile(): bool
    {
        return $this->file !== null;
    }

    /**
     * @internal
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        if ($this->hasFile()) {
            $config = new FileConfig();
            $path = str_replace(['$type'], [self::TYPES[$this->type]], $config->getPublicPath());

            $this->path = $path . Uuid::uuid4()->toString() . '.' . $this->file->getExtension();
            $this->originalName = $this->file->getOriginalName();
            $this->extension = $this->file->getExtension();
            $this->size = $this->file->getSize();
        }
    }

    /**
     * @internal
     * @ORM\PostPersist()
     */
    public function postPersist(): void
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
    public function preRemove(): void
    {
    }

    /**
     * @internal
     * @ORM\PostRemove()
     */
    public function postRemove(): void
    {
        $path = realpath($this->getPathAbsolute());
        if ($path !== false) {
            unlink($path);
        }
    }

}