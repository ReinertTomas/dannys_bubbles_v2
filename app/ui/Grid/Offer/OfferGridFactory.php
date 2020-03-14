<?php
declare(strict_types=1);

namespace App\UI\Grid\Offer;

use App\Model\Database\Entity\File;
use App\Model\Database\Entity\Offer;
use App\Model\Database\EntityManager;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Ublaboo\DataGrid\DataGrid;

final class OfferGridFactory
{

    private GridFactory $gridFactory;

    private EntityManager $em;

    public function __construct(GridFactory $gridFactory, EntityManager $em)
    {
        $this->gridFactory = $gridFactory;
        $this->em = $em;
    }

    public function create(IContainer $parent, string $name): DataGrid
    {
        $grid = $this->gridFactory->create($parent, $name);
        $grid->setDataSource(
            $this->em->getOfferRepository()->createQueryBuilder('o1')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (Offer $offer): string {
                return $offer->getImage()
                    ->getName();
            });
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('text', 'Text');

        $grid->addAction('edit', '', ':Admin:Offer:edit')
            ->setClass('btn btn-warning btn-xs')
            ->setIcon(GridFactory::ICON_EDIT);

        return $grid;
    }

}