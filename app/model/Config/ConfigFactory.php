<?php
declare(strict_types=1);

namespace App\Model\Config;

use App\Model\Database\Entity\Config;

class ConfigFactory
{

    public function create(ConfigDto $dto): Config
    {
        $config = new Config();
        $config->setName($dto->name);
        $config->setSurname($dto->surname);
        $config->setIco($dto->ico);
        $config->setEmail($dto->email);
        $config->setWebsite($dto->website);
        $config->setFacebook($dto->facebook);
        $config->setInstagram($dto->instagram);
        $config->setYoutube($dto->youtube);
        $config->setPromoVideo($dto->promoVideo);
        $config->setPromoImage($dto->promoImage);
        $config->setAboutMe($dto->aboutMe);

        return $config;
    }

}