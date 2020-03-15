<?php
declare(strict_types=1);

namespace App\UI\Form\Review;

use App\Model\Database\Entity\Review;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ReviewFormFactory
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
        $form->addText('author', 'Author')
            ->setNullable();
        $form->addTextArea('text', 'Text')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Text (required)');
        $form->addSubmit('submit');

        return $form;
    }

    public function setDefaults(Form $form, Review $review): void
    {
        $form->setDefaults([
            'title' => $review->getTitle(),
            'author' => $review->getAuthor(),
            'text' => $review->getText()
        ]);
    }

}