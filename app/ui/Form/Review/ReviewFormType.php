<?php
declare(strict_types=1);

namespace App\UI\Form\Review;

use Nette\Http\FileUpload;

final class ReviewFormType
{

    public FileUpload $image;

    public string $title;

    public ?string $author;

    public string $text;

}