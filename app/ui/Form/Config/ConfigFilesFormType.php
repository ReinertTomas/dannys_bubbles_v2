<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use Nette\Http\FileUpload;

final class ConfigFilesFormType
{

    public FileUpload $show;

    public FileUpload $business;

    public FileUpload $personal;

}