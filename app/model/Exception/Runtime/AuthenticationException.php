<?php
declare(strict_types=1);

namespace App\Model\Exception\Runtime;

use App\Model\Exception\TExceptionExtra;
use Nette\Security\AuthenticationException as NetteAuthenticationException;

final class AuthenticationException extends NetteAuthenticationException
{

    use TExceptionExtra;

}