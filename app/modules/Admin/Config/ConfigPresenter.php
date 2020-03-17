<?php
declare(strict_types=1);

namespace App\Modules\Admin\Config;

use App\Domain\Config\ConfigFacade;
use App\Model\Database\Entity\Config;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Config\ConfigFormFactory;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Form;
use Nette\Http\Response;

final class ConfigPresenter extends BaseAdminPresenter
{

    private Config $config;

    /** @inject */
    public ConfigFormFactory $configFormFactory;

    /** @inject */
    public ConfigFacade $configFacade;

    public function actionDefault(): void
    {
        $this->config = $this->em->getConfigRepository()->findOne();
        if (!$this->config) {
            $this->errorNotFoundEntity(1);
        }

        /** @var Form $form */
        $form = $this->getComponent('configForm');
        $this->configFormFactory->setDefaults($form, $this->config);
    }

    public function handleDownloadCondition(): void
    {
        $path = $this->dm->getWWW() . $this->config->getCondition()->getPath();
        $name = $this->config->getCondition()->getName();
        $this->sendResponse(
            new FileResponse($path, $name)
        );
    }

    protected function createComponentConfigForm(): Form
    {
        $form = $this->configFormFactory->create();
        $form->onSuccess[] = function (Form $form): void {
            $values = (array)$form->getValues();

            $this->configFacade->update($this->config, $values);

            $this->flashSuccess('_message.config.updated');
            $this->redirect('this');
        };
        return $form;
    }

}