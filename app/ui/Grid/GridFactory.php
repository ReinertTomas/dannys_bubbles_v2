<?php
declare(strict_types=1);

namespace App\UI\Grid;

use App\Model\File\DirectoryManager;
use Nette\ComponentModel\IContainer;
use Ublaboo\DataGrid\DataGrid;

final class GridFactory
{

    private DirectoryManager $dm;

    public function __construct(DirectoryManager $dm)
    {
        $this->dm = $dm;
    }

    public function create(IContainer $parent, string $name): DataGrid
    {
        $grid = new DataGrid($parent, $name);
        $grid->setTemplateFile($this->getTemplate());

        return $grid;
    }

    private function getTemplate(): string
    {
        return $this->dm->getResources() . '/Grid/template.latte';
    }

}