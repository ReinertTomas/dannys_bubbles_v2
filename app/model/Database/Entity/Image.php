<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image extends AbstractImage
{

}