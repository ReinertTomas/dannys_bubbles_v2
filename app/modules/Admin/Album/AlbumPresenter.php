<?php
declare(strict_types=1);

namespace App\Modules\Admin\Album;

use App\Domain\Album\AlbumFacade;
use App\Model\Database\Entity\Album;
use App\Model\File\FileInfoInterface;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\Album\AlbumControl;
use App\UI\Control\Album\IAlbumControlFactory;
use App\UI\Control\Dropzone\DropzoneControl;
use App\UI\Control\Dropzone\IDropzoneFactory;
use App\UI\Form\Album\AlbumFormFactory;
use App\UI\Form\Album\AlbumFormType;
use App\UI\Grid\Album\AlbumGridFactory;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class AlbumPresenter extends BaseAdminPresenter
{

    private ?Album $album = null;

    /** @inject */
    public AlbumGridFactory $albumGridFactory;

    /** @inject */
    public AlbumFormFactory $albumFormFactory;

    /** @inject */
    public IDropzoneFactory $dropzoneFactory;

    /** @inject */
    public IAlbumControlFactory $albumControlFactory;

    /** @inject */
    public AlbumFacade $albumFacade;

    public function actionAlbum(?int $id): void
    {
        if ($id !== null) {
            $this->album = $this->em->getAlbumRepository()->find($id);
            if ($this->album === null) {
                $this->errorNotFoundEntity($id);
            }
        }

        $this->getDropzoneControl()
            ->acceptOnlyImages();
    }

    public function actionDelete(int $id): void
    {
        $album = $this->albumFacade->get($id);
        if ($album === null) {
            $this->errorNotFoundEntity($id);
        }

        $this->albumFacade->remove($album);
        $this->flashSuccess('messages.album.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->getAlbumGrid()->reload();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->album = $this->album;
    }

    public function handleDeleteAlbumHasImage(int $idAlbumHasImage): void
    {
        $albumHasImage = $this->albumFacade->getAlbumHasImage($idAlbumHasImage);
        if ($albumHasImage === null) {
            $this->errorNotFoundEntity($idAlbumHasImage);
        }

        $this->albumFacade->removeAlbumHasImage($albumHasImage->getAlbum(), $albumHasImage);
        $this->flashSuccess('messages.album.image.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleChangeCover(int $idAlbumHasImage): void
    {
        $albumHasImage = $this->albumFacade->getAlbumHasImage($idAlbumHasImage);
        if ($albumHasImage === null) {
            $this->errorNotFoundEntity($idAlbumHasImage);
        }

        $this->albumFacade->changeCover($albumHasImage->getAlbum(), $albumHasImage);
        $this->flashSuccess('messages.album.change.cover');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentAlbumGrid(string $name): DataGrid
    {
        return $this->albumGridFactory->create($this, $name, function ($id, $value): void {
            $id = (int)$id;
            $album = $this->albumFacade->get($id);
            if ($album === null) {
                $this->errorNotFoundEntity($id);
            }

            $this->albumFacade->changeActive($album, (bool)$value);

            if ($this->isAjax()) {
                $this->redrawFlashes();
                $this->getAlbumGrid()
                    ->reload();
                $this->setAjaxPostGet();
            } else {
                $this->redirect('this');
            }
        });
    }

    protected function createComponentAlbumForm(): Form
    {
        $form = $this->albumFormFactory->create($this->album);
        $form->onSuccess[] = function (Form $form, AlbumFormType $formType): void {
            if ($this->album === null) {
                $this->album = $this->albumFacade->create($formType);
                $this->flashSuccess('messages.album.created');
            } else {
                $this->album = $this->albumFacade->update($this->album, $formType);
                $this->flashSuccess('messages.album.updated');
            }
            $this->redirect('this', $this->album->getId());
        };
        return $form;
    }

    protected function createComponentAlbum(): AlbumControl
    {
        return $this->albumControlFactory->create($this, $this->album);
    }

    protected function createComponentDropzone(): DropzoneControl
    {
        return $this->dropzoneFactory->create(
            $this,
            function (FileInfoInterface $file): void {
                $this->albumFacade->addAlbumHasImage($this->album, $file);
            },
            function (): void {
                $this->flashSuccess('messages.upload.success');
                $this->redrawModalContent();
                $this->redrawImages();
                $this->setAjaxPostGet();
            }
        );
    }

    private function getAlbumGrid(): DataGrid
    {
        /** @var DataGrid $grid */
        $grid = $this['albumGrid'];
        return $grid;
    }

    private function getAlbumControl(): AlbumControl
    {
        /** @var AlbumControl $control */
        $control = $this['album'];
        return $control;
    }

    private function getDropzoneControl(): DropzoneControl
    {
        /** @var DropzoneControl $control */
        $control = $this['dropzone'];
        return $control;
    }

    private function redrawImages(): void
    {
        $this->redrawControl('images');
    }

}