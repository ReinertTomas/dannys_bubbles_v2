<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait THighlight
{

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $highlight;

    public function isHighlight(): bool
    {
        return $this->highlight;
    }

    public function onHighlight(): void
    {
        $this->highlight = true;
    }

    public function offHighlight(): void
    {
        $this->highlight = false;
    }

    public function toggleHighlight(): void
    {
        $this->highlight = !$this->highlight;
    }

}