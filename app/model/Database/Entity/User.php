<?php
declare(strict_types=1);

namespace App\Model\Database\Entity;

use App\Model\Database\Entity\Attributes\TCreatedAt;
use App\Model\Database\Entity\Attributes\TId;
use App\Model\Database\Entity\Attributes\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\File\FileInfoInterface;
use App\Model\Security\Identity;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Database\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User
{

    public const NAMESPACE = '/user';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_USER => 'User'
    ];

    public const STATE_FRESH = 1;
    public const STATE_ACTIVATED = 2;
    public const STATE_BLOCKED = 3;

    public const STATES = [
        self::STATE_FRESH => 'FRESH',
        self::STATE_ACTIVATED => 'ACTIVATED',
        self::STATE_BLOCKED => 'BLOCKED'
    ];

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

        $this->role = self::ROLE_USER;
        $this->state = self::STATE_FRESH;
    }

    public static function create(Image $image, string $name, string $surname, string $email, string $password): User
    {
        return new User($image, $name, $surname, $email, $password);
    }

    public function getImage(): Image
    {
        return $this->image;
    }

    public function changeImage(FileInfoInterface $file): void
    {
        $this->image->update($file);
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

    public function changeRole(string $role): void
    {
        if (!array_key_exists($role, self::ROLES)) {
            throw InvalidArgumentException::create()
                ->withMessage('Unsupported role ' . $role);
        }
        $this->role = $role;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function changeState(int $state): void
    {
        if (!array_key_exists($state, self::STATES)) {
            throw new InvalidArgumentException(sprintf('Unsupported state %s', $state));
        }
        $this->state = $state;
    }

    public function block(): void
    {
        $this->state = self::STATE_BLOCKED;
    }

    public function activate(): void
    {
        $this->state = self::STATE_ACTIVATED;
    }

    public function isActivated(): bool
    {
        return $this->state === self::STATE_ACTIVATED;
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