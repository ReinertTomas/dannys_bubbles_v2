<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\THighlight;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{

    public const NAMESPACE = 'product';

    use TId;
    use TCreatedAt;
    use TUpdatedAt;
    use TActive;
    use THighlight;

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

    public function __construct(string $title, string $description, string $text)
    {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->active = false;
        $this->highlight = false;
    }

    public static function create(string $title, string $description, string $text): Product
    {
        return new Product($title, $description, $text);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

}