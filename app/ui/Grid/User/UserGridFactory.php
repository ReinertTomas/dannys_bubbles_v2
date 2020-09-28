<?php
declare(strict_types=1);

namespace App\UI\Grid\User;

use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\User\State\Active;
use App\Model\User\State\Block;
use App\Model\User\State\Fresh;
use App\Model\Utils\Html\Badge;
use App\Model\Utils\Html\Img;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html;
use Ublaboo\DataGrid\DataGrid;

final class UserGridFactory
{

    private GridFactory $gridFactory;

    private EntityManager $em;

    public function __construct(GridFactory $gridFactory, EntityManager $em)
    {
        $this->gridFactory = $gridFactory;
        $this->em = $em;
    }

    public function create(IContainer $parent, string $name, callable $onChange): DataGrid
    {
        $fresh = new Fresh();
        $activated = new Active();
        $blocked = new Block();

        $grid = $this->gridFactory->create($parent, $name);
        $grid->setDataSource(
            $this->em->getUserRepository()->createQueryBuilder('u1')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (User $user): Html {
                return Img::create($user->getImage()->getPathWeb())
                    ->setSizeExtraSmall()
                    ->setRoundedCircle()
                    ->toHtml();
            });
        $grid->addColumnText('name', 'Name')
            ->setFilterText();
        $grid->addColumnText('surname', 'Surname')
            ->setFilterText();
        $grid->addColumnText('email', 'Email')
            ->setFilterText();
        $grid->addColumnText('role', 'Role')
            ->setRenderer(function (User $user): Html {
                $element = $user->getRoleElement();
                return Badge::create()
                    ->setText($element->getText())
                    ->setBg($element->getBg())
                    ->toHtml();
            });
        $grid->addColumnStatus('state', 'State')
            ->setCaret(false)
            ->addOption($fresh->getState(), $fresh->getText())
            ->setIcon($fresh->getIcon())
            ->setClass("btn-{$fresh->getBg()}")
            ->endOption()
            ->addOption($activated->getState(), $activated->getText())
            ->setIcon($activated->getIcon())
            ->setClass("btn-{$activated->getBg()}")
            ->endOption()
            ->addOption($blocked->getState(), $blocked->getText())
            ->setIcon($blocked->getIcon())
            ->setClass("btn-{$blocked->getBg()}")
            ->endOption()
            ->onChange[] = $onChange;

        $grid->addAction('edit', '', ':Admin:User:edit')
            ->setClass(Grid::BTN_WARNING)
            ->setIcon(Grid::ICON_PENCIL)
            ->setTitle(Grid::TITLE_EDIT);
        $grid->addAction('delete', '', ':Admin:User:delete')
            ->setClass(Grid::BTN_DANGER)
            ->setIcon(Grid::ICON_TRASH)
            ->setTitle(Grid::TITLE_DELETE)
            ->setRenderCondition(function (user $user): bool {
                return !$user->isAdmin();
            });

        return $grid;
    }

}