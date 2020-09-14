<?php
declare(strict_types=1);

namespace App\Model\User;

class UserDto
{

    public string $name;

    public string $surname;

    public string $email;

    public string $password;

    /**
     * @param array<mixed> $data
     * @return UserDto
     */
    public static function fromArray(array $data): UserDto
    {
        $dto = new UserDto();
        $dto->name = $data['name'];
        $dto->surname = $data['surname'];
        $dto->email = $data['email'];
        $dto->password = $data['password'];

        return $dto;
    }

}