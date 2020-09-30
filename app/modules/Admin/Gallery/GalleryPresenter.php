<?php
declare(strict_types=1);

namespace App\Modules\Admin\Gallery;

use App\Model\App;
use App\Model\File\FileInfo;
use App\Model\Gallery\GalleryFacade;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\Dropzone\DropzoneControl;
use App\UI\Control\Dropzone\IDropzoneFactory;

/**
 * @property GalleryTemplate $template
 */
final class GalleryPresenter extends BaseAdminPresenter
{

    /** @inject */
    public IDropzoneFactory $dropzoneFactory;

    /** @inject */
    public GalleryFacade $galleryFacade;

    public function renderDefault(): void
    {
        $this->template->images = $this->galleryFacade->getAll();
    }

    public function handleDeleteImage(int $idImage): void
    {
        $image = $this->galleryFacade->get($idImage);
        if ($image === null) {
            $this->errorNotFoundEntity($idImage);
        }

        $this->galleryFacade->remove($image);
        $this->flashSuccess('messages.gallery.remove');

        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect(App::ADMIN_ALBUM);
        }
    }

    protected function createComponentDropzone(): DropzoneControl
    {
        return $this->dropzoneFactory->create(
            $this,
            function (FileInfo $file): void {
                $this->galleryFacade->create($file);
            },
            function (): void {
                $this->flashSuccess('messages.upload.success');
                $this->redrawModalContent();
                $this->redrawImages();
                $this->setAjaxPostGet();
            }
        );
    }

    private function redrawImages(): void
    {
        $this->redrawControl('images');
    }

}