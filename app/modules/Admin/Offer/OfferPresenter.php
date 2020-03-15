<?php
declare(strict_types=1);

namespace App\Modules\Admin\Offer;

use App\Domain\Offer\OfferFacade;
use App\Model\App;
use App\Model\Database\Entity\Offer;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Offer\OfferFormFactory;
use Nette\Application\UI\Form;

final class OfferPresenter extends BaseAdminPresenter
{

    private int $id;

    private ?Offer $offer = null;

    /** @inject */
    public OfferFormFactory $offerFormFactory;

    /** @inject */
    public OfferFacade $offerFacade;

    public function renderDefault(): void
    {
        $this->template->offers = $this->em->getOfferRepository()->findAll();
    }

    public function actionEdit(int $id): void
    {
        $this->id = $id;

        $this->offer = $this->em->getOfferRepository()->find($this->id);
        if (!$this->offer) {
            $this->errorNotFoundEntity($this->id);
        }

        /** @var Form $form */
        $form = $this->getComponent('offerForm');
        $this->offerFormFactory->setDefaults($form, $this->offer);
    }

    public function renderEdit(int $id): void
    {
        $this->template->offer = $this->offer;
    }

    public function handleDelete(int $id): void
    {
        $offer = $this->em->getOfferRepository()->find($id);
        if (!$offer) {
            $this->errorNotFoundEntity($id);
        }

        $this->offerFacade->remove($offer);
        $this->flashSuccess('_message.offer.removed');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawOffers();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleToggleActive(int $id): void
    {
        $offer = $this->em->getOfferRepository()->find($id);
        if (!$offer) {
            $this->errorNotFoundEntity($id);
        }

        $offer->toggleActive();
        $this->em->flush();

        $this->flashSuccess(
            sprintf('_message.offer.%s', $offer->isActive() ? 'show' : 'hide')
        );

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawOffers();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentOfferForm(): Form
    {
        $form = $this->offerFormFactory->create();

        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            if ($this->offer) {
                $this->offerFacade->update($this->offer, $values['title'], $values['text'], $values['image']);

                $this->flashSuccess('_message.offer.updated');
                $this->redirect('this');
            } else {
                $this->offerFacade->create($values['title'], $values['text'], $values['image']);

                $this->flashSuccess('_message.offer.created');
                $this->redirect(App::ADMIN_OFFER);
            }
        };

        return $form;
    }

    public function redrawOffers(): void
    {
        $this->redrawControl('offers');
    }

}