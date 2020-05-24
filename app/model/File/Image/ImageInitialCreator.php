<?php
declare(strict_types=1);

namespace App\Model\File\Image;

use App\Model\File\FileInfoInterface;
use App\Model\File\FileTemporaryFactory;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;

final class ImageInitialCreator
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

    private FileTemporaryFactory $fileTemporaryFactory;

    public function __construct(FileTemporaryFactory $fileTemporaryFactory)
    {
        $this->fileTemporaryFactory = $fileTemporaryFactory;
    }

    public function create(string $name, string $surname): FileInfoInterface
    {
        $filename = $surname . '_' . $name . '.jpg';
        $file = $this->fileTemporaryFactory->createBeforeSave($filename);

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

}