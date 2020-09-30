<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\File\FileInfo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\OfferRepository")
 */
class Offer
{

    use TId;
    use TActive;

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
    protected string $description;

    /**
     * @ORM\Column(type="text")
     */
    protected string $text;

    public function __construct(Image $image, string $title, string $description, string $text)
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->active = false;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function changeImage(FileInfo $file): void
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
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