<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use App\Model\Database\Entity\Config;
use App\Model\Database\EntityManager;
use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class ConfigFormFactory
{

    private FormFactory $formFactory;

    private EntityManager $em;

    public function __construct(FormFactory $formFactory, EntityManager $em)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
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
        $form->setMappedType(ConfigFormType::class);

        $form->onSuccess[] = function (Form $form, ConfigFormType $formType) use ($config, $onSuccess): void {
            $config->setName($formType->name);
            $config->setSurname($formType->surname);
            $config->setIco($formType->ico);
            $config->setEmail($formType->email);
            $config->setWebsite($formType->website);
            $config->setFacebook($formType->facebook);
            $config->setInstagram($formType->instagram);
            $config->setYoutube($formType->youtube);
            $config->setPromoVideo($formType->promoVideo);
            $config->setAboutMe($formType->aboutMe);
            $this->em->flush();

            ($onSuccess)();
        };

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
                'promoVideo' => $config->getPromoVideo(),
                'aboutMe' => $config->getAboutMe()
            ]);
        }

        return $form;
    }

}