<?php
declare(strict_types=1);

namespace App\Modules\Base\Traits;

use App\Modules\Base\BasePresenter;
use Nette\Application\Responses\FileResponse;

/**
 * @mixin BasePresenter
 */
trait TDocumentDownload
{

    public function handleDownloadDocument(int $idDocument): void
    {
        $document = $this->em
            ->getDocumentRepository()
            ->find($idDocument);
        if ($document === null) {
            $this->flashWarning('messages.document.none');
            $this->redirect('this');
        }

        $this->sendResponse(
            new FileResponse($document->getPathAbsolute(), $document->getOriginalName())
        );
    }

}