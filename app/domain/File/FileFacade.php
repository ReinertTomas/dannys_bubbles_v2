<?php
declare(strict_types=1);

namespace App\Domain\File;

use App\Model\Database\Entity\File;
use App\Model\Database\EntityManager;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\File\DirectoryManager;
use App\Model\File\PathBuilder;
use App\Model\File\PathBuilderInterface;
use App\Model\Utils\FileSystem;
use App\Model\Utils\Image;
use Nette\Http\FileUpload;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

class FileFacade
{

    private EntityManager $em;

    private DirectoryManager $dm;

    public function __construct(EntityManager $em, DirectoryManager $dm)
    {
        $this->em = $em;
        $this->dm = $dm;
    }

    public function createFromHttp(FileUpload $fileUpload, string $namespace): File
    {
        $pb = $this->createPathBuilder($fileUpload->getName(), $namespace);
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

    /**
     * @param string $json
     * @param string $namespace
     * @return File[]
     */
    public function createFromDropzone(string $json, string $namespace): array
    {
        try {
            $items = Json::decode($json, Json::FORCE_ARRAY);
        } catch (JsonException $e) {
            throw InvalidArgumentException::create($json);
        }

        $files = [];

        foreach ($items as $item) {
            $oldPb = $this->dm->findInUpload($item['filename']);
            $newPb = $this->dm->createInFiles($item['filename'], $namespace);
            $mime = FileSystem::mime($oldPb->getPathAbs());

            $file = new File(
                $item['name'],
                $newPb->getPath(),
                $mime
            );

            $this->dm->move($oldPb, $newPb);

            if (FileSystem::isImage($newPb->getPathAbs())) {
                $file->image();
                $this->createThumb($file);
            }

            $this->em->persist($file);
            $this->em->flush();

            $files[] = $file;
        }

        return $files;
    }

    public function update(File $file, FileUpload $fileUpload, string $namespace): File
    {
        if ($fileUpload->isOk()) {
            $pb = $this->createPathBuilder($fileUpload->getName(), $namespace);
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

    private function createPathBuilder(string $name, string $namespace): PathBuilderInterface
    {
        $extension = FileSystem::extension($name);
        $filename = FileSystem::generateName($extension);
        return $this->dm->createInFiles($filename, $namespace);
    }

}