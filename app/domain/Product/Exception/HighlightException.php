<?php
declare(strict_types=1);

namespace App\Domain\Product\Exception;

use App\Model\Exception\LogicException;
use App\Model\Exception\TExceptionExtra;

final class HighlightException extends LogicException
{

    use TExceptionExtra;

}