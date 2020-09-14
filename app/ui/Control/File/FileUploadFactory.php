<?php
declare(strict_types=1);

namespace App\UI\Control\File;

use App\Modules\Base\BasePresenter;

interface FileUploadFactory
{

    public function create(BasePresenter $presenter, string $title, callable $onSuccess): FileUploadControl;

}