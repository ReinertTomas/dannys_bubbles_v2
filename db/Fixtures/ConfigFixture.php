<?php
declare(strict_types=1);

namespace Database\Fixtures;

use App\Model\Database\Entity\Config;
use App\UI\Form\Config\ConfigFormType;
use Doctrine\Persistence\ObjectManager;

class ConfigFixture extends AbstractFixture
{

    public function getOrder(): int
    {
        return 2;
    }

    public function load(ObjectManager $manager): void
    {
        $config = $this->getConfig();

        $entity = new Config();

        $entity->setName($config->name);
        $entity->setSurname($config->surname);
        $entity->setIco($config->ico);
        $entity->setEmail($config->email);
        $entity->setWebsite($config->website);
        $entity->setFacebook($config->facebook);
        $entity->setInstagram($config->instagram);
        $entity->setYoutube($config->youtube);
        $entity->setPromoVideo($config->promoVideo);
        $entity->setPromoImage($config->promoImage);

        $manager->persist($entity);
        $manager->flush();
    }

    protected function getConfig(): ConfigFormType
    {
        $config = new ConfigFormType();

        $config->name = 'Name';
        $config->surname = 'Surname';
        $config->ico = '0011223344';
        $config->email = 'test@test.net';
        $config->website = 'www.test.net';
        $config->facebook = 'xxx';
        $config->instagram = 'xxx';
        $config->youtube = 'xxx';
        $config->promoVideo = 'xxx';
        $config->promoImage = 'xxx';

        return $config;
    }

}