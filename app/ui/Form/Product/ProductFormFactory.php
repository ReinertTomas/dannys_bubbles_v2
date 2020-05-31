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

    public function create(?Product $product): Form
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
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ProductFormType::class);

        if ($product !== null) {
            $form->setDefaults([
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'text' => $product->getText()
            ]);
        }

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