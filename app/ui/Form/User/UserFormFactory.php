<?php
declare(strict_types=1);

namespace App\UI\Form\User;

use App\Model\Database\Entity\User;
use App\Model\User\UserDto;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class UserFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param User $user
     * @param callable(Form, App\Model\User\UserDto): void $onSuccess
     * @return Form
     */
    public function create(User $user, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('name', 'Name')
            ->setRequired();
        $form->addText('surname', 'Surname')
            ->setRequired();
        $form->addText('email', 'Email')
            ->setRequired();

        $form->addSubmit('submit', 'Save');
        $form->setMappedType(UserDto::class);
        $form->onSuccess[] = $onSuccess;

        $form->setDefaults([
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail()
        ]);

        return $form;
    }

}