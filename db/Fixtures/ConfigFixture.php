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

        $config->name = 'Daniel';
        $config->surname = 'Kunášek';
        $config->ico = '07365551';
        $config->email = 'dannysbubbles@gmail.com';
        $config->website = 'www.dannysbubbles.com';
        $config->facebook = 'https://www.facebook.com/Dannysbubbles';
        $config->instagram = 'https://www.instagram.com/dannysbubbles';
        $config->youtube = 'https://www.youtube.com/channel/UC86z1vsm8LW0IqFA9TdQ7OQ';
        $config->promoVideo = 'xxx';
        $config->promoImage = 'xxx';

        return $config;
    }

}