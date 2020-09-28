<?php
declare(strict_types=1);

namespace App\Model\Utils\Html;

use Nette\Utils\Html;

class Badge
{

    private Html $element;

    /** @var array<int, string> */
    private array $class;

    public function __construct()
    {
        $this->element = Html::el('span');
        $this->class = [];
        $this->class[] = 'badge';
        $this->class[] = 'badge-pill';
    }

    public static function create(): Badge
    {
        return new static();
    }

    public function setText(string $text): Badge
    {
        $this->element->setText($text);
        return $this;
    }

    public function setBg(string $bg): Badge
    {
        $this->class[] = "badge-{$bg}";
        return $this;
    }

    public function toHtml(): Html
    {
        return $this->element->class(implode(' ', $this->class));
    }

}