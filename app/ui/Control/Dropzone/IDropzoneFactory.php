<?php
declare(strict_types=1);

namespace App\UI\Control\Dropzone;

use App\Modules\Base\BasePresenter;

interface IDropzoneFactory
{

    public function create(BasePresenter $presenter, callable $onUpload, callable $onSuccess): DropzoneControl;

}