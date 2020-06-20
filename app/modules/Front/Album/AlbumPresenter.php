<?php
declare(strict_types=1);

namespace App\Modules\Front\Album;

use App\Model\Database\Entity\Album;
use App\Modules\Front\BaseFrontPresenter;

final class AlbumPresenter extends BaseFrontPresenter
{

    private ?Album $album;

    /** @var Album[] */
    private array $albums;

    public function actionDefault(): void
    {
        $this->albums = $this->em
            ->getAlbumRepository()
            ->findManyByActive();
    }

    public function renderDefault(): void
    {
        $this->template->albums = $this->albums;
    }

    public function actionDetail(int $id): void
    {
        $this->album = $this->em
            ->getAlbumRepository()
            ->find($id);

        if ($this->album === null) {
            $this->errorNotFoundEntity($id);
        }
    }

    public function renderDetail(): void
    {
        $this->template->album = $this->album;
    }

}