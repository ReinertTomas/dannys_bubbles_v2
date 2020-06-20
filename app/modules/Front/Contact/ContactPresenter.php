<?php
declare(strict_types=1);

namespace App\Modules\Front\Contact;

use App\Modules\Front\BaseFrontPresenter;
use App\UI\Form\Contact\ContactFormFactory;
use App\UI\Form\Contact\ContactFormType;
use Nette\Application\UI\Form;

final class ContactPresenter extends BaseFrontPresenter
{

    /** @inject */
    public ContactFormFactory $contactFormFactory;

    protected function createComponentContactForm(): Form
    {
        return $this->contactFormFactory->create(function (Form $form, ContactFormType $formType): void {
            dump($formType);
            die();
        });
    }

}