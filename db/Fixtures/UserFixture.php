<?php
declare(strict_types=1);

namespace Database\Fixtures;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\User;
use App\Model\File\Image\ImageInitialCreator;
use App\Model\Security\Passwords;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{

    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var ImageInitialCreator $imageService */
        $imageService = $this->container->getByType(ImageInitialCreator::class);
        /** @var Passwords $passwordService */
        $passwordService = $this->container->getByType(Passwords::class);

        foreach ($this->getUsers() as $user) {
            $fileInfo = $imageService->create($user['name'], $user['surname']);

            $entity = User::create(
                Image::create($fileInfo, User::NAMESPACE, false),
                $user['name'],
                $user['surname'],
                $user['email'],
                $passwordService->hash($user['password'])
            );
            $entity->changeRole($user['role']);
            $entity->activate();

            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getUsers(): iterable
    {
        yield [
            'name' => 'Admin',
            'surname' => 'Administrator',
            'email' => 'admin@admin.net',
            'password' => 'Admin123!',
            'role' => User::ROLE_ADMIN
        ];
        yield [
            'name' => 'Test',
            'surname' => 'Tester',
            'email' => 'test@test.net',
            'password' => 'Test123!',
            'role' => User::ROLE_USER
        ];
    }

}