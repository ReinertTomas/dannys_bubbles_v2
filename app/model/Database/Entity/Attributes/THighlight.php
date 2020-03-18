<?php
declare(strict_types=1);

namespace App\Model\Database\Entity\Attributes;

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

    public function highlight(): void
    {
        $this->highlight = true;
    }

    public function unhighlight(): void
    {
        $this->highlight = false;
    }

    public function toggleHighlight(): void
    {
        $this->highlight = !$this->highlight;
    }

}