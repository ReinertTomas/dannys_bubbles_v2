<?php
declare(strict_types=1);

namespace App\UI\Grid\Review;

use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\Model\Element\Active;
use App\Model\Utils\DateTime;
use App\Model\Utils\Html;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html as NetteHtml;
use Ublaboo\DataGrid\DataGrid;

final class ReviewGridFactory
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
            $this->em->getReviewRepository()->createQueryBuilder('r')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (Review $review): NetteHtml {
                return Html::el('img')
                    ->class('img-thumb-xxs rounded-circle')
                    ->src($review->getImage()->getPathWeb())
                    ->alt('Image');
            });
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('author', 'Author');
        $grid->addColumnText('text', 'Text');
        $grid->addColumnDateTime('created_at', 'Created At')
            ->setFormat(DateTime::FORMAT_USER);
        $grid->addColumnStatus('active', 'Active')
            ->setCaret(false)
            ->addOption(false, $disabled->getText())
                ->setClass("btn-{$disabled->getBg()}")
                ->setIcon($disabled->getIcon())
                ->endOption()
            ->addOption(true, $enabled->getText())
                ->setClass("btn-{$enabled->getBg()}")
                ->setIcon($enabled->getIcon())
                ->endOption()
            ->onChange[] = $onChange;

        $grid->addAction('review', '', ':Admin:Review:review')
            ->setClass(Grid::BTN_WARNING)
            ->setIcon(Grid::ICON_PENCIL)
            ->setTitle(Grid::TITLE_EDIT);
        $grid->addAction('delete', '', ':Admin:Review:delete')
            ->setClass(Grid::BTN_DANGER)
            ->setIcon(Grid::ICON_TRASH)
            ->setTitle(Grid::TITLE_DELETE);

        return $grid;
    }

}