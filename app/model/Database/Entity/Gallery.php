<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TId;
use App\Model\File\FileInfoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\GalleryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Gallery extends AbstractImage
{

    private const NAMESPACE = '/gallery';

    use TId;

    public function __construct(FileInfoInterface $file)
    {
        parent::__construct($file, self::NAMESPACE);
        $this->makeThumb = true;
    }

}