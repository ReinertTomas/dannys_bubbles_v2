<?php
declare(strict_types=1);

namespace App\Modules\Admin\Review;

use App\Domain\Review\ReviewFacade;
use App\Model\App;
use App\Model\Database\Entity\Review;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Review\ReviewFormFactory;
use Nette\Application\UI\Form;

final class ReviewPresenter extends BaseAdminPresenter
{

    private int $id;

    private ?Review $review = null;

    /** @inject */
    public ReviewFormFactory $reviewFormFactory;

    /** @inject */
    public ReviewFacade $reviewFacade;

    public function renderDefault(): void
    {
        $this->template->reviews = $this->em->getReviewRepository()->findAll();
    }

    public function actionEdit(int $id): void
    {
        $this->id = $id;

        $this->review = $this->em->getReviewRepository()->find($this->id);
        if (!$this->review) {
            $this->errorNotFoundEntity($id);
        }

        /** @var Form $form */
        $form = $this->getComponent('reviewForm');
        $this->reviewFormFactory->setDefaults($form, $this->review);
    }

    public function handleDelete(int $id): void
    {
        $review = $this->em->getReviewRepository()->find($id);
        if (!$review) {
            $this->errorNotFoundEntity($id);
        }

        $this->reviewFacade->remove($review);
        $this->flashSuccess('_message.review.removed');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawReviews();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleToggleActive(int $id): void
    {
        $review = $this->em->getReviewRepository()->find($id);
        if (!$review) {
            $this->errorNotFoundEntity($id);
        }

        $review->toggleActive();
        $this->em->flush();

        $this->flashSuccess(
            sprintf('_message.review.%s', $review->isActive() ? 'show' : 'hide')
        );

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawReviews();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentReviewForm(): Form
    {
        $form = $this->reviewFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            if ($this->review) {
                $this->reviewFacade->update($this->review, $values['title'], $values['text'], $values['author']);
                $this->flashSuccess('_message.review.updated');
                $this->redirect('this');
            } else {
                $this->reviewFacade->create($values['title'], $values['text'], $values['author']);
                $this->flashSuccess('_message.review.created');
                $this->redirect(App::ADMIN_REVIEW);
            }
        };
        return $form;
    }

    public function redrawReviews(): void 
    {
        $this->redrawControl('reviews');
    }

}