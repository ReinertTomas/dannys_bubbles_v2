<?php
declare(strict_types=1);

namespace App\Model\Config;

use App\Model\Database\Entity\Config;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\ConfigRepository;
use App\Model\File\FileInfo;

class ConfigFacade
{

    private EntityManager $em;

    private ConfigRepository $configRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->configRepository = $em->getConfigRepository();
    }

    public function getConfig(): Config
    {
        return $this->em
            ->getConfigRepository()
            ->findOne();
    }

    public function update(Config $config, ConfigDto $dto): void
    {
        $config->setName($dto->name);
        $config->setSurname($dto->surname);
        $config->setIco($dto->ico);
        $config->setEmail($dto->email);
        $config->setWebsite($dto->website);
        $config->setFacebook($dto->facebook);
        $config->setInstagram($dto->instagram);
        $config->setYoutube($dto->youtube);
        $config->setPromoVideo($dto->promoVideo);
        $config->setAboutMe($dto->aboutMe);

        $this->em->flush();
    }

    public function changeDocumentShow(Config $config, FileInfo $file): void
    {
        $config->changeDocumentShow($file);
        $this->em->flush();
    }

    public function changeDocumentBusiness(Config $config, FileInfo $file): void
    {
        $config->changeDocumentBusiness($file);
        $this->em->flush();
    }

    public function changeDocumentPersonal(Config $config, FileInfo $file): void
    {
        $config->changeDocumentPersonal($file);
        $this->em->flush();
    }

}