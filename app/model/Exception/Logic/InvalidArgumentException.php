<?php
declare(strict_types=1);

namespace App\Model\Exception\Logic;

use App\Model\Exception\LogicException;
use App\Model\Exception\TExceptionExtra;

final class InvalidArgumentException extends LogicException
{

    use TExceptionExtra;

}