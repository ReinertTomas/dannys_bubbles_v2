<?php
declare(strict_types=1);

namespace App\Modules\Admin\Config;

use App\Model\Database\Entity\Config;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Form\Config\ConfigFilesFormFactory;
use App\UI\Form\Config\ConfigFormFactory;
use Nette\Application\UI\Form;

final class ConfigPresenter extends BaseAdminPresenter
{

    private Config $config;

    /** @inject */
    public ConfigFormFactory $configFormFactory;

    /** @inject */
    public ConfigFilesFormFactory $configFilesFormFactory;

    public function actionDefault(): void
    {
        $this->config = $this->em
            ->getConfigRepository()
            ->findOne();
    }

    public function renderDefault(): void
    {
        $this->template->config = $this->config;
    }

    protected function createComponentConfigForm(): Form
    {
        return $this->configFormFactory->create(
            $this->config,
            function (): void {
                $this->flashSuccess('messages.config.updated');
                $this->redirect('this');
            }
        );
    }

    protected function createComponentConfigFilesForm(): Form
    {
        return $this->configFilesFormFactory->create($this->config, function (): void {
            $this->flashSuccess('messages.config.updated');
            $this->redirect('this');
        });
    }

}