<?php
declare(strict_types=1);

namespace App\UI\Control;

use App\Modules\Base\BasePresenter;
use Nette\Application\Responses\FileResponse;

/**
 * 2@mixin BasePresenter
 */
trait TDocument
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
            new FileResponse($document->getPathAbsolute(), $document->getName())
        );
    }

}