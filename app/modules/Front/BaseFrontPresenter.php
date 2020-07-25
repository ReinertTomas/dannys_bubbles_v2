<?php
declare(strict_types=1);

namespace App\Modules\Front;

use App\Model\Database\Entity\Config;
use App\Modules\Base\UnsecuredPresenter;
use Nette\Application\Responses\FileResponse;

abstract class BaseFrontPresenter extends UnsecuredPresenter
{

    protected Config $config;

    protected function startup(): void
    {
        parent::startup();
        $this->config = $this->em->getConfigRepository()->findOne();
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->config = $this->config;
    }

    public function handleDownloadDocument(int $idDocument): void
    {
        $document = $this->em
            ->getDocumentRepository()
            ->find($idDocument);
        if ($document === null) {
            $this->flashWarning('messages.config.condition.none');
            $this->redirect('this');
        }

        $this->sendResponse(
            new FileResponse($document->getPathAbsolute(), $document->getName())
        );
    }

}