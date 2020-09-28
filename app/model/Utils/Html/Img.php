<?php
declare(strict_types=1);

namespace App\Model\Utils\Html;

use Nette\Utils\Html;

class Img
{

    /** @var array<int, string> */
    private array $class;

    private string $src;

    private string $alt;

    public function __construct(string $src)
    {
        $this->class = [];
        $this->src = $src;
        $this->alt = 'Image';
    }

    public static function create(string $src): Img
    {
        return new Img($src);
    }

    public function setSizeExtraSmall(): Img
    {
        $this->class[] = 'img-xs';
        return $this;
    }

    public function setSizeSmall(): Img
    {
        $this->class[] = 'img-sm';
        return $this;
    }

    public function setSizeMedium(): Img
    {
        $this->class[] = 'img-md';
        return $this;
    }

    public function setSizeLarge(): Img
    {
        $this->class[] = 'img-lg';
        return $this;
    }

    public function setRoundedCircle(): Img
    {
        $this->class[] = 'rounded-circle';
        return $this;
    }

    public function setSource(string $src): Img
    {
        $this->src = $src;
        return $this;
    }

    public function setAlt(string $alt): Img
    {
        $this->alt = $alt;
        return $this;
    }

    public function toHtml(): Html
    {
        return Html::el('img')
            ->class(implode(' ', $this->class))
            ->src($this->src)
            ->alt($this->alt);
    }

}