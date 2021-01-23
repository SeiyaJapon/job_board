<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobOfferControllerTest extends WebTestCase
{
    public function testApply()
    {
        $client = static::createClient();
        $client->request('GET', '/job/offer/2/apply');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'You are applying to otra oferta editada');

        $client->submitForm('Save', [
            'application[name]' => 'fulano',
            'application[email]' => 'expresionotaku@gmail.com',
            'application[birthdate]' => (new \DateTimeImmutable('today - 20 years'))->format('Y-m-d')
        ]);

        $this->assertResponseIsSuccessful();  // FAIL
    }
}