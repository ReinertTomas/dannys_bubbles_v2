<?php
declare(strict_types=1);

namespace App\UI\Grid\Product;

use App\Model\Database\EntityManager;
use App\Model\Element\Active;
use App\Model\Utils\DateTime;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Ublaboo\DataGrid\DataGrid;

final class ProductGridFactory
{

    private GridFactory $gridFactory;

    private EntityManager $em;

    private Active $active;

    public function __construct(GridFactory $gridFactory, EntityManager $em, Active $active)
    {
        $this->gridFactory = $gridFactory;
        $this->em = $em;
        $this->active = $active;
    }

    public function create(IContainer $container, string $name, callable $onChange): DataGrid
    {
        $disabled = $this->active->getDisabled();
        $enabled = $this->active->getEnabled();

        $grid = $this->gridFactory->create($container, $name);
        $grid->setDataSource(
            $this->em->getProductRepository()->createQueryBuilder('p')
        );

        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('description', 'Description');
        $grid->addColumnDateTime('created_at', 'Created At')
            ->setFormat(DateTime::FORMAT_USER);
        $grid->addColumnText('highlight', 'Highlight');
        $grid->addColumnStatus('active', 'Active')
            ->setCaret(false)
            ->addOption(false, $disabled->getText())
            ->setIcon($disabled->getIcon())
            ->setClass("btn-{$disabled->getBg()}")
            ->endOption()
            ->addOption(true, $enabled->getText())
            ->setIcon($enabled->getIcon())
            ->setClass("btn-{$enabled->getBg()}")
            ->endOption()
            ->onChange[] = $onChange;

        $grid->addAction('edit', '', ':Admin:Product:product')
            ->setClass(Grid::BTN_WARNING)
            ->setIcon(Grid::ICON_PENCIL)
            ->setTitle(Grid::TITLE_EDIT);
        $grid->addAction('delete', '', 'deleteProduct!')
            ->setClass(Grid::BTN_DANGER)
            ->setIcon(Grid::ICON_TRASH)
            ->setTitle(Grid::TITLE_DELETE);

        return $grid;
    }

}