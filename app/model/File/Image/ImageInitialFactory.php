<?php
declare(strict_types=1);

namespace App\Model\File\Image;

use App\Model\File\Exception\DirectoryNotFoundException;
use App\Model\File\FileInfo;
use App\Model\File\FileInfoFactory;
use App\Model\Utils\FileSystem;
use App\Model\Utils\Strings;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Ramsey\Uuid\Uuid;

final class ImageInitialFactory
{

    private const PRIMARY = '#4e73df';
    private const SECONDARY = '#1cc88a';
    private const INFO = '#36b9cc';
    private const SUCCESS = '#f6c23e';
    private const WARNING = '#e74a3b';
    private const DANGER = '#858796';

    /** @var array<int, string> */
    private array $colors = [
        self::PRIMARY,
        self::SECONDARY,
        self::INFO,
        self::SUCCESS,
        self::WARNING,
        self::DANGER
    ];

    private string $directory;

    private FileInfoFactory $fileInfoFactory;

    public function __construct(string $directory, FileInfoFactory $fileInfoFactory)
    {
        FileSystem::createDir($directory, 0755);

        $directory = realpath($directory);
        if (!is_dir($directory)) {
            throw new DirectoryNotFoundException($directory);
        }

        $this->directory = $directory;
        $this->fileInfoFactory = $fileInfoFactory;
    }

    public function create(string $name, string $surname): FileInfo
    {
        $originalName = Strings::lower($name . '.' . $surname);
        $file = $this->fileInfoFactory->create($this->getPath(), $originalName, false);

        $initialAvatar = new InitialAvatar();
        $initialAvatar->name($name . ' ' . $surname)
            ->color('#ffffff')
            ->background($this->getRandomColor())
            ->size(96)
            ->generate()
            ->save($file->getPathname());

        return $file;
    }

    private function getRandomColor(): string
    {
        return $this->colors[array_rand($this->colors)];
    }

    private function getPath(): string
    {
        return $this->directory . '/' . Uuid::uuid4() . '.jpg';
    }

}