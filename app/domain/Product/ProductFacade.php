<?php
declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\File\FileFacade;
use App\Model\Database\Entity\Product;
use App\Model\Database\EntityManager;
use App\Model\Exception\Runtime\InvalidStateException;
use Nette\Http\FileUpload;

class ProductFacade
{

    private EntityManager $em;

    private FileFacade $fileFacade;

    public function __construct(EntityManager $em, FileFacade $fileFacade)
    {
        $this->em = $em;
        $this->fileFacade = $fileFacade;
    }

    public function create(string $title, string $description, string $text, FileUpload $fileUpload): Product
    {
        $image = $this->fileFacade->createFromHttp($fileUpload, Product::NAMESPACE);

        $product = new Product(
            $image,
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
        if ($fileUpload->hasFile()) {
            $this->fileFacade->update($product->getImage(), $fileUpload, $product->getNamespace());
        }

        $product->setTitle($title);
        $product->setDescription($description);
        $product->setText($text);
        $this->em->flush();

        return $product;
    }

    public function remove(Product $product): void
    {
        $this->fileFacade->purge($product->getImage());

        $this->em->remove($product);
        $this->em->flush();
    }

    public function toggleHighlight(Product $product): Product
    {
        if (!$product->isHighlight()) {
            $highlights = $this->em->getProductRepository()
                ->findByHighlighted();

            if (count($highlights) > 3) {
                throw InvalidStateException::create('Only 4 products can by highlighted.');
            }
        }

        $product->toggleHighlight();
        $this->em->flush();

        return $product;
    }

}