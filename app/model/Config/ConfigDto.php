<?php
declare(strict_types=1);

namespace App\Model\Config;

use App\Model\Database\Entity\Config;

class ConfigDto
{

    public string $name;

    public string $surname;

    public string $ico;

    public string $email;

    public string $website;

    public string $facebook;

    public string $instagram;

    public string $youtube;

    public ?string $promoVideo;

    public ?string $promoImage;

    public string $aboutMe;

    /**
     * @param array<mixed> $data
     * @return ConfigDto
     */
    public static function fromArray(array $data): ConfigDto
    {
        $dto = new ConfigDto();
        $dto->name = $data['name'];
        $dto->surname = $data['surname'];
        $dto->ico = $data['ico'];
        $dto->email = $data['email'];
        $dto->website = $data['website'];
        $dto->facebook = $data['facebook'];
        $dto->instagram = $data['instagram'];
        $dto->youtube = $data['youtube'];
        $dto->promoVideo = $data['promoVideo'];
        $dto->promoImage = $data['promoImage'];
        $dto->aboutMe = $data['aboutMe'];

        return $dto;
    }

    /**
     * @param Config $config
     * @return array<mixed>
     */
    public static function toArray(Config $config): array
    {
        return [
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
        ];
    }

}