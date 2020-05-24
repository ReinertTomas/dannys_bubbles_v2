<?php
declare(strict_types=1);

namespace App\UI\Form\Product;

use App\Model\Database\Entity\Product;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ProductFormFactory
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
        $form->addTextArea('description', 'Description')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Description (required)')
            ->addRule(Form::MAX_LENGTH, 'messages.form.maxLength %s', 255);
        $form->addTextArea('text', 'Text')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Text (required)');
        $form->addUpload('image', 'Image')
            ->setRequired()
            ->addRule(Form::IMAGE, 'messages.form.only.image')
            ->addRule(Form::MAX_FILE_SIZE, 'messages.form.upload.max 4MB.', 4 * 1024 * 1024);
        $form->addSubmit('submit');

        return $form;
    }

    public function setDefaults(Form $form, Product $product): void
    {
        $form->setDefaults([
            'title' => $product->getTitle(),
            'description' => $product->getDescription(),
            'text' => $product->getText(),
        ]);
    }

}