<?php
declare(strict_types=1);

namespace App\UI\Grid\Product;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\Product;
use App\Model\Database\EntityManager;
use App\Model\Element\Active;
use App\Model\Element\Highlight;
use App\Model\Utils\DateTime;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html;
use Ublaboo\DataGrid\DataGrid;

final class ProductGridFactory
{

    private GridFactory $gridFactory;

    private EntityManager $em;

    private Active $active;

    protected Highlight $highlight;

    public function __construct(GridFactory $gridFactory, EntityManager $em, Active $active, Highlight $highlight)
    {
        $this->gridFactory = $gridFactory;
        $this->em = $em;
        $this->active = $active;
        $this->highlight = $highlight;
    }

    public function create(IContainer $container, string $name, callable $onActive, callable $onHighlight): DataGrid
    {
        $disabled = $this->active->getDisabled();
        $enabled = $this->active->getEnabled();

        $common = $this->highlight->getCommon();
        $highlight = $this->highlight->getHighlight();

        $grid = $this->gridFactory->create($container, $name);
        $grid->setDataSource(
            $this->em->getProductRepository()->createQueryBuilder('p')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (Product $product): Html {
                if ($product->getCover() !== null) {
                    $path = $product
                        ->getCover()
                        ->getImage()
                        ->getThumbWeb();
                } else {
                    $path = Image::BLANK_150x150;
                }

                return Html::el('img')
                    ->src($path)
                    ->class('img-thumb-sm')
                    ->alt('Image');
            });
        $grid->addColumnText('title', 'Title');
        $grid->addColumnText('description', 'Description');
        $grid->addColumnDateTime('created_at', 'Created At')
            ->setFormat(DateTime::FORMAT_USER);
        $grid->addColumnStatus('highlight', 'Highlight')
            ->setCaret(false)
            ->addOption(false, $common->getText())
            ->setIcon($common->getIcon())
            ->setClass("btn-{$common->getBg()}")
            ->endOption()
            ->addOption(true, $highlight->getText())
            ->setIcon($highlight->getIcon())
            ->setClass("btn-{$highlight->getBg()}")
            ->endOption()
            ->onChange[] = $onHighlight;

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
            ->onChange[] = $onActive;

        $grid->addAction('edit', '', ':Admin:Product:product')
            ->setClass(Grid::BTN_WARNING)
            ->setIcon(Grid::ICON_PENCIL)
            ->setTitle(Grid::TITLE_EDIT);
        $grid->addAction('delete', '', ':Admin:Product:delete')
            ->setClass(Grid::BTN_DANGER)
            ->setIcon(Grid::ICON_TRASH)
            ->setTitle(Grid::TITLE_DELETE);

        return $grid;
    }

}