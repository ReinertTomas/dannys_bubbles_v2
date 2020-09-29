<?php
declare(strict_types=1);

namespace App\Model\User;

use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Database\Repository\UserRepository;
use App\Model\Security\Exception\PasswordEqualException;
use App\Model\Security\Exception\PasswordVerifyException;
use App\Model\Security\Passwords;
use App\Model\User\Exception\EmailUniqueException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserFacade
{

    private EntityManager $em;

    private UserRepository $userRepository;

    private Passwords $passwords;

    private UserFactory $userFactory;

    public function __construct(EntityManager $em, Passwords $passwords, UserFactory $userFactory)
    {
        $this->em = $em;
        $this->userRepository = $em->getUserRepository();
        $this->passwords = $passwords;
        $this->userFactory = $userFactory;
    }

    public function get(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function create(UserDto $dto): User
    {
        $user = $this->userFactory->create($dto);
        $user->activate();

        try {
            $this->em->persist($user);
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EmailUniqueException('messages.user.unique');
        }

        return $user;
    }

    public function update(User $user, UserDto $dto): void
    {
        $user->changeName($dto->name);
        $user->changeSurname($dto->surname);
        $user->changeEmail($dto->email);

        try {
            $this->em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new EmailUniqueException('messages.user.unique');
        }
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function changeRole(User $user, string $role): void
    {
        $user->changeRole($role);
        $this->em->flush();
    }

    public function changePassword(User $user, string $passwordOld, string $passwordNew): void
    {
        if (!$this->passwords->verify($passwordOld, $user->getPassword())) {
            throw new PasswordVerifyException('messages.credentials.wrong');
        }
        if ($passwordOld === $passwordNew) {
            throw new PasswordEqualException('messages.password.equal');
        }

        $user->changePassword($this->passwords->hash($passwordNew));
        $this->em->flush();
    }

    public function changeState(User $user, int $state): void
    {
        $user->changeState($state);
        $this->em->flush();
    }

}