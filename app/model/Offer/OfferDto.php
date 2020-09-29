<?php
declare(strict_types=1);

namespace App\Model\Offer;

use App\UI\Form\Offer\OfferFormData;

class OfferDto
{

    public string $title;

    public string $description;

    public string $text;

    /**
     * @param array<mixed> $data
     * @return OfferDto
     */
    public static function fromArray(array $data): OfferDto
    {
        $dto = new OfferDto();
        $dto->title = $data['title'];
        $dto->description = $data['description'];
        $dto->text = $data['text'];

        return $dto;
    }

    /**
     * @param OfferFormData $data
     * @return OfferDto
     */
    public static function fromForm(OfferFormData $data): OfferDto
    {
        $dto = new OfferDto();
        $dto->title = $data->title;
        $dto->description = $data->description;
        $dto->text = $data->text;

        return $dto;
    }

}