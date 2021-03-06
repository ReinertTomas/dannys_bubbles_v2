<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Exception\Runtime\InvalidStateException;
use App\Model\File\FileInfoInterface;
use App\Model\Utils\FileSystem;
use App\Model\Utils\Image as ImageUtils;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractImage extends AbstractFile
{

    public const BLANK_50x50 = '/img/blank_50x50.png';
    public const BLANK_150x150 = '/img/blank_150x150.png';
    public const BLANK_200x200 = '/img/blank_200x200.png';

    protected bool $makeThumb;

    /** @var array<int, int> */
    protected array $resize = [];

    public function __construct(FileInfoInterface $file, string $namespace, bool $makeThumb = true)
    {
        parent::__construct($file, $namespace);
        $this->makeThumb = $makeThumb;
    }

    public function update(FileInfoInterface $file): void
    {
        parent::update($file);
        // Overwrite thumb if there is old one
        if (realpath($this->getThumbAbsolute()) !== false) {
            $this->createThumb();
        }
    }

    public function resize(int $width, int $height): void
    {
        $this->resize = [$width, $height];
    }

    public function getThumbAbsolute(): string
    {
        return $this->getDirectoryPublic() . $this->getThumbWeb();
    }

    public function getThumbWeb(): string
    {
        return self::DIR_FILES . $this->getThumb();
    }

    protected function getThumb(): string
    {
        $position = strrpos($this->path, '.');
        if ($position === false) {
            throw InvalidStateException::create()
                ->withMessage('Invalid path format ' . $this->path);
        }
        $path = substr($this->path, 0, $position);
        return $path . '_thumb.' . $this->extension;
    }

    protected function createThumb(): void
    {
        $image = ImageUtils::fromFile($this->getPathAbsolute());
        $image->resize(200, 200, ImageUtils::EXACT);
        $image->sharpen();
        $image->save($this->getThumbAbsolute(), 80);
    }

    protected function makeResize(): void
    {
        list($width, $height) = $this->resize;
        $image = ImageUtils::fromFile($this->getPathAbsolute());
        $image->resize($width, $height, ImageUtils::EXACT);
        $image->sharpen();
        $image->save($this->getPathAbsolute(), 80);
    }

    /**
     * @internal
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function postFile(): void
    {
        // Move image
        if ($this->hasFile()) {
            FileSystem::rename($this->file->getPathname(), $this->getPathAbsolute());
            // Create thumb
            if ($this->makeThumb) {
                $this->createThumb();
            }
        }
        // Resize
        if ($this->resize !== []) {
            $this->makeResize();
        }
        $this->file = null;
    }

    /**
     * @internal
     * @ORM\PostRemove()
     */
    public function postRemoveFile(): void
    {
        parent::postRemoveFile();
        // Remove thumb
        $thumb = realpath($this->getThumbAbsolute());
        if ($thumb !== false) {
            FileSystem::delete($thumb);
        }
    }

}