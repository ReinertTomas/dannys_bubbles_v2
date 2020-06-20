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

    /**
     * @param Review|null $review
     * @param callable(Form, ReviewFormType): void $onSuccess
     * @return Form
     */
    public function create(?Review $review, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title (required)')
            ->setRequired();
        $form->addText('author', 'Author')
            ->setNullable();
        $form->addTextArea('text', 'Text (required)')
            ->setRequired();
        $image = $form
            ->addUpload('image', 'Image')
            ->setRequired()
            ->addRule(Form::IMAGE, 'Select only images');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ReviewFormType::class);

        $form->onSuccess[] = $onSuccess;

        if ($review !== null) {
            $image->setRequired(false);
            $form->setDefaults([
                'title' => $review->getTitle(),
                'author' => $review->getAuthor(),
                'text' => $review->getText()
            ]);
        }

        return $form;
    }

}