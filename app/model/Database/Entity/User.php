<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\File\FileInfo;
use App\Model\Security\Identity;
use App\Model\User\Exception\InvalidRoleException;
use App\Model\User\Exception\InvalidStateException;
use App\Model\User\Role\Role;
use App\Model\User\Role\Roles;
use App\Model\User\State\State;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User
{

    use TId;
    use TCreatedAt;
    use TUpdatedAt;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=FALSE)
     */
    protected Image $image;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $surname;

    /**
     * @ORM\Column(type="string", length=255, unique=TRUE)
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $password;

    /**
     * @ORM\Column(type="string", length=8)
     */
    protected string $role;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $state;

    /**
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected ?DateTime $lastLoggedAt;

    public function __construct(Image $image, string $name, string $surname, string $email, string $password)
    {
        $this->image = $image;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;

        $this->role = Role::MEMBER;
        $this->state = State::FRESH;
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function changeImage(FileInfo $file): void
    {
        $this->image->update($file);
        $this->image->resize(96, 96);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function changeName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function changeSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getFullname(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getRoleElement(): Role
    {
        return Roles::create($this->role);
    }

    public function changeRole(string $role): void
    {
        if (!in_array($role, Role::ROLES, true)) {
            throw new InvalidRoleException(sprintf('Unsupported role %s', $role));
        }
        $this->role = $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function changeState(int $state): void
    {
        if (!in_array($state, State::STATES, true)) {
            throw new InvalidStateException(sprintf('Unsupported role %d', $state));
        }
        $this->state = $state;
    }

    public function block(): void
    {
        $this->state = State::BLOCKED;
    }

    public function activate(): void
    {
        $this->state = State::ACTIVATED;
    }

    public function isActivated(): bool
    {
        return $this->state === State::ACTIVATED;
    }

    public function getLastLoggedAt(): ?DateTime
    {
        return $this->lastLoggedAt;
    }

    public function changeLoggedAt(): void
    {
        $this->lastLoggedAt = new DateTime();
    }

    public function toIdentity(): Identity
    {
        return new Identity($this->getId(), [$this->role], [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'state' => $this->state,
            'lastLoggedAt' => $this->lastLoggedAt
        ]);
    }

}