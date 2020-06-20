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

    public function create(?Offer $offer): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title')
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setRequired();
        $form->addTextArea('text', 'Text')
            ->setRequired();
        $image = $form
            ->addUpload('image', 'Image')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Select only images');
        $form->addSubmit('submit');
        $form->setMappedType(OfferFormType::class);

        if ($offer !== null) {
            $image->setRequired(false);
            $form->setDefaults([
                'title' => $offer->getTitle(),
                'description' => $offer->getDescription(),
                'text' => $offer->getText()
            ]);
        }

        return $form;
    }

}