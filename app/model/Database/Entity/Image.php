<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\File\FileInfo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image extends File
{

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $primary;

    public function __construct(FileInfo $file, int $type)
    {
        parent::__construct($file, $type);
        $this->primary = false;
    }

    public function isPrimary(): bool
    {
        return $this->primary;
    }

    public function setPrimary(): void
    {
        $this->primary = true;
    }

    public function unsetPrimary(): void
    {
        $this->primary = false;
    }

}