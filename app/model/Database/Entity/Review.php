<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\File\FileInfoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ReviewRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Review
{

    public const NAMESPACE = '/review';

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
     * @ORM\Column(type="string", length=64, nullable=TRUE)
     */
    protected ?string $author;

    public function __construct(Image $image, string $title, string $text, ?string $author)
    {
        $this->image = $image;
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->active = false;

        $this->resizeImage();
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function changeImage(FileInfoInterface $file): void
    {
        $this->image->update($file);
        $this->resizeImage();
    }

    private function resizeImage(): void
    {
        $this->image->resize(200, 200);
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function changeAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function hasAuthor(): bool
    {
        return $this->author !== null;
    }

}