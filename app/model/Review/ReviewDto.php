<?php
declare(strict_types=1);

namespace App\Model\Review;

class ReviewDto
{

    public string $title;

    public string $name;

    public ?string $surname;

    public string $text;

    public static function fromArray(array $data): self
    {
        $dto = new ReviewDto();
        $dto->title = $data['title'];
        $dto->name = $data['name'];
        $dto->surname = $data['surname'];
        $dto->text = $data['text'];

        return $dto;
    }

}