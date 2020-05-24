<?php
declare(strict_types=1);

namespace App\UI\Form\User;

use App\Model\Database\Entity\User;
use App\Model\Security\SecurityUser;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class UserFormFactory
{

    private FormFactory $formFactory;

    private SecurityUser $securityUser;

    public function __construct(FormFactory $formFactory, SecurityUser $securityUser)
    {
        $this->formFactory = $formFactory;
        $this->securityUser = $securityUser;
    }

    /**
     * @param User $user
     * @param callable(Form, UserFormType): void $onSuccess
     * @return Form
     */
    public function create(User $user, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addUpload('image')
            ->addRule(Form::IMAGE, 'form.message.image')
            ->addRule(Form::MAX_FILE_SIZE, 'form.message.file %d', 1 * 1024 * 1024);
        $form->addText('name', 'Name')
            ->setRequired();
        $form->addText('surname', 'Surname')
            ->setRequired();
        $form->addText('email', 'Email')
            ->setRequired();

        $form->addSubmit('submit', 'Save');
        $form->setMappedType(UserFormType::class);
        $form->onSuccess[] = $onSuccess;

        $form->setDefaults([
            'name' => $user->getName(),
            'surname' => $user->getSurname(),
            'email' => $user->getEmail()
        ]);

        return $form;
    }

}