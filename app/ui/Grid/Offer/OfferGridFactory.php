<?php
declare(strict_types=1);

namespace App\UI\Grid\Offer;

use App\Model\Database\Entity\Offer;
use App\Model\Database\EntityManager;
use App\Model\Element\Active;
use App\Model\Utils\Html;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html as NetteHtml;
use Ublaboo\DataGrid\DataGrid;

final class OfferGridFactory
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
            $this->em->getOfferRepository()->createQueryBuilder('o')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (Offer $offer): NetteHtml {
                return Html::el('img')
                    ->src($offer->getImage()->getThumbWeb())
                    ->class('img-thumb-sm')
                    ->alt('Image');
            });
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('description', 'Description');
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

        $grid->addAction('edit', '', ':Admin:Offer:offer')
            ->setClass(Grid::BTN_WARNING)
            ->setIcon(Grid::ICON_PENCIL)
            ->setTitle(Grid::TITLE_EDIT);
        $grid->addAction('delete', '', ':Admin:Offer:delete')
            ->setClass(Grid::BTN_DANGER)
            ->setIcon(Grid::ICON_TRASH)
            ->setTitle(Grid::TITLE_DELETE);

        return $grid;
    }

}