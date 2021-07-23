<?php

namespace App\DataFixtures;

use App\Entity\Color;
use App\Entity\Status;
use App\Entity\Liste;
use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $colors = [
            'yellow' => '#F2B90C',
            'green' => '#238C2A',
            'blue' => '#1835D9',
            'pink' => '#D50DD9',
            'red' => '#BF0B3B'
        ];
        $index = 0;
        foreach ($colors as $key => $value) {
            $index++;
            $color = new Color();
            $color->setName($key);
            $color->setCodeHex($value);
            $manager->persist($color);
            $this->addReference('color_'.$index, $color);
        }
        $statuses = [
            'À venir' => '#1835D9',
            'En cours' => '#F2B90C',
            'Terminé' => '#238C2A',
            'En retard' => '#BF0B3B'
        ];
        $index = 0;
        foreach ($statuses as $key => $value) {
            $index++;
            $status = new Status();
            $status->setName($key);
            $status->setColor($value);
            $this->addReference('status_'.$index, $status);
            $manager->persist($status);
        }

        for ($i = 1; $i <= 10; $i++) { 
            
            $list = new Liste();
            $list->setTitle("Liste numéro $i");
            $nbTodos = rand(1, 10);
            for ($j = 1; $j <= $nbTodos; $j++) { 
                $todo = new Todo();
                $todo
                    ->setTitle("Tâche numéro $j")
                    ->setDescription('Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy')
                    ->setListe($list)
                    ->setStatus($this->getReference('status_'.rand(1,4)))
                    ->setColor($this->getReference('color_'.rand(1, 5)));
                $manager->persist($todo);
            }
            $manager->persist($list);
        }

        $manager->flush();
    }
}
