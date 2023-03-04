<?php
// /tests\PruebaTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PruebaTest extends WebTestCase
{
    public function testSomething()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/myprueba');

        // select the button
        $buttonCrawlerNode = $crawler->selectButton('contact[send]');

        // retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

        // set values on a form object
        $form['contact[name]'] = 'Fabien';
        $form['contact[message]'] = 'Symfony rocks!';

        // submit the Form object
        $client->submit($form);
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('div:contains("Fabien")');
        $this->assertSelectorExists('div:contains("Symfony rocks!")');
    }
    
}