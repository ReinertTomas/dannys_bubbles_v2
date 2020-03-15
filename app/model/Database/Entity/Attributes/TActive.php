<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait TActive
{

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function show(): void
    {
        $this->active = true;
    }

    public function hide(): void
    {
        $this->active = false;
    }

    public function toggleActive(): void
    {
        $this->active = !$this->active;
    }

}