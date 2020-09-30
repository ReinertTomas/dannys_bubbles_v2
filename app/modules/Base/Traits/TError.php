<?php
declare(strict_types=1);

namespace App\Modules\Base\Traits;

use App\Modules\Base\BasePresenter;
use Nette\Http\IResponse;

/**
 * @mixin BasePresenter
 */
trait TError
{

    public function errorNotFoundEntity(int $id): void
    {
        $this->error(
            sprintf('messages.entity.notfound "%d"', $id),
            IResponse::S404_NOT_FOUND
        );
    }

}