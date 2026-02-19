<?php

namespace App\Tests\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\InMemoryUser;

class ProductControllerTest extends WebTestCase
{
    private static ?int $id = null;

    public function testPageNew()
    {
        $client = static::createClient();
        $user = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $client->loginUser($user);


        $crawler = $client->request('GET', '/admin/product/new');


        $buttonCrawlerNode = $crawler->selectButton('Save');

        $form = $buttonCrawlerNode->form();

        $form['product[category]']->select('T-shirt');


        $client->submit($form, [
            'product[title]' => 'pantalon',
            'product[description]' => 'Symfony rocks!',
            'product[price]' => 10,

        ]);
        $container = self::getContainer();
        $product = $container->get(ProductRepository::class)->findOneBy(['title' => 'pantalon']);
        self ::$id = $product->getId();

        $this->assertResponseRedirects('/admin/product');

    }

    public function testPageEdit()
    {
        $client = static::createClient();
        $user = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $client->loginUser($user);


        $crawler = $client->request('GET', "/admin/product/" . self::$id . "/edit");


        $buttonCrawlerNode = $crawler->selectButton('Update');

        $form = $buttonCrawlerNode->form();

        $form['product[category]']->select('T-shirt');


        $client->submit($form, [
            'product[title]' => 'pantalon',
            'product[description]' => 'Symfony ddh!',
            'product[price]' => 10,

        ]);

        $this->assertResponseRedirects('/admin/product');

    }
}
