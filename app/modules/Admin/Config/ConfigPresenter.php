<?php
declare(strict_types=1);

namespace App\Modules\Admin\Config;

use App\Domain\Config\ConfigFacade;
use App\Model\Database\Entity\Config;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Config\ConfigFormFactory;
use App\UI\Form\Config\ConfigFormType;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Form;

final class ConfigPresenter extends BaseAdminPresenter
{

    private Config $config;

    /** @inject */
    public ConfigFormFactory $configFormFactory;

    /** @inject */
    public ConfigFacade $configFacade;

    public function actionDefault(): void
    {
        $this->config = $this->configFacade->get();
    }

    public function renderDefault(): void
    {
        $this->template->config = $this->config;
    }

    public function handleDownloadCondition(): void
    {
        $document = $this->config->getCondition();
        if ($document === null) {
            $this->flashWarning('messages.config.condition.none');
            $this->redirect('this');
        }

        $this->sendResponse(
            new FileResponse($document->getPathAbsolute(), $document->getName())
        );
    }

    protected function createComponentConfigForm(): Form
    {
        return $this->configFormFactory->create(
            $this->config,
            function (Form $form, ConfigFormType $formType): void {
                $this->configFacade->update($this->config, $formType);

                $this->flashSuccess('messages.config.updated');
                $this->redirect('this');
            }
        );
    }

}