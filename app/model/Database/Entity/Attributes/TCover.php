<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait TCover
{

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $cover;

    public function isCover(): bool
    {
        return $this->cover;
    }

    public function setCover(): void
    {
        $this->cover = true;
    }

    public function setUncover(): void
    {
        $this->cover = false;
    }

}