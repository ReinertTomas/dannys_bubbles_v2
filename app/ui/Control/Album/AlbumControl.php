<?php
declare(strict_types=1);

namespace App\UI\Control\Album;

use App\Model\Database\Entity\Album;
use App\Modules\Base\BasePresenter;
use App\UI\Control\BaseControl;

final class AlbumControl extends BaseControl
{

    private Album $album;

    public function __construct(BasePresenter $presenter, Album $album)
    {
        $this->presenter = $presenter;
        $this->album = $album;
    }

    public function render(): void
    {
        $this->template->album = $this->album;
        $this->template->setFile(__DIR__ . '/templates/album.latte');
        $this->template->render();
    }

}