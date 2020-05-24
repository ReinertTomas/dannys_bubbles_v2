<?php
declare(strict_types=1);

namespace App\Model\Exception;

use Exception;

/**
 * @mixin Exception
 */
trait TExceptionExtra
{

    public static function create(): self
    {
        return new static();
    }

    public function withMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function withCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

}