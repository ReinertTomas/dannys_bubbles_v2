<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\File\FileInfoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\OfferRepository")
 */
class Offer
{

    use TId;
    use TActive;

    public const NAMESPACE = '/offer';

    /**
     * @ORM\ManyToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=FALSE)
     */
    protected Image $image;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $text;

    public function __construct(Image $image, string $title, string $text)
    {
        $this->image = $image;
        $this->title = $title;
        $this->text = $text;
        $this->active = false;
    }

    public static function create(Image $image, string $title, string $text): Offer
    {
        return new Offer($image, $title, $text);
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function changeImage(FileInfoInterface $file): void
    {
        $this->image->update($file);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function changeText(string $text): void
    {
        $this->text = $text;
    }

}