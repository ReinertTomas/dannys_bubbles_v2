<?php
declare(strict_types=1);

namespace App\Modules\Admin\Offer;

use App\Domain\Offer\OfferFacade;
use App\Model\App;
use App\Model\Database\Entity\Offer;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Offer\OfferFormFactory;
use App\UI\Form\Offer\OfferFormType;
use App\UI\Grid\Offer\OfferGridFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class OfferPresenter extends BaseAdminPresenter
{

    private ?Offer $offer = null;

    /** @inject */
    public OfferGridFactory $offerGridFactory;

    /** @inject */
    public OfferFormFactory $offerFormFactory;

    /** @inject */
    public OfferFacade $offerFacade;

    public function actionOffer(?int $id): void
    {
        if ($id !== null) {
            $this->offer = $this->em->getOfferRepository()->find($id);
            if ($this->offer === null) {
                $this->errorNotFoundEntity($id);
            }
        }
    }

    public function actionDelete(int $id): void
    {
        $offer = $this->offerFacade->get($id);
        if ($offer === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->offerFacade->remove($offer);
        $this->flashSuccess('messages.offer.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->getOfferGrid()->reload();
            $this->setAjaxPostGet();
        } else {
            $this->redirect(App::ADMIN_OFFER);
        }
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->offer = $this->offer;
    }

    protected function createComponentOfferGrid(string $name): DataGrid
    {
        return $this->offerGridFactory->create($this, $name, function ($id, $value): void {
            $id = (int)$id;
            $offer = $this->offerFacade->get($id);
            if ($offer === null) {
                $this->errorNotFoundEntity($id);
            }

            $this->offerFacade->changeActive($offer, (bool)$value);
            $this->flashSuccess(
                sprintf('messages.offer.%s', $offer->isActive() ? 'show' : 'hide')
            );

            if ($this->isAjax()) {
                $this->redrawFlashes();
                $this->getOfferGrid()
                    ->reload();
                $this->setAjaxPostGet();
            } else {
                $this->redirect('this');
            }
        });
    }

    protected function createComponentOfferForm(): Form
    {
        $form = $this->offerFormFactory->create($this->offer);
        $form->onSuccess[] = function (Form $form, OfferFormType $formType): void {
            if ($this->offer === null) {
                $this->offer = $this->offerFacade->create($formType);
                $this->flashSuccess('messages.offer.created');
            } else {
                $this->offerFacade->update($this->offer, $formType);
                $this->flashSuccess('messages.offer.updated');
            }
            $this->redirect('this', $this->offer->getId());
        };
        return $form;
    }

    private function getOfferGrid(): DataGrid
    {
        /** @var DataGrid $grid */
        $grid = $this['offerGrid'];
        return $grid;
    }

}