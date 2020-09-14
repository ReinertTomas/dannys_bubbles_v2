<?php
declare(strict_types=1);

namespace App\Model\Html;

abstract class Element implements IElement
{

    protected string $text;

    protected string $bg;

    protected string $icon;

    public function getText(): string
    {
        return $this->text;
    }

    public function getBg(): string
    {
        return "bg-{$this->bg}";
    }

    public function getIcon(): string
    {
        return "fa-{$this->icon}";
    }

}