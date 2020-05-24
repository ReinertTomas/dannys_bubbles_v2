<?php
declare(strict_types=1);

namespace App\Modules\Admin\User;

use App\Domain\User\UserFacade;
use App\Model\App;
use App\Model\Database\Entity\User;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Security\PasswordFormFactory;
use App\UI\Form\Security\PasswordFormType;
use App\UI\Form\Security\RoleFormFactory;
use App\UI\Form\Security\RoleFormType;
use App\UI\Form\User\RegisterFormFactory;
use App\UI\Form\User\RegisterFormType;
use App\UI\Form\User\UserFormFactory;
use App\UI\Form\User\UserFormType;
use App\UI\Grid\User\UserGridFactory;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

class UserPresenter extends BaseAdminPresenter
{

    private ?User $userSelected = null;

    /** @inject */
    public UserGridFactory $userGridFactory;

    /** @inject */
    public RegisterFormFactory $registerFormFactory;

    /** @inject */
    public UserFormFactory $userFormFactory;

    /** @inject */
    public RoleFormFactory $roleFormFactory;

    /** @inject */
    public PasswordFormFactory $passwordFormFactory;

    /** @inject */
    public UserFacade $userFacade;

    public function actionEdit(int $id): void
    {
        $this->userSelected = $this->userFacade->get($id);
        if ($this->userSelected === null) {
            $this->errorNotFoundEntity($id);
        }
    }

    public function actionDelete(int $id): void
    {
        $user = $this->userFacade->get($id);
        if ($user === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->userFacade->remove($user);

        $this->flashSuccess('messages.user.remove');
        $this->redirect(App::ADMIN_USER);
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->userSelected = $this->userSelected;
    }

    protected function createComponentUserGrid(string $name): DataGrid
    {
        return $this->userGridFactory->create($this, $name, function ($id, $value): void {
            $id = (int)$id;
            $user = $this->userFacade->get($id);
            if ($user === null) {
                $this->errorNotFoundEntity($id);
            }

            $this->userFacade->changeState($user, (int)$value);

            if ($this->isAjax()) {
                $this['userGrid']->reload();
            } else {
                $this->redirect('this');
            }
        });
    }

    protected function createComponentRegisterForm(): Form
    {
        return $this->registerFormFactory->create(function (Form $form, RegisterFormType $formType): void {
            try {
                $this->userSelected = $this->userFacade->create($formType);
            } catch (UniqueConstraintViolationException $e) {
                $this->flashError('messages.user.unique ' . $formType->email);
                return;
            }
            $this->flashSuccess('messages.user.create');
            $this->redirect(App::ADMIN_USER);
        });
    }

    protected function createComponentUserForm(): Form
    {
        return $this->userFormFactory->create(
            $this->userSelected,
            function (Form $form, UserFormType $formType): void {
                try {
                    $this->userSelected = $this->userFacade->update($this->userSelected, $formType);
                } catch (UniqueConstraintViolationException $e) {
                    $this->flashError('messages.user.unique ' . $formType->email);
                    return;
                }

                $this->flashSuccess('messages.user.update');
                $this->redirect('this');
            }
        );
    }

    protected function createComponentRoleForm(): Form
    {
        return $this->roleFormFactory->create(
            $this->userSelected,
            function (Form $form, RoleFormType $formType): void {
                $this->userFacade->changeRole($this->userSelected, $formType);

                $this->flashSuccess('messages.user.change.role');
                $this->redirect('this');
            }
        );
    }

    protected function createComponentPasswordForm(): Form
    {
        return $this->passwordFormFactory->create(function (Form $form, PasswordFormType $formType): void {
            try {
                $this->userFacade->changePassword($this->userSelected, $formType);
            } catch (InvalidArgumentException $e) {
                $this->flashError($e->getMessage());
                return;
            }

            $this->flashSuccess('messages.user.change.password');
            $this->redirect('this');
        });
    }

}