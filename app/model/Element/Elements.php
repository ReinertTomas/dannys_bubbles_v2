<?php
declare(strict_types=1);

namespace App\Model\Element;

use Nette\Localization\ITranslator;

abstract class Elements
{

    /** @var Element[] */
    protected array $collection;

//    protected ITranslator $translator;

    public function __construct()
    {
//        $this->translator = $translator;
        $this->build();
    }

    abstract protected function build(): void;

    /**
     * @return array<mixed>
     */
    public function getPairs(): array
    {
        $options = [];
        foreach ($this->collection as $key => $element) {
            $options[$key] = $element->getText();
        }
        return $options;
    }

}