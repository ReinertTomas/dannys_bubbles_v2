<?php
declare(strict_types=1);

namespace App\UI\Grid\Review;

use App\Model\Database\Entity\Review;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ReviewRepository;
use App\Model\Html\Active\Disable;
use App\Model\Html\Active\Enable;
use App\Model\Utils\DateTime;
use App\Model\Utils\Html\Img;
use App\Model\Utils\Strings;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html;
use Ublaboo\DataGrid\DataGrid;

final class ReviewGridFactory
{

    private GridFactory $gridFactory;

    private ReviewRepository $reviewRepository;

    public function __construct(GridFactory $gridFactory, EntityManager $em)
    {
        $this->gridFactory = $gridFactory;
        $this->reviewRepository = $em->getReviewRepository();
    }

    public function create(IContainer $container, string $name, callable $onChange): DataGrid
    {
        $disabled = new Disable();
        $enabled = new Enable();

        $grid = $this->gridFactory->create($container, $name);
        $grid->setDataSource(
            $this->reviewRepository->createQueryBuilder('r')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (Review $review): Html {
                return Img::create($review->getImage()->getPathWeb())
                    ->setSizeExtraSmall()
                    ->setRoundedCircle()
                    ->toHtml();
            });
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('author', 'Author')
            ->setRenderer(function (Review $review): string {
                return $review->getAuthorFullname();
            });
        $grid->addColumnText('text', 'Text')
            ->setRenderer(function (Review $review): string {
                return Strings::truncate($review->getText(), 100);
            });
        $grid->addColumnDateTime('createdAt', 'Created At')
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

        $grid->addAction('review', '', ':Admin:Review:edit')
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