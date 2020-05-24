<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\File\FileInfoInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\DocumentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Document extends AbstractFile
{

    public static function create(FileInfoInterface $file, string $namespace): Document
    {
        return new Document($file, $namespace);
    }

}