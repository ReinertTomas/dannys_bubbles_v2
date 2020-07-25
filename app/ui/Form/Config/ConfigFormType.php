<?php
declare(strict_types=1);

namespace App\UI\Form\Config;

use Nette\Http\FileUpload;

final class ConfigFormType
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

}