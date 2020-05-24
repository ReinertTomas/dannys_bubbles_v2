<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait TSort
{

    /**
     * @ORM\Column(type="smallint")
     */
    protected int $sort;

    public function getSort(): int
    {
        return $this->sort;
    }

}