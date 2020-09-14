<?php
declare(strict_types=1);

namespace App\Modules\Admin\Test;

use App\Model\Database\Entity\Image;
use App\Model\File\FileUploader;
use App\Model\File\Image\ImageFactory;
use App\Modules\Admin\BaseAdminPresenter;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;

class TestPresenter extends BaseAdminPresenter
{

    /** @inject */
    public FileUploader $fileUploader;

    /** @inject */
    public ImageFactory $imageFactory;

    protected function createComponentForm(): Form
    {
        $form = new Form();

        $form->addUpload('image');
        $form->addSubmit('submit', 'Save');

        $form->onSuccess[] = function (Form $form, FormType $formType): void {
            $file = $this->fileUploader->upload($formType->image);
            $image = $this->imageFactory->create($file, Image::TYPE_USER);

            $this->em->persist($image);
            $this->em->flush();
            die();
        };

        return $form;
    }

}

class FormType {

    public FileUpload $image;

}