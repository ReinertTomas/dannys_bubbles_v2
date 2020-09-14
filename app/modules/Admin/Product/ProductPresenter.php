<?php
declare(strict_types=1);

namespace App\Modules\Admin\Product;

use App\Domain\Product\Exception\HighlightException;
use App\Domain\Product\ProductFacade;
use App\Model\App;
use App\Model\Database\Entity\Product;
use App\Model\File\IFileInfo;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\Dropzone\DropzoneControl;
use App\UI\Control\Dropzone\IDropzoneFactory;
use App\UI\Form\Product\ProductFormFactory;
use App\UI\Form\Product\ProductFormType;
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

    /** @inject */
    public IDropzoneFactory $dropzoneFactory;

    public function actionProduct(?int $id): void
    {
        if ($id !== null) {
            $this->product = $this->productFacade->get($id);
            if ($this->product === null) {
                $this->errorNotFoundEntity($id);
            }
        }
    }

    public function actionDelete(int $id): void
    {
        $product = $this->productFacade->get($id);
        if ($product === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->productFacade->remove($product);
        $this->flashSuccess('messages.product.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawProducts();
            $this->setAjaxPostGet();
        } else {
            $this->redirect(App::ADMIN_PRODUCT);
        }
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->product = $this->product;
    }

    public function handleDeleteImage(int $idProductHasImage): void
    {
        $image = $this->productFacade->getImage($idProductHasImage);
        if ($image === null) {
            $this->errorNotFoundEntity($idProductHasImage);
        }

        $this->productFacade->removeImage($this->product, $image);
        $this->flashSuccess('messages.product.image.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleChangeCover(int $idProductHasImage): void
    {
        $image = $this->productFacade->getImage($idProductHasImage);
        if ($image === null) {
            $this->errorNotFoundEntity($idProductHasImage);
        }

        $this->productFacade->changeCover($this->product, $image);
        $this->flashSuccess('messages.product.change.cover');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentProductGrid(string $name): DataGrid
    {
        return $this->productGridFactory->create(
            $this,
            $name,
            function ($id, $value): void {
                $id = (int)$id;
                $product = $this->productFacade->get($id);
                if ($product === null) {
                    $this->errorNotFoundEntity($id);
                }

                $this->productFacade->changeActive($product, (bool)$value);

                if ($this->isAjax()) {
                    $this->redrawFlashes();
                    $this->getProductGrid()->reload();
                    $this->setAjaxPostGet();
                } else {
                    $this->redirect('this');
                }
            },
            function ($id, $value): void {
                $id = (int)$id;
                $product = $this->productFacade->get($id);
                if ($product === null) {
                    $this->errorNotFoundEntity($id);
                }

                try {
                    $this->productFacade->changeHighlight($product, (bool)$value);
                } catch (HighlightException $e) {
                    $this->flashWarning($e->getMessage());
                }

                if ($this->isAjax()) {
                    $this->redrawFlashes();
                    $this->getProductGrid()->reload();
                    $this->setAjaxPostGet();
                } else {
                    $this->redirect('this');
                }
            }
        );
    }

    protected function createComponentProductForm(): Form
    {
        $form = $this->productFormFactory->create($this->product);
        $form->onSuccess[] = function (Form $form, ProductFormType $formType): void {
            if ($this->product !== null) {
                $this->product = $this->productFacade->update($this->product, $formType);
                $this->flashSuccess('messages.product.updated');
                $this->redirect('this');
            } else {
                $this->product = $this->productFacade->create($formType);
                $this->flashSuccess('messages.product.created');
                $this->redirect('this', $this->product->getId());
            }
        };
        return $form;
    }

    protected function createComponentDropzone(): DropzoneControl
    {
        return $this->dropzoneFactory->create(
            $this,
            function (IFileInfo $file): void {
                $this->productFacade->addImage($this->product, $file);
            },
            function (): void {
                $this->flashSuccess('messages.upload.success');
                $this->redrawModalContent();
                $this->redrawImages();
                $this->setAjaxPostGet();
            }
        );
    }

    private function getProductGrid(): DataGrid
    {
        /** @var DataGrid $grid */
        $grid = $this['productGrid'];
        return $grid;
    }

    private function redrawProducts(): void
    {
        $this->redrawControl('products');
    }

    private function redrawImages(): void
    {
        $this->redrawControl('images');
    }

}