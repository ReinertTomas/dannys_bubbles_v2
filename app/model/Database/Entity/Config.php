<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\File\FileInfoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ConfigRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Config
{

    public const NAMESPACE = '/config';

    use TId;
    use TUpdatedAt;

    /**
     * @ORM\OneToOne(targetEntity="Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=TRUE)
     */
    protected ?Document $condition;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $surname;

    /**
     * @ORM\Column(type="string", length=16)
     */
    protected string $ico;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $website;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $facebook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $instagram;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $youtube;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $promoVideo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $promoImage;

    public function getCondition(): ?Document
    {
        return $this->condition;
    }

    public function changeCondition(FileInfoInterface $file): void
    {
        if ($this->condition === null) {
            $this->condition = Document::create($file, self::NAMESPACE);
        } else {
            $this->condition->update($file);
        }
    }

    public function hasCondition(): bool
    {
        return $this->condition !== null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getIco(): string
    {
        return $this->ico;
    }

    public function setIco(string $ico): void
    {
        $this->ico = $ico;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getWebsite(): string
    {
        return $this->website;
    }

    public function setWebsite(string $website): void
    {
        $this->website = $website;
    }

    public function getFacebook(): string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getInstagram(): string
    {
        return $this->instagram;
    }

    public function setInstagram(string $instagram): void
    {
        $this->instagram = $instagram;
    }

    public function getYoutube(): string
    {
        return $this->youtube;
    }

    public function setYoutube(string $youtube): void
    {
        $this->youtube = $youtube;
    }

    public function getPromoVideo(): string
    {
        return $this->promoVideo;
    }

    public function setPromoVideo(string $promoVideo): void
    {
        $this->promoVideo = $promoVideo;
    }

    public function getPromoImage(): string
    {
        return $this->promoImage;
    }

    public function setPromoImage(string $promoImage): void
    {
        $this->promoImage = $promoImage;
    }

}