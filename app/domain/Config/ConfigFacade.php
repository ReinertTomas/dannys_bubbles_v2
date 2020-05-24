<?php
declare(strict_types=1);

namespace App\Domain\Config;

use App\Model\Database\Entity\Config;
use App\Model\Database\EntityManager;
use App\Model\File\FileTemporaryFactory;
use App\UI\Form\Config\ConfigFormType;

class ConfigFacade
{

    private EntityManager $em;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(EntityManager $em, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->em = $em;
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function get(): Config
    {
        return $this->em
            ->getConfigRepository()
            ->findOne();
    }

    public function update(Config $config, ConfigFormType $formType): Config
    {
        if ($formType->condition->isOk()) {
            $config->changeCondition(
                $this->fileTemporaryFactory->createFromUpload($formType->condition)
            );
        }

        $config->setName($formType->name);
        $config->setSurname($formType->surname);
        $config->setIco($formType->ico);
        $config->setEmail($formType->email);
        $config->setWebsite($formType->website);
        $config->setFacebook($formType->facebook);
        $config->setInstagram($formType->instagram);
        $config->setYoutube($formType->youtube);
        $config->setPromoVideo($formType->promoVideo);

        $this->em->flush();

        return $config;
    }

}