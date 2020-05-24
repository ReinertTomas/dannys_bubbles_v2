<?php
declare(strict_types=1);

namespace App\Model\Exception\Runtime;

use App\Model\Exception\RuntimeException;
use App\Model\Exception\TExceptionExtra;

final class IOException extends RuntimeException
{

    use TExceptionExtra;

}