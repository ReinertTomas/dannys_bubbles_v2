<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;


use App\Model\Database\Entity\Attributes\TCover;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TSort;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\AlbumHasImageRepository")
 */
class AlbumHasImage
{

    use TId;
    use TSort;
    use TCover;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="images")
     */
    protected Album $album;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     */
    protected Image $image;

    public function __construct(Album $album, Image $image, int $sort)
    {
        $this->album = $album;
        $this->image = $image;
        $this->sort = $sort;
        $this->cover = false;
    }

    public static function create(Album $album, Image $image, int $sort = 0): AlbumHasImage
    {
        return new AlbumHasImage($album, $image, $sort);
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

}