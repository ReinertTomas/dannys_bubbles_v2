<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\INamespace;
use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\AlbumRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Album implements INamespace
{

    public const NAMESPACE = 'album';

    use TId;
    use TCreatedAt;
    use TUpdatedAt;
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
     * @var Collection<int, AlbumHasImage>|AlbumHasImage[]
     * @ORM\OneToMany(targetEntity="AlbumHasImage", mappedBy="album")
     */
    protected Collection $images;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
        $this->active = false;
        $this->images = new ArrayCollection();
    }

    public static function create(string $title, string $text): Album
    {
        return new Album($title, $text);
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

    /**
     * @return AlbumHasImage[]
     */
    public function getImages(): array
    {
        return $this->images->toArray();
    }

    public function getImageFirst(): ?AlbumHasImage
    {
        if ($this->images->isEmpty()) {
            return null;
        }
        $image = $this->images->first();
        return $image !== false
            ? $image : null;
    }

    public function addImage(AlbumHasImage $image): void
    {
        $this->images->add($image);
    }

    public function removeImage(AlbumHasImage $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function getCover(): ?AlbumHasImage
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
        foreach ($this->images as $albumHasImage) {
            $albumHasImage->setUncover();
        }
    }

    public function getNamespace(): string
    {
        return sprintf('/%s/%d', self::NAMESPACE, $this->getId());
    }

}