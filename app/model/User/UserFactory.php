<?php
declare(strict_types=1);

namespace App\Model\User;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\User;
use App\Model\File\Image\ImageFactory;
use App\Model\File\Image\ImageInitialFactory;
use App\Model\Security\Passwords;

class UserFactory
{

    protected ImageInitialFactory $imageInitialFactory;

    protected ImageFactory $imageFactory;

    private Passwords $passwords;

    public function __construct(ImageInitialFactory $imageInitialFactory, ImageFactory $imageFactory, Passwords $passwords)
    {
        $this->imageInitialFactory = $imageInitialFactory;
        $this->imageFactory = $imageFactory;
        $this->passwords = $passwords;
    }

    public function create(UserDto $dto): User
    {
        $file = $this->imageInitialFactory->create($dto->name, $dto->surname);
        $image = $this->imageFactory->create($file, Image::TYPE_USER);

        return new User(
            $image,
            $dto->name,
            $dto->surname,
            $dto->email,
            $this->passwords->hash($dto->password)
        );
    }

}