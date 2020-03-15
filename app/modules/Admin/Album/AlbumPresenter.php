<?php
declare(strict_types=1);

namespace App\Modules\Admin\Album;

use App\Domain\Album\AlbumFacade;
use App\Domain\File\FileFacade;
use App\Model\App;
use App\Model\Database\Entity\Album;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\Dropzone\DropzoneControl;
use App\UI\Control\Dropzone\DropzoneFactory;
use App\UI\Form\Album\AlbumFormFactory;
use App\UI\Form\File\UploadFormFactory;
use Nette\Application\UI\Form;

final class AlbumPresenter extends BaseAdminPresenter
{

    private int $id;

    private ?Album $album = null;

    /** @inject */
    public DropzoneFactory $dropzoneFactory;

    /** @inject */
    public UploadFormFactory $uploadFormFactory;

    /** @inject */
    public AlbumFormFactory $albumFormFactory;

    /** @inject */
    public AlbumFacade $albumFacade;

    public function renderDefault(): void
    {
        $this->template->albums = $this->em->getAlbumRepository()->findAll();
    }

    public function actionNew(): void
    {
        /** @var Form $form */
        $form = $this->getComponent('albumForm');
        /** @var DropzoneControl $dropzone */
        $dropzone = $this->getComponent('dropzone');
        $dropzone->setForm($form);
    }

    public function actionEdit(int $id): void
    {
        $this->id = $id;
        $this->album = $this->em->getAlbumRepository()->find($this->id);
        if (!$this->album) {
            $this->errorNotFoundEntity($this->id);
        }

        /** @var Form $albumForm */
        $albumForm = $this->getComponent('albumForm');
        $this->albumFormFactory->setDefaults($albumForm, $this->album);

        /** @var Form $uploadForm */
        $uploadForm = $this->getComponent('uploadForm');
        /** @var DropzoneControl $dropzone */
        $dropzone = $this->getComponent('dropzone');
        $dropzone->setForm($uploadForm);
    }

    public function renderEdit(): void
    {
        $this->template->album = $this->album;
    }

    public function handleDelete(int $id): void
    {
        $album = $this->em->getAlbumRepository()->find($id);
        if (!$album) {
            $this->errorNotFoundEntity($id);
        }

        $this->albumFacade->remove($album);
        $this->flashSuccess('_message.album.removed');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawAlbums();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleToggleActive(int $id): void
    {
        $album = $this->em->getAlbumRepository()->find($id);
        if (!$album) {
            $this->errorNotFoundEntity($id);
        }

        $album->toggleActive();
        $this->em->flush();

        $this->flashSuccess(
            sprintf('_message.album.%s', $album->isActive() ? 'show' : 'hide')
        );

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawAlbums();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    public function handleDeleteFile(int $idFile): void
    {
        $file = $this->em->getFileRepository()->find($idFile);
        if (!$file) {
            $this->errorNotFoundEntity($idFile);
        }

        $this->albumFacade->removeImage($this->album, $file);
        $this->flashSuccess('_message.album.file.removed');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentAlbumForm(): Form
    {
        $form = $this->albumFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            if ($this->album) {
                $this->album = $this->albumFacade->update($this->album, $values['title'], $values['text']);
                $this->flashSuccess('_message.album.updated');
            } else {
                $this->album = $this->albumFacade->create($values['title'], $values['text']);
                $this->flashSuccess('_message.album.created');
            }

            $this->redirect(App::ADMIN_ALBUM . 'edit', ['id' => $this->album->getId()]);
        };

        return $form;
    }

    protected function createComponentUploadForm(): Form
    {
        $form = $this->uploadFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            $this->albumFacade->addImages($this->album, $values['files']);

            $this->flashSuccess('_message.album.file.added');
            $this->redirect('this');
        };
        return $form;
    }

    protected function createComponentDropzone(): DropzoneControl
    {
        return $this->dropzoneFactory->create(true);
    }

    public function redrawAlbums(): void
    {
        $this->redrawControl('albums');
    }

    public function redrawImages(): void
    {
        $this->redrawControl('images');
    }

}