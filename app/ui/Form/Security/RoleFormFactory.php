<?php
declare(strict_types=1);

namespace App\UI\Form\Security;

use App\Model\Database\Entity\User;
use App\Model\User\Role\Roles;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class RoleFormFactory
{

    private FormFactory $formFactory;

    private Roles $roles;

    public function __construct(FormFactory $formFactory, Roles $roles)
    {
        $this->formFactory = $formFactory;
        $this->roles = $roles;
    }

    /**
     * @param User $user
     * @param callable(Form, RoleFormData): void $onSuccess
     * @return Form
     */
    public function create(User $user, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addSelect('role', 'Role', $this->roles->toItems())
            ->setDefaultValue($user->getRole());
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(RoleFormData::class);

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}