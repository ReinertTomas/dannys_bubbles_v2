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

    public function create(?Album $album): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title (required)')
            ->setRequired();
        $form->addTextArea('text', 'Text (required)')
            ->setRequired()
            ->addRule(Form::MAX_LENGTH, 'messages.form.maxLength %s', 255);
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(AlbumFormType::class);

        if ($album !== null) {
            $form->setDefaults([
                'title' => $album->getTitle(),
                'text' => $album->getText()
            ]);
        }

        return $form;
    }

}