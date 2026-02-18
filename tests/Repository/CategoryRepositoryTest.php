<?php

namespace App\Tests\Repository;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryRepositoryTest extends KernelTestCase
{
    public function testFindAllCategory()
    {
        self::bootKernel();
        $container = static::getContainer();

        $categories = count($container->get(CategoryRepository::class)->findAll());
        $this->assertEquals(6, $categories);
    }

    public function testFindOneByTitleCategory(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $category[] = $container->get(CategoryRepository::class)->findOneBy(['title' => 'Chaussure']);
        $this->assertEquals(1, count($category));
    }
}
