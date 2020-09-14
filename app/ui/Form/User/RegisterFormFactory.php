<?php
declare(strict_types=1);

namespace App\UI\Form\User;

use App\Model\Security\Passwords;
use App\Model\User\UserDto;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class RegisterFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param callable(Form, App\Model\User\UserDto): void $onSuccess
     * @return Form
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('name', 'Name')
            ->setRequired();
        $form->addText('surname', 'Surname')
            ->setRequired();
        $form->addText('email', 'Email')
            ->setRequired();
        $form->addPassword('password', 'Password')
            ->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Password length must be min. 8 chars', 8)
            ->addRule(Form::PATTERN, 'Password is not strong', Passwords::PATTERN);
        $form->addPassword('passwordConfirm', 'Password Confirm')
            ->setRequired()
            ->setOmitted()
            ->addRule(Form::EQUAL, 'Passwords are different.', $form['password']);
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(UserDto::class);

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}