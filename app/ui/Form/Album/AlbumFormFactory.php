<?php
declare(strict_types=1);

namespace App\UI\Form\Album;

use App\Model\Database\Entity\Album;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class AlbumFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create(): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Title (required)');
        $form->addTextArea('text', 'Text')
            ->setRequired()
            ->addRule(Form::MAX_LENGTH, '_message.form.maxLength %s', 128)
            ->setHtmlAttribute('placeholder', 'Text (required)');
        $form->addSubmit('submit');

        return $form;
    }

    public function setDefaults(Form $form, Album $album): void
    {
        $form->setDefaults([
                'title' => $album->getTitle(),
                'text' => $album->getText()
        ]);
    }

}