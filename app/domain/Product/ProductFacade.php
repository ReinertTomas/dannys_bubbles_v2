<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Product;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\InvalidStateException;
use App\Model\File\FileTemporaryFactory;
use Nette\Http\FileUpload;

class ProductFacade
{

    private EntityManager $em;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(EntityManager $em, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->em = $em;
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function get(int $id): ?Product
    {
        return $this->em
            ->getProductRepository()
            ->find($id);
    }

    public function create(string $title, string $description, string $text, FileUpload $fileUpload): Product
    {
//        $file = $this->fileTemporaryFactory->createFromUpload($fileUpload);

        $product = Product::create(
            $title,
            $description,
            $text
        );

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }

    public function update(Product $product, string $title, string $description, string $text, FileUpload $fileUpload): Product
    {
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setText($text);
        $this->em->flush();

        return $product;
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
        $this->em->flush();
    }

    public function toggleHighlight(Product $product): Product
    {
        if (!$product->isHighlight()) {
            $highlights = $this->em->getProductRepository()
                ->findByHighlighted();

            if (count($highlights) > 3) {
                throw InvalidStateException::create()
                    ->withMessage('Only 4 products can by highlighted.');
            }
        }

        $product->toggleHighlight();
        $this->em->flush();

        return $product;
    }

}