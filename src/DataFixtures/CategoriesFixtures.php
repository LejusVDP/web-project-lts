<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Informatique', null, 1, $manager);	// parent
        $category = $this->createCategory('Ordinateurs portables', $parent, 3, $manager);	// child
        $category = $this->createCategory('Ecrans', $parent, 2, $manager);	// child
        $category = $this->createCategory('Souris', $parent, 4, $manager);	// child

        $parent = $this->createCategory('Mode', null, 5, $manager);	// parent
        $category = $this->createCategory('Homme', $parent, 8, $manager);	// child
        $category = $this->createCategory('Femme', $parent, 7, $manager);	// child
        $category = $this->createCategory('Enfant', $parent, 6, $manager);	// child

        $manager->flush();
    }

    public function createCategory(string $name, ?Categories $parent = null, int $order, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $category->setCategoryOrder($order);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
