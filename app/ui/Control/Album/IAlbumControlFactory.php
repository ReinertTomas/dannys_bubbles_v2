<?php
declare(strict_types=1);

namespace App\UI\Control\Album;

use App\Model\Database\Entity\Album;
use App\Modules\Base\BasePresenter;

interface IAlbumControlFactory
{

    public function create(BasePresenter $presenter, Album $album): AlbumControl;

}