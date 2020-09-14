<?php
declare(strict_types=1);

namespace Database\Fixtures;

use App\Model\Config\ConfigDto;
use App\Model\Config\ConfigFactory;
use Doctrine\Persistence\ObjectManager;

class ConfigFixture extends AbstractFixture
{

    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var ConfigFactory $configFactory */
        $configFactory = $this->container->getByType(ConfigFactory::class);

        $entity = $configFactory->create(ConfigDto::fromArray($this->getConfig()));

        $manager->persist($entity);
        $manager->flush();
    }

    protected function getConfig(): array
    {
        return [
            'name' => 'Daniel',
            'surname' => 'Kunášek',
            'ico' => '07365551',
            'email' => 'dannysbubbles@gmail.com',
            'website' => 'www.dannysbubbles.com',
            'facebook' => 'https://www.facebook.com/Dannysbubbles',
            'instagram' => 'https://www.instagram.com/dannysbubbles',
            'youtube' => 'https://www.youtube.com/channel/UC86z1vsm8LW0IqFA9TdQ7OQ',
            'promoVideo' => 'https://www.youtube.com/embed/8dkdey6rdto',
            'promoImage' => 'xxx',
            'aboutMe' => 'Ke kráse bublin jsem se dostal po mnoha letech od dětství tehdy, když jsem začal dělat veřejná vystoupení na ulicích měst. Bavilo a fascinovalo mě to tak, že jsem se do hraní s bublinami pustil i doma a tak vznikly první složitější bublinové triky. Neustále okouzlující barvy a tvary bublin, které mi přináší radost, bych rád sdílel i s ostatními.'
        ];
    }

}