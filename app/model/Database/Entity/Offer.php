<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\IFile;
use App\Model\Database\Entity\Attributes\TActive;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\OfferRepository")
 */
class Offer extends AbstractEntity implements IFile
{

    use TActive;

    public const NAMESPACE = 'offer';

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
    protected string $text;

    public function __construct(File $image, string $title, string $text)
    {
        $this->image = $image;
        $this->title = $title;
        $this->text = $text;
        $this->active = false;
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