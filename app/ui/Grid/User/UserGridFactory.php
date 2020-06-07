<?php
declare(strict_types=1);

namespace App\UI\Grid\User;

use App\Domain\User\Element\States;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Utils\DateTime;
use App\Model\Utils\Html;
use App\UI\Grid\Grid;
use App\UI\Grid\GridFactory;
use Nette\ComponentModel\IContainer;
use Nette\Utils\Html as NetteHtml;
use Ublaboo\DataGrid\DataGrid;

final class UserGridFactory
{

    private GridFactory $gridFactory;

    private EntityManager $em;

    private States $states;

    public function __construct(GridFactory $gridFactory, EntityManager $em, States $states)
    {
        $this->gridFactory = $gridFactory;
        $this->em = $em;
        $this->states = $states;
    }

    public function create(IContainer $parent, string $name, callable $onChange): DataGrid
    {
        $fresh = $this->states->get(User::STATE_FRESH);
        $activated = $this->states->get(User::STATE_ACTIVATED);
        $blocked = $this->states->get(User::STATE_BLOCKED);

        $grid = $this->gridFactory->create($parent, $name);
        $grid->setDataSource(
            $this->em->getUserRepository()->createQueryBuilder('u1')
        );

        $grid->addColumnText('id', 'Id');
        $grid->addColumnText('image', 'Image')
            ->setRenderer(function (User $user): NetteHtml {
                return Html::el('img')
                    ->class('img-thumb-xxs rounded-circle')
                    ->src($user->getImage()->getPathWeb())
                    ->alt('Image');
            });
        $grid->addColumnText('name', 'Name')
            ->setFilterText();
        $grid->addColumnText('surname', 'Surname')
            ->setFilterText();
        $grid->addColumnText('email', 'Email')
            ->setFilterText();
        $grid->addColumnText('role', 'Role');
        $grid->addColumnDateTime('createdAt', 'Created')
            ->setFormat(DateTime::FORMAT_USER);
        $grid->addColumnDateTime('updatedAt', 'Updated')
            ->setFormat(DateTime::FORMAT_USER);
        $grid->addColumnStatus('state', 'State')
            ->setCaret(false)
            ->addOption(User::STATE_FRESH, $fresh->getText())
            ->setIcon($fresh->getIcon())
            ->setClass("btn-{$fresh->getBg()}")
            ->endOption()
            ->addOption(User::STATE_ACTIVATED, $activated->getText())
            ->setIcon($activated->getIcon())
            ->setClass("btn-{$activated->getBg()}")
            ->endOption()
            ->addOption(User::STATE_BLOCKED, $blocked->getText())
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