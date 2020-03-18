<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\IFile;
use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\THighlight;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product extends AbstractEntity implements IFile
{

    public const NAMESPACE = 'product';

    use TCreatedAt;
    use TUpdatedAt;
    use TActive;
    use THighlight;

    /**
     * @ORM\ManyToOne(targetEntity="File", cascade={"remove"})
     * @ORM\JoinColumn(nullable=FALSE)
     */
    protected File $image;

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

    public function __construct(File $image, string $title, string $description, string $text)
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->active = false;
        $this->highlight = false;
    }

    public function getImage(): File
    {
        return $this->image;
    }

    public function setImage(File $image): void
    {
        $this->image = $image;
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

    public function getNamespace(): string
    {
        return sprintf('/%s/%d', self::NAMESPACE, $this->id);
    }

}