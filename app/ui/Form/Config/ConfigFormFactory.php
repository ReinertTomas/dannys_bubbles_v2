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

    public function create(): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addText('name', 'Name')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Name (required)');
        $form->addText('surname', 'Surname')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Surname (required)');
        $form->addText('ico', 'ICO')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'ICO (required)');
        $form->addEmail('email', 'Email')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Email (required)');
        $form->addText('website', 'Website')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Website (required)');
        $form->addText('facebook', 'Facebook')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Facebook (required)');
        $form->addText('instagram', 'Instagram')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Instagram (required)');
        $form->addText('youtube', 'Youtube')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Youtube (required)');
        $form->addUpload('condition', 'Terms and Conditions')
            ->setRequired();
        $form->addText('promoVideo', 'Promo Video')
            ->setRequired()
            ->setHtmlAttribute('placeholder', 'Promo Video (required)');
        $form->addSubmit('submit', 'Save');

        return $form;
    }

    public function setDefaults(Form $form, Config $config): void
    {
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

}