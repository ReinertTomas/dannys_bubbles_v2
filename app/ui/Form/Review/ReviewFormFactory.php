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

    public function create(?Review $review): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title (required)')
            ->setRequired();
        $form->addText('author', 'Author')
            ->setNullable();
        $form->addTextArea('text', 'Text (required)')
            ->setRequired();
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ReviewFormType::class);

        if ($review !== null) {
            $form->setDefaults([
                'title' => $review->getTitle(),
                'author' => $review->getAuthor(),
                'text' => $review->getText()
            ]);
        }

        return $form;
    }

}