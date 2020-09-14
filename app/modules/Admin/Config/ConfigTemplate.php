<?php
declare(strict_types=1);

namespace App\Modules\Admin\Config;

use App\Model\Database\Entity\Config;
use App\Model\Template\BaseTemplate;

final class ConfigTemplate extends BaseTemplate
{

    public Config $config;

}