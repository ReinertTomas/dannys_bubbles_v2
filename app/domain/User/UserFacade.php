<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Model\Database\Entity\Image;
use App\Model\Database\Entity\User;
use App\Model\Database\EntityManager;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\File\FileTemporaryFactory;
use App\Model\File\Image\ImageInitialCreator;
use App\Model\Security\Passwords;
use App\UI\Form\Security\PasswordFormType;
use App\UI\Form\Security\RoleFormType;
use App\UI\Form\User\RegisterFormType;
use App\UI\Form\User\UserFormType;

class UserFacade
{

    private EntityManager $em;

    private Passwords $passwords;

    private ImageInitialCreator $imageInitialCreator;

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(EntityManager $em, Passwords $passwords, ImageInitialCreator $imageInitialCreator, FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->em = $em;
        $this->passwords = $passwords;
        $this->imageInitialCreator = $imageInitialCreator;
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function get(int $id): ?User
    {
        return $this->em
            ->getUserRepository()
            ->find($id);
    }

    public function create(RegisterFormType $formType): User
    {
        $fileInfo = $this->imageInitialCreator->create($formType->name, $formType->surname);

        $user = User::create(
            Image::create($fileInfo, User::NAMESPACE, false),
            $formType->name,
            $formType->surname,
            $formType->email,
            $this->passwords->hash($formType->password)
        );
        $user->activate();

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function update(User $user, UserFormType $formType): User
    {
        $image = $formType->image;
        if ($image->hasFile() and $image->isImage()) {
            $user->changeImage(
                $this->fileTemporaryFactory->createFromUpload($image)
            );
        }

        $user->changeName($formType->name);
        $user->changeSurname($formType->surname);
        $user->changeEmail($formType->email);
        $this->em->flush();

        return $user;
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function changeRole(User $user, RoleFormType $formType): void
    {
        $user->changeRole($formType->role);
        $this->em->flush();
    }

    public function changePassword(User $user, PasswordFormType $formType): User
    {
        if (!$this->passwords->verify($formType->passwordOld, $user->getPassword())) {
            throw new InvalidArgumentException('messages.credentials.wrong');
        }
        if ($formType->passwordOld === $formType->passwordNew) {
            throw new InvalidArgumentException('messages.password.equal');
        }

        $user->changePassword($this->passwords->hash($formType->passwordNew));
        $this->em->flush();

        return $user;
    }

    public function changeState(User $user, int $state): User
    {
        $user->changeState($state);
        $this->em->flush();

        return $user;
    }

}