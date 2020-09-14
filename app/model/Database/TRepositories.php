<?php
declare(strict_types=1);

namespace App\Model\Database;

use App\Model\Database\Entity\Album;
use App\Model\Database\Entity\AlbumHasImage;
use App\Model\Database\Entity\Config;
use App\Model\Database\Entity\Document;
use App\Model\Database\Entity\Gallery;
use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Offer;
use App\Model\Database\Entity\Product;
use App\Model\Database\Entity\ProductHasImage;
use App\Model\Database\Entity\Review;
use App\Model\Database\Entity\User;
use App\Model\Database\Repository\AlbumHasImageRepository;
use App\Model\Database\Repository\AlbumRepository;
use App\Model\Database\Repository\ConfigRepository;
use App\Model\Database\Repository\DocumentRepository;
use App\Model\Database\Repository\GalleryRepository;
use App\Model\Database\Repository\ImageRepository;
use App\Model\Database\Repository\OfferRepository;
use App\Model\Database\Repository\ProductHasImageRepository;
use App\Model\Database\Repository\ProductRepository;
use App\Model\Database\Repository\ReviewRepository;
use App\Model\Database\Repository\UserRepository;

/**
 * @mixin EntityManager
 */
trait TRepositories
{

    public function getUserRepository(): UserRepository
    {
        return $this->getRepository(User::class);
    }

    public function getDocumentRepository(): DocumentRepository
    {
        return $this->getRepository(Document::class);
    }

    public function getImageRepository(): ImageRepository
    {
        return $this->getRepository(Image::class);
    }

    public function getOfferRepository(): OfferRepository
    {
        return $this->getRepository(Offer::class);
    }

    public function getReviewRepository(): ReviewRepository
    {
        return $this->getRepository(Review::class);
    }

    public function getAlbumRepository(): AlbumRepository
    {
        return $this->getRepository(Album::class);
    }

    public function getAlbumHasImageRepository(): AlbumHasImageRepository
    {
        return $this->getRepository(AlbumHasImage::class);
    }

    public function getProductRepository(): ProductRepository
    {
        return $this->getRepository(Product::class);
    }

    public function getProductHasImageRepository(): ProductHasImageRepository
    {
        return $this->getRepository(ProductHasImage::class);
    }

    public function getConfigRepository(): ConfigRepository
    {
        return $this->getRepository(Config::class);
    }

    public function getGalleryRepository(): GalleryRepository
    {
        return $this->getRepository(Gallery::class);
    }

}