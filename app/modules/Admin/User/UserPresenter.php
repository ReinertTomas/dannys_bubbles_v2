<?php
declare(strict_types=1);

namespace App\Modules\Admin\User;

use App\Model\App;
use App\Model\Database\Entity\User;
use App\Model\Security\Exception\PasswordEqualException;
use App\Model\Security\Exception\PasswordVerifyException;
use App\Model\User\Exception\EmailUniqueException;
use App\Model\User\UserDto;
use App\Model\User\UserFacade;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Security\PasswordFormFactory;
use App\UI\Form\Security\PasswordFormData;
use App\UI\Form\Security\RoleFormFactory;
use App\UI\Form\Security\RoleFormData;
use App\UI\Form\User\RegisterFormFactory;
use App\UI\Form\User\UserFormFactory;
use App\UI\Grid\User\UserGridFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

/**
 * @property UserTemplate $template
 */
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
                $this->getUserGrid()->reload();
            } else {
                $this->redirect('this');
            }
        });
    }

    protected function createComponentRegisterForm(): Form
    {
        return $this->registerFormFactory->create(function (Form $form, UserDto $dto): void {
            try {
                $this->userSelected = $this->userFacade->create($dto);
            } catch (EmailUniqueException $e) {
                $this->flashError($e->getMessage() . ' ' . $dto->email);
                return;
            }
            $this->flashSuccess('messages.user.create');
            $this->redirect(App::ADMIN_USER);
        });
    }

    protected function createComponentUserForm(): Form
    {
        return $this->userFormFactory->create($this->userSelected, function (Form $form, UserDto $dto): void {
            try {
                $this->userFacade->update($this->userSelected, $dto);
            } catch (EmailUniqueException $e) {
                $this->flashError($e->getMessage() . ' ' . $dto->email);
                return;
            }

            $this->flashSuccess('messages.user.update');
            $this->redirect('this');
        });
    }

    protected function createComponentRoleForm(): Form
    {
        return $this->roleFormFactory->create(
            $this->userSelected,
            function (Form $form, RoleFormData $formType): void {
                $this->userFacade->changeRole($this->userSelected, $formType->role);

                $this->flashSuccess('messages.user.change.role');
                $this->redirect('this');
            }
        );
    }

    protected function createComponentPasswordForm(): Form
    {
        return $this->passwordFormFactory->create(function (Form $form, PasswordFormData $formType): void {
            try {
                $this->userFacade->changePassword($this->userSelected, $formType->passwordOld, $formType->passwordNew);
            } catch (PasswordVerifyException $e) {
                $this->flashError($e->getMessage());
                return;
            } catch (PasswordEqualException $e) {
                $this->flashError($e->getMessage());
                return;
            }

            $this->flashSuccess('messages.user.change.password');
            $this->redirect('this');
        });
    }

    private function getUserGrid(): DataGrid
    {
        /** @var DataGrid $grid */
        $grid = $this['userGrid'];
        return $grid;
    }

}