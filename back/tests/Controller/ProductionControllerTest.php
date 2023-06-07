<?php

namespace App\Test\Controller;

use App\Entity\Production;
use App\Repository\ProductionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ProductionRepository $repository;
    private string $path = '/production/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Production::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Production index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'production[title]' => 'Testing',
            'production[type]' => 'Testing',
            'production[releaseDate]' => 'Testing',
            'production[duration]' => 'Testing',
            'production[tagline]' => 'Testing',
            'production[synopsis]' => 'Testing',
            'production[rating]' => 'Testing',
            'production[poster]' => 'Testing',
            'production[backdrop]' => 'Testing',
            'production[trailer]' => 'Testing',
            'production[tags]' => 'Testing',
            'production[countries]' => 'Testing',
        ]);

        self::assertResponseRedirects('/production/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Production();
        $fixture->setTitle('My Title');
        $fixture->setType('My Title');
        $fixture->setReleaseDate('My Title');
        $fixture->setDuration('My Title');
        $fixture->setTagline('My Title');
        $fixture->setSynopsis('My Title');
        $fixture->setRating('My Title');
        $fixture->setPoster('My Title');
        $fixture->setBackdrop('My Title');
        $fixture->setTrailer('My Title');
        $fixture->addTag('My Title');
        $fixture->addCountry('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Production');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Production();
        $fixture->setTitle('My Title');
        $fixture->setType('My Title');
        $fixture->setReleaseDate('My Title');
        $fixture->setDuration('My Title');
        $fixture->setTagline('My Title');
        $fixture->setSynopsis('My Title');
        $fixture->setRating('My Title');
        $fixture->setPoster('My Title');
        $fixture->setBackdrop('My Title');
        $fixture->setTrailer('My Title');
        $fixture->addTag('My Title');
        $fixture->addCountry('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'production[title]' => 'Something New',
            'production[type]' => 'Something New',
            'production[releaseDate]' => 'Something New',
            'production[duration]' => 'Something New',
            'production[tagline]' => 'Something New',
            'production[synopsis]' => 'Something New',
            'production[rating]' => 'Something New',
            'production[poster]' => 'Something New',
            'production[backdrop]' => 'Something New',
            'production[trailer]' => 'Something New',
            'production[tags]' => 'Something New',
            'production[countries]' => 'Something New',
        ]);

        self::assertResponseRedirects('/production/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getReleaseDate());
        self::assertSame('Something New', $fixture[0]->getDuration());
        self::assertSame('Something New', $fixture[0]->getTagline());
        self::assertSame('Something New', $fixture[0]->getSynopsis());
        self::assertSame('Something New', $fixture[0]->getRating());
        self::assertSame('Something New', $fixture[0]->getPoster());
        self::assertSame('Something New', $fixture[0]->getBackdrop());
        self::assertSame('Something New', $fixture[0]->getTrailer());
        self::assertSame('Something New', $fixture[0]->getTags());
        self::assertSame('Something New', $fixture[0]->getCountries());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Production();
        $fixture->setTitle('My Title');
        $fixture->setType('My Title');
        $fixture->setReleaseDate('My Title');
        $fixture->setDuration('My Title');
        $fixture->setTagline('My Title');
        $fixture->setSynopsis('My Title');
        $fixture->setRating('My Title');
        $fixture->setPoster('My Title');
        $fixture->setBackdrop('My Title');
        $fixture->setTrailer('My Title');
        $fixture->addTag('My Title');
        $fixture->addCountry('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/production/');
    }
}
