<?php
declare(strict_types=1);

namespace App\Modules\Admin\Gallery;

use App\Model\Database\Entity\Gallery;
use App\Model\File\IFileInfo;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\Dropzone\DropzoneControl;
use App\UI\Control\Dropzone\IDropzoneFactory;

final class GalleryPresenter extends BaseAdminPresenter
{

    /** @inject */
    public IDropzoneFactory $dropzoneFactory;

    public function renderDefault(): void
    {
        $this->template->galleries = $this->em
            ->getGalleryRepository()
            ->findAll();;
    }

    public function handleDeleteGallery(int $idGallery): void
    {
        $gallery = $this->em
            ->getGalleryRepository()
            ->find($idGallery);
        if ($gallery === null) {
            $this->errorNotFoundEntity($idGallery);
        }

        $this->em->remove($gallery);
        $this->em->flush();

        $this->flashSuccess('messages.image.remove');
        if ($this->isAjax()) {
            $this->redrawFlashes();
            $this->redrawImages();
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

    protected function createComponentDropzone(): DropzoneControl
    {
        return $this->dropzoneFactory->create(
            $this,
            function (IFileInfo $file): void {
                $gallery = new Gallery($file);
                $this->em->persist($gallery);
                $this->em->flush();
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