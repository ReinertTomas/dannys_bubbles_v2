<?php
declare(strict_types=1);

namespace App\Domain\Config;

use App\Domain\File\FileFacade;
use App\Model\Database\Entity\Config;
use App\Model\Database\EntityManager;
use App\Model\File\DirectoryManager;
use Nette\Http\FileUpload;

class ConfigFacade
{

    private EntityManager $em;

    private DirectoryManager $dm;

    private FileFacade $fileFacade;

    public function __construct(EntityManager $em, DirectoryManager $dm, FileFacade $fileFacade)
    {
        $this->em = $em;
        $this->dm = $dm;
        $this->fileFacade = $fileFacade;
    }

    public function update(Config $config, array $data): Config
    {
        /** @var FileUpload $fileUpload */
        $fileUpload = $data['condition'];
        
        if ($fileUpload->hasFile()) {
            if ($config->hasCondition()) {
                $file = $this->fileFacade->update($config->getCondition(), $fileUpload, Config::NAMESPACE);
            } else {
                $file = $this->fileFacade->createFromHttp($fileUpload, Config::NAMESPACE);
            }
            $config->setCondition($file);
        }

        $config->setName($data['name']);
        $config->setSurname($data['surname']);
        $config->setIco($data['ico']);
        $config->setEmail($data['email']);
        $config->setWebsite($data['website']);
        $config->setFacebook($data['facebook']);
        $config->setInstagram($data['instagram']);
        $config->setYoutube($data['youtube']);
        $config->setPromoVideo($data['promoVideo']);

        $this->em->flush();

        return $config;
    }

}