<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use App\Model\Database\Entity\Config;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ConfigFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param Config|null $config
     * @param callable(Form, ConfigFormType): void $onSuccess
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
        $form->addUpload('condition', 'Terms and Conditions');
        $form->addText('promoVideo', 'Promo Video');
        $form->addSubmit('submit', 'Save');
        $form->setMappedType(ConfigFormType::class);

        $form->onSuccess[] = $onSuccess;

        if ($config !== null) {
            $form->setDefaults([
                'name' => $config->getName(),
                'surname' => $config->getSurname(),
                'ico' => $config->getIco(),
                'email' => $config->getEmail(),
                'website' => $config->getWebsite(),
                'facebook' => $config->getFacebook(),
                'instagram' => $config->getInstagram(),
                'youtube' => $config->getYoutube(),
                'promoVideo' => $config->getPromoVideo()
            ]);
        }

        return $form;
    }

}