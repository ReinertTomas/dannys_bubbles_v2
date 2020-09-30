<?php
declare(strict_types=1);

namespace App\Model\User;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\User;
use App\Model\File\Image\ImageFactory;
use App\Model\Security\Passwords;

class UserFactory
{

    protected ImageFactory $imageFactory;

    private Passwords $passwords;

    public function __construct(ImageFactory $imageFactory, Passwords $passwords)
    {
        $this->imageFactory = $imageFactory;
        $this->passwords = $passwords;
    }

    public function create(UserDto $dto): User
    {
        $image = $this->imageFactory->createFromInitial($dto->name, $dto->surname, Image::TYPE_USER);
        return new User(
            $image,
            $dto->name,
            $dto->surname,
            $dto->email,
            $this->passwords->hash($dto->password)
        );
    }

}