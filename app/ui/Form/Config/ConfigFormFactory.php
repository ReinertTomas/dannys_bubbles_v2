<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use App\Model\Config\ConfigDto;
use App\Model\Config\ConfigFacade;
use App\Model\Database\Entity\Config;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ConfigFormFactory
{

    private FormFactory $formFactory;

    private ConfigFacade $configFacade;

    public function __construct(FormFactory $formFactory, ConfigFacade $configFacade)
    {
        $this->formFactory = $formFactory;
        $this->configFacade = $configFacade;
    }

    /**
     * @param Config|null $config
     * @param callable(): void $onSuccess
     * @return Form
     */
    public function create(?Config $config, callable $onSuccess): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('name', 'Name (required)')
            ->setRequired();
        $form->addText('surname', 'Surname (required)')
            ->setRequired();
        $form->addText('ico', 'ICO (required)')
            ->setRequired();
        $form->addEmail('email', 'Email (required)')
            ->setRequired();
        $form->addText('website', 'Website (required)')
            ->setRequired();
        $form->addText('facebook', 'Facebook (required)')
            ->setRequired();
        $form->addText('instagram', 'Instagram (required)')
            ->setRequired();
        $form->addText('youtube', 'Youtube (required)')
            ->setRequired();
        $form->addText('promoVideo', 'Promo Video');
        $form->addTextArea('aboutMe', 'About Me');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ConfigDto::class);

        $form->onSuccess[] = $onSuccess;

        if ($config !== null) {
            $form->setDefaults(ConfigDto::toArray($config));
        }

        return $form;
    }

}