<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/agencyModel.php';
require_once __DIR__ . '/../model/tripModel.php';
require_once __DIR__ . '/../model/userModel.php';

/**
 * Teste les fonctions qui écrivent dans la table trip.
 * Chaque test nettoie derrière lui ce qu'il a créé.
 */
class TripModelTest extends TestCase
{
    /** @var array Les id des trajets créés pendant le test */
    private $tripIds = [];

    /** @var array Les id des agences créées pendant le test */
    private $agencyIds = [];

    /** @var array Les deux agences de test */
    private $agencies = [];

    /** @var array L'utilisateur auteur des trajets de test */
    private $author;

    /**
     * Prépare deux agences de test et un auteur.
     *
     * @return void
     */
    protected function setUp(): void
    {
        for ($i = 1; $i <= 2; $i++) {
            $id = createAgency('Test ' . uniqid());
            $this->agencyIds[] = $id;
            $this->agencies[] = $id;
        }

        $this->author = getUserByEmail('alexandre.martin@email.fr');
    }

    /**
     * Supprime ce que le test a créé (trajets d'abord, puis agences).
     *
     * @return void
     */
    protected function tearDown(): void
    {
        foreach ($this->tripIds as $id) {
            deleteTrip($id);
        }
        foreach ($this->agencyIds as $id) {
            deleteAgency($id);
        }
    }

    /**
     * Crée un trajet de test dans 2 jours.
     *
     * @return int L'id du trajet
     */
    private function newTrip()
    {
        $id = createTrip(
            $this->agencies[0],
            $this->agencies[1],
            date('Y-m-d H:i:s', strtotime('+2 days')),
            date('Y-m-d H:i:s', strtotime('+2 days +3 hours')),
            4,
            3,
            $this->author['id']
        );
        $this->tripIds[] = $id;

        return $id;
    }

    /**
     * Un trajet créé est retrouvé avec les bonnes valeurs.
     *
     * @return void
     */
    public function testCreateTrip()
    {
        $id = $this->newTrip();

        $trip = getTrip($id);

        $this->assertEquals($this->agencies[0], $trip['departure_agency_id']);
        $this->assertEquals($this->agencies[1], $trip['arrival_agency_id']);
        $this->assertEquals(4, $trip['total_seats']);
        $this->assertEquals(3, $trip['available_seats']);
        $this->assertEquals($this->author['id'], $trip['author_id']);
    }

    /**
     * Un trajet créé apparaît sur l'accueil (futur et avec des places).
     *
     * @return void
     */
    public function testCreatedTripIsListed()
    {
        $id = $this->newTrip();

        $ids = array_column(getTrips(), 'id');

        $this->assertContains((string) $id, array_map('strval', $ids));
    }

    /**
     * Modifier un trajet change ses valeurs.
     *
     * @return void
     */
    public function testUpdateTrip()
    {
        $id = $this->newTrip();

        updateTrip(
            $id,
            $this->agencies[1],
            $this->agencies[0],
            date('Y-m-d H:i:s', strtotime('+5 days')),
            date('Y-m-d H:i:s', strtotime('+5 days +2 hours')),
            6,
            5
        );

        $trip = getTrip($id);
        $this->assertEquals($this->agencies[1], $trip['departure_agency_id']);
        $this->assertEquals($this->agencies[0], $trip['arrival_agency_id']);
        $this->assertEquals(6, $trip['total_seats']);
        $this->assertEquals(5, $trip['available_seats']);
    }

    /**
     * Un trajet supprimé n'existe plus.
     *
     * @return void
     */
    public function testDeleteTrip()
    {
        $id = $this->newTrip();

        deleteTrip($id);

        $this->assertFalse(getTrip($id));
    }

    /**
     * Un trajet complet (0 place) n'apparaît pas sur l'accueil.
     *
     * @return void
     */
    public function testFullTripIsNotListed()
    {
        $id = $this->newTrip();

        updateTrip(
            $id,
            $this->agencies[0],
            $this->agencies[1],
            date('Y-m-d H:i:s', strtotime('+2 days')),
            date('Y-m-d H:i:s', strtotime('+2 days +3 hours')),
            4,
            0
        );

        $ids = array_map('strval', array_column(getTrips(), 'id'));

        $this->assertNotContains((string) $id, $ids);
    }
}
