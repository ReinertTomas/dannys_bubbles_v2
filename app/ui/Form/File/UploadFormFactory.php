<?php
declare(strict_types=1);

namespace App\UI\Form\File;

use App\UI\Form\FormFactory;
use Nette\Application\UI\Form;

final class UploadFormFactory
{

    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create(): Form
    {
        $form = $this->formFactory->createSecured();

        $form->addHidden('files');
        $form->addSubmit('submit', 'Upload');

        return $form;
    }

}