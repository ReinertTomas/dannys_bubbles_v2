<?php
declare(strict_types=1);

namespace App\Tests;

use App\Bootstrap;
use App\Model\File\FileInfoInterface;
use App\Model\File\Image\ImageInitialCreator;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/../vendor/autoload.php';

class ImageInitialTest extends TestCase
{

    private Container $container;

    private ?FileInfoInterface $file;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    protected function setUp()
    {
        $creator = $this->container->getByType(ImageInitialCreator::class);
        $this->file = $creator->create('Test', 'Tester');
    }


    public function testCreate(): void
    {
        Assert::notNull($this->file);
        Assert::type(FileInfoInterface::class, $this->file);
    }

    public function testName(): void
    {
        Assert::same('test_tester.jpg', $this->file->getName());
    }

    public function testExtension(): void
    {
        Assert::same('jpg', $this->file->getExtension());
    }

    public function testPath(): void
    {
        Assert::true(realpath($this->file->getPathname()) !== false);
    }

}

$container = Bootstrap::bootForTests()
    ->createContainer();
$test = new ImageInitialTest($container);
$test->run();