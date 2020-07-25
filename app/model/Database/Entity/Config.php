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
    protected ?Document $documentShow;

    /**
     * @ORM\OneToOne(targetEntity="Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=TRUE)
     */
    protected ?Document $documentBusiness;

    /**
     * @ORM\OneToOne(targetEntity="Document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=TRUE)
     */
    protected ?Document $documentPersonal;

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

    public function getDocumentShow(): ?Document
    {
        return $this->documentShow;
    }

    public function changeDocumentShow(FileInfoInterface $file): void
    {
        if ($this->documentShow === null) {
            $this->documentShow = new Document($file, self::NAMESPACE);
        } else {
            $this->documentShow->update($file);
        }
    }

    public function hasDocumentShow(): bool
    {
        return $this->documentShow !== null;
    }

    public function getDocumentBusiness(): ?Document
    {
        return $this->documentBusiness;
    }

    public function changeDocumentBusiness(FileInfoInterface $file): void
    {
        if ($this->documentBusiness === null) {
            $this->documentBusiness = new Document($file, self::NAMESPACE);
        } else {
            $this->documentBusiness->update($file);
        }
    }

    public function hasDocumentBusiness(): bool
    {
        return $this->documentShow !== null;
    }

    public function getDocumentPersonal(): ?Document
    {
        return $this->documentPersonal;
    }

    public function changeDocumentPersonal(FileInfoInterface $file): void
    {
        if ($this->documentPersonal === null) {
            $this->documentPersonal = new Document($file, self::NAMESPACE);
        } else {
            $this->documentPersonal->update($file);
        }
    }

    public function hasDocumentPersonal(): bool
    {
        return $this->documentShow !== null;
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

    public function getFullname(): string
    {
        return $this->name . ' ' . $this->surname;
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