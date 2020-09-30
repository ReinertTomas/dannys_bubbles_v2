<?php
declare(strict_types=1);

namespace App\UI\Form\Review;

use App\Model\Database\Entity\Review;
use App\Model\Review\ReviewDto;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ReviewFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create(?Review $review, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title (required)')
            ->setRequired('Vyplň název');
        $form->addText('name', 'Name (required)')
            ->setRequired('Vyplň jméno autora');
        $form->addText('surname', 'Surname')
            ->setNullable();
        $form->addTextArea('text', 'Text (required)')
            ->setRequired('Vyplň text');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ReviewDto::class);

        $form->onSuccess[] = $onSuccess;

        if ($review !== null) {
            $form->setDefaults([
                'title' => $review->getTitle(),
                'name' => $review->getAuthorName(),
                'surname' => $review->getAuthorSurname(),
                'text' => $review->getText()
            ]);
        }

        return $form;
    }

}