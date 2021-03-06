<?php
declare(strict_types=1);

namespace App\Modules\Admin\Sign;

use App\Model\App;
use App\Modules\Base\UnsecuredPresenter;
use App\UI\Form\Security\SignInFormFactory;
use App\UI\Form\Security\SignInFormType;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

class SignPresenter extends UnsecuredPresenter
{

    /** @inject */
    public SignInFormFactory $signInFormFactory;

    public function actionIn(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect(App::DESTINATION_AFTER_SIGN_IN);
        }
    }

    public function actionOut(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->user->logout();
            $this->flashSuccess('_front.sign.out.success');
        }
        $this->redirect(App::DESTINATION_AFTER_SIGN_OUT);
    }

    protected function createComponentSignInForm(): Form
    {
        $form = $this->signInFormFactory->create();
        $form->onSuccess[] = function (Form $form, SignInFormType $formType): void {
            try {
                $this->user->setExpiration($formType->remember ? '14 days' : '30 minutes');
                $this->user->login($formType->email, $formType->password);
            } catch (AuthenticationException $e) {
                $form->addError('messages.credential.invalid');
                return;
            }
            $this->redirect(App::DESTINATION_AFTER_SIGN_IN);
        };
        return $form;
    }

}