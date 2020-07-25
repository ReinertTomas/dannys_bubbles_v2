<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use App\Model\Database\Entity\Config;
use App\Model\Database\EntityManager;
use App\Model\File\FileTemporaryFactory;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ConfigFilesFormFactory
{

    private FormFactory $formFactory;

    private EntityManager $em;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(FormFactory $formFactory, EntityManager $em, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function create(Config $config, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addUpload('show', 'Podmínky představení');
        $form->addUpload('business', 'Obchodní podmínky');
        $form->addUpload('personal', 'Ochrana osobních údajů');

        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ConfigFilesFormType::class);

        $form->onSuccess[] = function (Form $form, ConfigFilesFormType $formType) use ($config, $onSuccess): void {
            // Show
            if ($formType->show->isOk()) {
                $config->changeDocumentShow(
                    $this->fileTemporaryFactory->createFromUpload($formType->show)
                );
            }
            // Business
            if ($formType->business->isOk()) {
                $config->changeDocumentBusiness(
                    $this->fileTemporaryFactory->createFromUpload($formType->business)
                );
            }
            // Personal
            if ($formType->personal->isOk()) {
                $config->changeDocumentPersonal(
                    $this->fileTemporaryFactory->createFromUpload($formType->personal)
                );
            }
            $this->em->flush();
            ($onSuccess)();
        };

        return $form;
    }

}