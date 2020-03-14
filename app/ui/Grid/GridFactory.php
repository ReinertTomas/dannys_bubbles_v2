<?php
declare(strict_types=1);

namespace App\UI\Grid;

use Nette\ComponentModel\IContainer;
use Ublaboo\DataGrid\DataGrid;

final class GridFactory
{

    const ICON_EDIT = 'pencil-alt';

    public function create(IContainer $parent, string $name): DataGrid
    {
        return new DataGrid($parent, $name);
    }

}