<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../model/agencyModel.php';
require_once __DIR__ . '/../model/tripModel.php';
require_once __DIR__ . '/../model/userModel.php';

/**
 * Teste les fonctions qui écrivent dans la table agency.
 * Chaque test nettoie derrière lui ce qu'il a créé.
 */
class AgencyModelTest extends TestCase
{
    /** @var array Les id des agences créées pendant le test */
    private $agencyIds = [];

    /** @var array Les id des trajets créés pendant le test */
    private $tripIds = [];

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
     * Crée une agence de test avec un nom unique.
     *
     * @return array L'id et le nom de l'agence
     */
    private function newAgency()
    {
        $name = 'Test ' . uniqid();
        $id = createAgency($name);
        $this->agencyIds[] = $id;

        return ['id' => $id, 'name' => $name];
    }

    /**
     * Une agence créée apparaît dans la liste.
     *
     * @return void
     */
    public function testCreateAgency()
    {
        $agency = $this->newAgency();

        $names = array_column(getAgencies(), 'name');

        $this->assertContains($agency['name'], $names);
    }

    /**
     * Renommer une agence change son nom.
     *
     * @return void
     */
    public function testRenameAgency()
    {
        $agency = $this->newAgency();
        $newName = 'Renommée ' . uniqid();

        renameAgency($agency['id'], $newName);

        $names = array_column(getAgencies(), 'name');
        $this->assertContains($newName, $names);
        $this->assertNotContains($agency['name'], $names);
    }

    /**
     * Une agence supprimée disparaît de la liste.
     *
     * @return void
     */
    public function testDeleteAgency()
    {
        $agency = $this->newAgency();

        deleteAgency($agency['id']);

        $names = array_column(getAgencies(), 'name');
        $this->assertNotContains($agency['name'], $names);
    }

    /**
     * Un nom déjà pris est détecté, sauf pour l'agence elle-même.
     *
     * @return void
     */
    public function testAgencyNameExists()
    {
        $agency = $this->newAgency();

        $this->assertTrue(agencyNameExists($agency['name'], 0));
        $this->assertFalse(agencyNameExists($agency['name'], $agency['id']));
        $this->assertFalse(agencyNameExists('Nom inconnu ' . uniqid(), 0));
    }

    /**
     * Une agence utilisée par un trajet est détectée.
     *
     * @return void
     */
    public function testAgencyIsUsed()
    {
        $from = $this->newAgency();
        $to = $this->newAgency();
        $author = getUserByEmail('alexandre.martin@email.fr');

        $this->assertFalse(agencyIsUsed($from['id']));

        $this->tripIds[] = createTrip(
            $from['id'],
            $to['id'],
            date('Y-m-d H:i:s', strtotime('+2 days')),
            date('Y-m-d H:i:s', strtotime('+2 days +3 hours')),
            4,
            3,
            $author['id']
        );

        $this->assertTrue(agencyIsUsed($from['id']));
        $this->assertTrue(agencyIsUsed($to['id']));
    }
}
