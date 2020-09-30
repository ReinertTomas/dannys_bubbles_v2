<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\File\FileInfo;
use App\Model\Utils\Strings;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ReviewRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Review
{

    use TId;
    use TCreatedAt;
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
     * @ORM\Column(type="text")
     */
    protected string $text;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $authorName;

    /**
     * @ORM\Column(type="string", length=64, nullable=TRUE)
     */
    protected ?string $authorSurname;

    public function __construct(Image $image, string $title, string $text, string $authorName, ?string $authorSurname)
    {
        $this->image = $image;
        $this->title = $title;
        $this->text = $text;
        $this->active = false;
        $this->changeAuthor($authorName, $authorSurname);
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

    public function getText(): string
    {
        return $this->text;
    }

    public function changeText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthorFullname(): string
    {
        return $this->getAuthorName() . ' ' . $this->getAuthorSurname();
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getAuthorSurname(): ?string
    {
        return $this->authorSurname;
    }

    public function changeAuthor(string $name, ?string $surname): void
    {
        $this->authorName = Strings::firstUpper($name);
        $this->authorSurname = $surname !== null ? Strings::firstUpper($surname) : null;
    }

    public function isAuthorUpdated(string $name, ?string $surname): bool
    {
        return $name !== $this->authorName || $surname !== $this->authorSurname;
    }

}