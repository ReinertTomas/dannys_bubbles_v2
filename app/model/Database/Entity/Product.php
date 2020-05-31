<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\INamespace;
use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\THighlight;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product implements INamespace
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

    /**
     * @var Collection<int, ProductHasImage>|ProductHasImage[]
     * @ORM\OneToMany(targetEntity="ProductHasImage", mappedBy="product")
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    protected Collection $images;

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

    /**
     * @return ProductHasImage[]
     */
    public function getImages(): array
    {
        return $this->images->toArray();
    }

    public function getImageFirst(): ?ProductHasImage
    {
        if ($this->images->isEmpty()) {
            return null;
        }
        $image = $this->images->first();
        return $image !== false
            ? $image : null;
    }

    public function addImage(ProductHasImage $image): void
    {
        $this->images->add($image);
    }

    public function removeImage(ProductHasImage $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function getCover(): ?ProductHasImage
    {
        if ($this->images->isEmpty()) {
            return null;
        }

        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('cover', true));
        $image = $this->images
            ->matching($criteria)
            ->first();

        return $image !== false
            ? $image : null;
    }

    public function resetCover(): void
    {
        foreach ($this->images as $productHasImage) {
            $productHasImage->setUncover();
        }
    }

    public function getNamespace(): string
    {
        return sprintf('/%s/%d', self::NAMESPACE, $this->id);
    }

}