<?php
declare(strict_types=1);

namespace App\UI\Form;

use Nette\Application\UI\Form;

class FormFactory
{

    public function createUnsecured(): Form
    {
        return new Form();
    }

    public function createSecured(): Form
    {
        $form = $this->createUnsecured();
        $form->addProtection();

        return $form;
    }

}