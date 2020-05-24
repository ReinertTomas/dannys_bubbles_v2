<?php
declare(strict_types=1);

namespace App\UI\Form\User;

use Nette\Http\FileUpload;

final class UserFormType
{

    public FileUpload $image;

    public string $name;

    public string $surname;

    public string $email;

}