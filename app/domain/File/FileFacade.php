<?php
declare(strict_types=1);

namespace App\Domain\File;

use App\Model\Database\Entity\File;
use App\Model\Database\EntityManager;
use App\Model\File\DirectoryManager;
use App\Model\File\PathBuilder;
use App\Model\File\PathBuilderInterface;
use App\Model\Utils\FileSystem;
use App\Model\Utils\Image;
use Nette\Http\FileUpload;

class FileFacade
{

    private EntityManager $em;

    private DirectoryManager $dm;

    public function __construct(EntityManager $em, DirectoryManager $dm)
    {
        $this->em = $em;
        $this->dm = $dm;
    }

    public function create(FileUpload $fileUpload, string $namespace): File
    {
        $pb = $this->createPathBuilder($fileUpload, $namespace);
        $fileUpload->move($pb->getPathAbs());

        $file = new File(
            $fileUpload->getName(),
            $pb->getPath(),
            $fileUpload->getContentType()
        );

        if ($fileUpload->isImage()) {
            $file->image();
            $this->createThumb($file);
        }

        $this->em->persist($file);
        $this->em->flush();

        return $file;
    }

    public function update(File $file, FileUpload $fileUpload, string $namespace): File
    {
        if ($fileUpload->isOk()) {
            $pb = $this->createPathBuilder($fileUpload, $namespace);
            $fileUpload->move($pb->getPathAbs());

            // Purge old
            $this->purge($file);

            $file->setName($fileUpload->getName());
            $file->setPath($pb->getPath());

            $this->em->flush();
        }

        return $file;
    }

    public function purge(File $file): void
    {
        if ($file->isImage()) {
            FileSystem::delete(
                PathBuilder::create($this->dm->getWWW())
                    ->addSuffix($file->getThumb())
                    ->getPathAbs()
            );
        }
        FileSystem::delete(
            PathBuilder::create($this->dm->getWWW())
                ->addSuffix($file->getPath())
                ->getPathAbs()
        );
    }

    private function createThumb(File $file): void
    {
        $pbImage = PathBuilder::create($this->dm->getWWW())
            ->addSuffix($file->getPath());
        $pbThumb = PathBuilder::create($this->dm->getWWW())
            ->addSuffix($file->getThumb());

        $image = Image::fromFile($pbImage->getPathAbs());
        $image->resize(100, 100, Image::EXACT);
        $image->sharpen();
        $image->save($pbThumb->getPathAbs(), 80, Image::JPEG);
    }

    private function createPathBuilder(FileUpload $fileUpload, string $namespace): PathBuilderInterface
    {
        $extension = FileSystem::extension($fileUpload->getName());
        $filename = FileSystem::generateName($extension);
        return $this->dm->createInFiles($filename, $namespace);
    }

}