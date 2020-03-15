<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;


use App\Model\Database\Entity\Attributes\IFile;
use App\Model\Database\Entity\Attributes\TActive;
use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\AlbumRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Album extends AbstractEntity implements IFile
{

    public const NAMESPACE = 'album';

    use TCreatedAt;
    use TUpdatedAt;
    use TActive;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $title;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected string $text;

    /**
     * @var Collection<int, File>
     * @ORM\ManyToMany(targetEntity="File")
     * @ORM\JoinTable(name="album_has_file",
     *     joinColumns={@ORM\JoinColumn(name="album_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")}
     * )
     */
    protected Collection $images;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
        $this->active = false;
        $this->images = new ArrayCollection();
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
     * @return Collection<int, File>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(File $image): void
    {
        $this->images[] = $image;
    }

    public function removeImage(File $image): void
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

    public function hasImages(): bool
    {
        return !$this->images->isEmpty();
    }

    public function getImageFirst(): ?File
    {
        return $this->images->isEmpty() ? null : $this->images->first();
    }

    public function getNamespace(): string
    {
        return sprintf('/%s/%d', self::NAMESPACE, $this->getId());
    }

}