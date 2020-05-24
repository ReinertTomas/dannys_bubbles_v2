<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TCreatedAt
{
    /**
     * @ORM\Column(type="datetime", nullable=FALSE)
     */
    protected DateTime $createdAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @internal
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }
}