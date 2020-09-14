<?php
declare(strict_types=1);

namespace App\UI\Form\Review;

use App\Domain\Review\ReviewFacade;
use App\Model\Database\Entity\Review;
use App\Model\File\FileInfo;
use App\Model\File\FileUploader;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;

final class ReviewFormFactory
{

    private FormFactory $formFactory;

    private ReviewFacade $reviewFacade;

    private FileUploader $fileUploader;

    public function __construct(FormFactory $formFactory, ReviewFacade $reviewFacade, FileUploader $fileUploader)
    {
        $this->formFactory = $formFactory;
        $this->reviewFacade = $reviewFacade;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param Review|null $review
     * @param callable(Review): void $onSuccess
     * @return Form
     */
    public function create(?Review $review, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('title', 'Title (required)')
            ->setRequired('Vyplň název');
        $form->addText('author', 'Author')
            ->setNullable();
        $form->addTextArea('text', 'Text (required)')
            ->setRequired('Vyplň text');
        $image = $form
            ->addUpload('image', 'Image')
            ->setRequired('Vyber obrázek')
            ->addRule(Form::IMAGE, 'Select only images');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ReviewFormType::class);

        $form->onSuccess[] = function (Form $form, ReviewFormType $formType) use ($review, $onSuccess): void {
            $image = $this->getFileInfo($formType->image);
            if ($review === null) {
                $review = $this->reviewFacade->create($image, $formType->title, $formType->author, $formType->text);
            } else {
                $this->reviewFacade->update($review, $image, $formType->title, $formType->author, $formType->text);
            }
            ($onSuccess)($review);
        };

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

    private function getFileInfo(FileUpload $fileUpload): ?FileInfo
    {
        if ($fileUpload->isOk()) {
            return $this->fileUploader->upload($fileUpload);
        }
        return null;
    }

}