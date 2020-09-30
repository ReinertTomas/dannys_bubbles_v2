<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Model\File\FileUploader;
use App\Modules\Base\SecuredPresenter;
use App\UI\Control\File\FileUploadFactory;

abstract class BaseAdminPresenter extends SecuredPresenter
{

    /** @inject */
    public FileUploader $fileUploader;

    /** @inject */
    public FileUploadFactory $fileUploadFactory;

}