<?php
declare(strict_types=1);

namespace App\UI\Form\Offer;

use App\Model\Database\Entity\Offer;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\UploadControl;

final class OfferFormFactory
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
            ->setRequired();
        $form->addTextArea('text', 'Text')
            ->setRequired();
        $form->addUpload('image', 'Image')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Select only images');

        $form->addSubmit('submit');

        return $form;
    }

    public function setDefaults(Form $form, Offer $offer): void
    {
        /** @var UploadControl $uploadControl */
        $uploadControl = $form->getComponent('image');
        $uploadControl->setRequired(false);

        $form->setDefaults([
            'title' => $offer->getTitle(),
            'text' => $offer->getText()
        ]);
    }

}