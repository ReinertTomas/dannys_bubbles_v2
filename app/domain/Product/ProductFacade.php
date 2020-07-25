<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\Exception\HighlightException;
use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Product;
use App\Model\Database\Entity\ProductHasImage;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ProductHasImageRepository;
use App\Model\Database\Repository\ProductRepository;
use App\Model\Exception\Runtime\InvalidStateException;
use App\Model\File\FileInfoInterface;
use App\Model\File\FileTemporaryFactory;
use App\UI\Form\Product\ProductFormType;

class ProductFacade
{

    private EntityManager $em;

    private ProductRepository $productRepository;

    private ProductHasImageRepository $productHasImageRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->productRepository = $em->getProductRepository();
        $this->productHasImageRepository = $em->getProductHasImageRepository();
    }

    public function get(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function create(ProductFormType $formType): Product
    {
        $product = Product::create(
            $formType->title,
            $formType->description,
            $formType->text
        );

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function update(Product $product, ProductFormType $formType): Product
    {
        $product->setTitle($formType->title);
        $product->setDescription($formType->description);
        $product->setText($formType->text);
        $this->em->flush();

        return $product;
    }

    public function remove(Product $product): void
    {
        foreach ($product->getImages() as $productHasImage) {
            $this->em->remove($productHasImage);
            $this->em->remove($productHasImage->getImage());
        }
        $this->em->remove($product);
        $this->em->flush();
    }

    public function getImage(int $id): ?ProductHasImage
    {
        return $this->productHasImageRepository->find($id);
    }

    public function addImage(Product $product, FileInfoInterface $file): void
    {
        $image = new Image($file, $product->getNamespace());
        $productHasImage = ProductHasImage::create($product, $image);

        if (!$product->hasImages()) {
            $productHasImage->setCover();
        }
        $product->addImage($productHasImage);

        $this->em->persist($image);
        $this->em->persist($productHasImage);
        $this->em->flush();
    }

    public function removeImage(Product $product, ProductHasImage $productHasImage): void
    {
        $product->removeImage($productHasImage);
        if ($productHasImage->isCover() && $product->hasImages()) {
            $product
                ->getImageFirst()
                ->setCover();
        }

        $this->em->remove($productHasImage);
        $this->em->remove($productHasImage->getImage());
        $this->em->flush();
    }

    public function toggleHighlight(Product $product): Product
    {
        if (!$product->isHighlight()) {
            $count = $this->productRepository->getCountHighlighted();
            if ($count > 3) {
                throw InvalidStateException::create()
                    ->withMessage('Only 3 products can by highlighted.');
            }
        }

        $product->toggleHighlight();
        $this->em->flush();

        return $product;
    }

    public function changeActive(Product $product, bool $active): void
    {
        $active ? $product->enabled() : $product->disabled();
        $this->em->flush();
    }

    public function changeCover(Product $product, ProductHasImage $productHasImage): void
    {
        $product->resetCover();
        $productHasImage->setCover();
        $this->em->flush();
    }

    public function changeHighlight(Product $product, bool $highlight): void
    {
        $count = $this->productRepository->getCountHighlighted();
        if ($highlight) {
            $product->onHighlight();
            $count++;
        } else {
            $product->offHighlight();
            $count--;
        }

        if ($count > 3) {
            throw HighlightException::create()
                ->withMessage('Only 3 products can by highlighted.');
        }
        $this->em->flush();
    }

}