<?php
declare(strict_types=1);

namespace App\Model\Html;

abstract class Elements
{

    /** @var Element[] */
    protected array $collection;

    public function __construct()
    {
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