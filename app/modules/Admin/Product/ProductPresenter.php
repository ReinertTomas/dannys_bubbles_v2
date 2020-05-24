<?php
declare(strict_types=1);

namespace App\Modules\Admin\Product;

use App\Domain\Product\ProductFacade;
use App\Model\App;
use App\Model\Database\Entity\Product;
use App\Model\Exception\Runtime\InvalidStateException;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Product\ProductFormFactory;
use App\UI\Grid\Product\ProductGridFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class ProductPresenter extends BaseAdminPresenter
{

    private ?Product $product = null;

    /** @inject */
    public ProductFormFactory $productFormFactory;

    /** @inject */
    public ProductGridFactory $productGridFactory;

    /** @inject */
    public ProductFacade $productFacade;

    public function handleDeleteProduct(int $id): void
    {
        $product = $this->productFacade->get($id);
        if ($product === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->productFacade->remove($product);
        $this->flashSuccess('messages.offer.remove');

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
        $product = $this->productFacade->get($id);
        if ($product === null) {
            $this->errorNotFoundEntity($id);
        }

        try {
            $this->productFacade->toggleHighlight($product);
            $this->flashSuccess(
                sprintf('messages.product.%s', $product->isHighlight() ? 'highlight' : 'unhighlight')
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

    protected function createComponentProductGrid(string $name): DataGrid
    {
        return $this->productGridFactory->create($this, $name, function ($id, $value): void {

        });
    }

    protected function createComponentProductForm(): Form
    {
        $form = $this->productFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            if ($this->product !== null) {
                $this->product = $this->productFacade->update($this->product, $values['title'], $values['description'], $values['text'], $values['image']);
                $this->flashSuccess('messages.product.updated');
                $this->redirect('this');
            } else {
                $this->product = $this->productFacade->create($values['title'], $values['description'], $values['text'], $values['image']);
                $this->flashSuccess('messages.product.created');
                $this->redirect(App::ADMIN_PRODUCT . 'edit', $this->product->getId());
            }
        };
        return $form;
    }

    public function redrawProducts(): void
    {
        $this->redrawControl('products');
    }

}