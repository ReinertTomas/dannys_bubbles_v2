<?php
declare(strict_types=1);

namespace App\UI\Control\File;

use App\Modules\Base\BasePresenter;
use App\UI\Control\BaseControl;
use App\UI\Form\File\FileFormFactory;
use Nette\Application\UI\Form;

/**
 * @property FileUploadTemplate $template
 */
final class FileUploadControl extends BaseControl
{

    private string $title;

    /** @var callable */
    private $onSuccess;

    private FileFormFactory $fileFormFactory;

    /**
     * @param BasePresenter $presenter
     * @param string $title
     * @param callable $onSuccess
     * @param FileFormFactory $fileFormFactory
     */
    public function __construct(BasePresenter $presenter, string $title, callable $onSuccess, FileFormFactory $fileFormFactory)
    {
        $this->presenter = $presenter;
        $this->title = $title;
        $this->onSuccess = $onSuccess;
        $this->fileFormFactory = $fileFormFactory;
    }

    public function render(): void
    {
        $this->template->title = $this->title;
        $this->template->setFile(__DIR__ . '/templates/file.latte');
        $this->template->render();
    }

    protected function createComponentForm(): Form
    {
        return $this->fileFormFactory->create($this->onSuccess);
    }

}