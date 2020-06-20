<?php
declare(strict_types=1);

namespace App\UI\Form\Offer;

use Nette\Http\FileUpload;

final class OfferFormType
{

    public FileUpload $image;

    public string $title;

    public string $description;

    public string $text;

}