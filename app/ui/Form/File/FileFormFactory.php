<?php
declare(strict_types=1);

namespace App\UI\Form\File;

use App\Model\File\FileUploader;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class FileFormFactory
{

    private FormFactory $formFactory;

    private FileUploader $fileUploader;

    public function __construct(FormFactory $formFactory, FileUploader $fileUploader)
    {
        $this->formFactory = $formFactory;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param callable(App\Model\File\FileInfo): void $onSuccess
     * @return Form
     */
    public function create(callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();
        $form->addUpload('file');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(FileFormData::class);

        $form->onSuccess[] = function (Form $form, FileFormData $data) use ($onSuccess): void {
            $file = $this->fileUploader->upload($data->file);
            ($onSuccess)($file);
        };

        return $form;
    }

}