<?php
declare(strict_types=1);

namespace Database\Fixtures;

use App\Model\User\Role\Role;
use App\Model\User\UserDto;
use App\Model\User\UserFactory;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{

    public function getOrder(): int
    {
        return 2;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var UserFactory $userFactory */
        $userFactory = $this->container->getByType(UserFactory::class);

        foreach ($this->getUsers() as $user) {
            $entity = $userFactory->create(UserDto::fromArray($user));
            $entity->changeRole(Role::ADMIN);
            $entity->activate();

            $manager->persist($entity);
            $manager->flush();
        }
    }

    public function getUsers(): iterable
    {
        yield [
            'name' => 'Admin',
            'surname' => 'Administrator',
            'email' => 'admin@admin.net',
            'password' => 'Admin123!'
        ];
    }

}