<?php
declare(strict_types=1);

namespace App\Modules\Base\Traits;

use App\Modules\Base\BasePresenter;
use Nette\Application\AbortException;

/**
 * @mixin BasePresenter
 */
trait TModal
{

    public function redrawModalContent(): void
    {
        $this->redrawControl('modal-content');
    }

    /**
     * @param string $modal
     * @param array<string>|null $attr
     * @throws AbortException
     */
    public function handleModal(string $modal, ?array $attr): void
    {
        if ($this->isAjax()) {
            $this->template->modal = $modal;
            $this->template->modalAttr = $attr;
            $this->redrawControl('modal');
            $this->setAjaxPostGet();
        } else {
            $this->redirect('this');
        }
    }

}