<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ReviewRepository")
 */
class Review extends AbstractEntity
{

    use TActive;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $text;

    /**
     * @ORM\Column(type="string", length=64, nullable=TRUE)
     */
    protected ?string $author;

    public function __construct(string $title, string $text, ?string $author = null)
    {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->active = false;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function hasAuthor(): bool
    {
        return $this->author !== null;
    }

}