<?php
declare(strict_types=1);

namespace App\Modules\Admin\Config;

use App\Model\Config\ConfigDto;
use App\Model\Config\ConfigFacade;
use App\Model\Database\Entity\Config;
use App\Model\File\FileInfo;
use App\Model\File\FileUploader;
use App\Modules\Admin\BaseAdminPresenter;
use App\UI\Control\File\FileUploadControl;
use App\UI\Control\File\FileUploadFactory;
use App\UI\Form\Config\ConfigFormFactory;
use Nette\Application\UI\Form;

/**
 * @property ConfigTemplate $template
 */
final class ConfigPresenter extends BaseAdminPresenter
{

    private Config $config;

    /** @inject */
    public ConfigFormFactory $configFormFactory;

    /** @inject */
    public ConfigFacade $configFacade;

    /** @inject */
    public FileUploader $fileUploader;

    /** @inject */
    public FileUploadFactory $fileUploadFactory;

    public function actionDefault(): void
    {
        $this->config = $this->configFacade->getConfig();
    }

    public function renderDefault(): void
    {
        $this->template->config = $this->config;
    }

    protected function createComponentConfigForm(): Form
    {
        return $this->configFormFactory->create(
            $this->config,
            function (Form $form, ConfigDto $dto): void {
                $this->configFacade->update($this->config, $dto);

                $this->flashSuccess('messages.config.updated');
                $this->redirect('this');
            }
        );
    }

    protected function createComponentShow(): FileUploadControl
    {
        return $this->fileUploadFactory->create($this, 'Změnit podmínky představení', function (FileInfo $file): void {
            $this->configFacade->changeDocumentShow($this->config, $file);
            $this->flashSuccess('messages.config.updated');
            $this->redirect('this');
        });
    }

    protected function createComponentBusiness(): FileUploadControl
    {
        return $this->fileUploadFactory->create($this, 'Změnit obchodní podmínky', function (FileInfo $file): void {
            $this->configFacade->changeDocumentBusiness($this->config, $file);
            $this->flashSuccess('messages.config.updated');
            $this->redirect('this');
        });
    }

    protected function createComponentPersonal(): FileUploadControl
    {
        return $this->fileUploadFactory->create($this, 'Změnit ochranu osobních údajů', function (FileInfo $file): void {
            $this->configFacade->changeDocumentPersonal($this->config, $file);
            $this->flashSuccess('messages.config.updated');
            $this->redirect('this');
        });
    }

}