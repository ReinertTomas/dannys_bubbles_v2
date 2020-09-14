<?php
declare(strict_types=1);

namespace App\Model\Html;

interface IElement
{

    public function getText(): string;

    public function getBg(): string;

    public function getIcon(): string;

}