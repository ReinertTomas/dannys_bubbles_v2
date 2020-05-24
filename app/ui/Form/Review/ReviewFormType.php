<?php
declare(strict_types=1);

namespace App\UI\Form\Review;

final class ReviewFormType
{

    public string $title;

    public ?string $author;

    public string $text;

}