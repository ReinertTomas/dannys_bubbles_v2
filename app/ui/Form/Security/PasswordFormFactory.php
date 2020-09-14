<?php
declare(strict_types=1);

namespace App\UI\Form\Security;

use App\Model\Security\Passwords;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

class PasswordFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param callable(Form, PasswordFormData): void $onSuccess
     * @return Form
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addPassword('passwordOld', 'Old Password')
            ->setRequired();

        $form->addPassword('passwordNew', 'New Password')
            ->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Password length must be min. 8 chars', 8)
            ->addRule(Form::PATTERN, 'Password is not strong', Passwords::PATTERN)
            ->addRule(Form::NOT_EQUAL, 'Passwords are same.', $form['passwordOld']);
        $form->addPassword('passwordNewConfirm', 'New Password Confirm')
            ->setRequired()
            ->setOmitted()
            ->addRule(Form::EQUAL, 'Passwords are different.', $form['passwordNew']);
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(PasswordFormData::class);
        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}