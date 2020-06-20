<?php
declare(strict_types=1);

namespace App\UI\Form\Contact;

use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ContactFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param callable(Form, ContactFormType): void $onSuccess
     * @return Form
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->formFactory->createUnsecured();

        $form->addText('name', 'Jméno')
            ->setRequired('Zadejte jméno')
            ->setHtmlAttribute('placeholder', 'Jméno');
        $form->addEmail('email', 'Email')
            ->setRequired('Zadejte email')
            ->setHtmlAttribute('placeholder', 'Email');
        $form->addTextArea('message')
            ->setRequired('Vaše zpráva je prázdná')
            ->setHtmlAttribute('placeholder', 'Vaše zpráva');
        $form->addSubmit('submit', 'Odeslat');
        $form->setMappedType(ContactFormType::class);

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}