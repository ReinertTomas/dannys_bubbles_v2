<?php
declare(strict_types=1);

namespace App\UI\Form\Security;

final class SignInFormType
{

    public string $email;

    public string $password;

    public bool $remember;

}