<?php
declare(strict_types=1);

namespace App\UI\Control\Dropzone;

use App\Model\Exception\Runtime\InvalidStateException;
use App\Model\File\FileTemporaryFactory;
use App\Modules\Base\BasePresenter;
use App\UI\Control\BaseControl;
use Nette\Http\FileUpload;

final class DropzoneControl extends BaseControl
{

    private const ACCEPT_IMAGES = 'image/*';

    private ?string $acceptedFiles;

    /** @var callable */
    private $onUpload;

    /** @var callable */
    private $onSuccess;

    private FileTemporaryFactory $factory;

    public function __construct(BasePresenter $presenter, callable $onUpload, callable $onSuccess, FileTemporaryFactory $factory)
    {
        $this->presenter = $presenter;
        $this->onUpload = $onUpload;
        $this->onSuccess = $onSuccess;
        $this->acceptedFiles = null;
        $this->factory = $factory;
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
            throw InvalidStateException::create()
                ->withMessage('File upload failed.');
        }
        if ($this->acceptedFiles === self::ACCEPT_IMAGES AND !$fileUpload->isImage()) {
            throw InvalidStateException::create()
                ->withMessage('Allow upload only images.');
        }

        $file = $this->factory->createFromUpload($fileUpload);
        ($this->onUpload)($file);
    }

    public function handleSuccess(): void
    {
        ($this->onSuccess)();
    }

}