<?php
namespace Ibase\StoreBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ibase\StoreBundle\Entity\Product;
 
class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
         $product_sensio_labs = new Product();
         $product_sensio_labs->setCategory($em->merge($this->getReference('category-programming')));
         $product_sensio_labs->setBrand('G-camp');
         $product_sensio_labs->setColor('grey');
         $product_sensio_labs->setInclude('A+C');
         $product_sensio_labs->setMaterial('wool');
         $product_sensio_labs->setModel('M12345');
         $product_sensio_labs->setName('3*4 Camp');
         $product_sensio_labs->setPrice(19.99);
         $product_sensio_labs->setSuggestion('not to use under water');
         $product_extreme_sensio = new Product();
         $product_extreme_sensio->setCategory($em->merge($this->getReference('category-design')));
         $product_extreme_sensio->setBrand('Excellent');
         $product_extreme_sensio->setColor('red');
         $product_extreme_sensio->setInclude('A+B+C');
         $product_extreme_sensio->setMaterial('metal');
         $product_extreme_sensio->setModel('M19995');
         $product_extreme_sensio->setName('16*18 Camp');
         $product_extreme_sensio->setPrice(119.99);
         $product_extreme_sensio->setSuggestion('not to use under water');
 
         $em->persist($product_sensio_labs);
         $em->persist($product_extreme_sensio);
         $em->flush();
    }
 
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}