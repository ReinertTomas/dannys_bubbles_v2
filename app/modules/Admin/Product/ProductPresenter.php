<?php
declare(strict_types=1);

namespace App\Modules\Admin\Product;

use App\Domain\Product\ProductFacade;
use App\Model\App;
use App\Model\Database\Entity\Product;
use App\Model\Exception\Runtime\InvalidStateException;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Product\ProductFormFactory;
use Nette\Application\UI\Form;

final class ProductPresenter extends BaseAdminPresenter
{

    private int $id;

    private ?Product $product = null;

    /** @inject */
    public ProductFormFactory $productFormFactory;

    /** @inject */
    public ProductFacade $productFacade;

    public function renderDefault(): void
    {
        $this->template->products = $this->em->getProductRepository()->findAll();
    }

    public function actionEdit(int $id): void
    {
        $this->id = $id;
        $this->product = $this->findProduct($id);

        /** @var Form $form */
        $form = $this->getComponent('productForm');
        $this->productFormFactory->setDefaults($form, $this->product);
    }

    public function renderEdit(): void
    {
        $this->template->product = $this->product;
    }

    public function handleDelete(int $id): void
    {
        $product = $this->findProduct($id);

        $this->productFacade->remove($product);
        $this->flashSuccess('_message.offer.removed');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawProducts();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleToggleActive(int $id): void
    {
        $product = $this->findProduct($id);

        $product->toggleActive();
        $this->em->flush();

        $this->flashSuccess(
            sprintf('_message.product.%s', $product->isActive() ? 'show' : 'hide')
        );

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawProducts();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleToggleHighlight(int $id): void
    {
        $product = $this->findProduct($id);

        try {
            $this->productFacade->toggleHighlight($product);
            $this->flashSuccess(
                sprintf('_message.product.%s', $product->isHighlight() ? 'highlight' : 'unhighlight')
            );
        } catch (InvalidStateException $e) {
            $this->flashWarning($e->getMessage());
        }

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawProducts();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentProductForm(): Form
    {
        $form = $this->productFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            if ($this->product) {
                $this->product = $this->productFacade->update($this->product, $values['title'], $values['description'], $values['text'], $values['image']);
                $this->flashSuccess('_message.product.updated');
                $this->redirect('this');
            } else {
                $this->product = $this->productFacade->create($values['title'], $values['description'], $values['text'], $values['image']);
                $this->flashSuccess('_message.product.created');
                $this->redirect(App::ADMIN_PRODUCT . 'edit', $this->product->getId());
            }
        };
        return $form;
    }

    public function redrawProducts(): void
    {
        $this->redrawControl('products');
    }

    private function findProduct(int $id): Product
    {
        $product = $this->em->getProductRepository()->find($id);
        if (!$product) {
            $this->errorNotFoundEntity($id);
        }
        return $product;
    }

}