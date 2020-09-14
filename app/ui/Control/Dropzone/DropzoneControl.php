<?php
declare(strict_types=1);

namespace App\UI\Control\Dropzone;

use App\Model\File\Exception\FileUploadErrorException;
use App\Model\File\Exception\ImageAllowOnlyException;
use App\Model\File\FileUploader;
use App\Modules\Base\BasePresenter;
use App\UI\Control\BaseControl;
use Nette\Http\FileUpload;

/**
 * @property DropzoneTemplate $template
 */
final class DropzoneControl extends BaseControl
{

    private const ACCEPT_IMAGES = 'image/*';

    private ?string $acceptedFiles;

    /** @var callable */
    private $onUpload;

    /** @var callable */
    private $onSuccess;

    private FileUploader $fileUploader;

    public function __construct(BasePresenter $presenter, callable $onUpload, callable $onSuccess, FileUploader $fileUploader)
    {
        $this->presenter = $presenter;
        $this->onUpload = $onUpload;
        $this->onSuccess = $onSuccess;
        $this->acceptedFiles = null;
        $this->fileUploader = $fileUploader;
    }

    public function acceptOnlyImages(): void
    {
        $this->acceptedFiles = self::ACCEPT_IMAGES;
    }

    public function render(): void
    {
        $this->template->acceptedFiles = $this->acceptedFiles;
        $this->template->setFile(__DIR__ . '/templates/dropzone.latte');
        $this->template->render();
    }

    public function handleUpload(): void
    {
        /** @var FileUpload[] $fileUploads */
        $fileUploads = $this->presenter
            ->getRequest()
            ->getFiles();

        $fileUpload = array_values($fileUploads)[0];
        if (!$fileUpload->isOk()) {
            throw new FileUploadErrorException($fileUpload->getError());
        }
        if ($this->acceptedFiles === self::ACCEPT_IMAGES and !$fileUpload->isImage()) {
            throw new ImageAllowOnlyException($fileUpload->getName());
        }

        $file = $this->fileUploader->upload($fileUpload);
        ($this->onUpload)($file);
    }

    public function handleSuccess(): void
    {
        ($this->onSuccess)();
    }

}