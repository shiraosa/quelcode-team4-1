<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BasicRatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BasicRatesTable Test Case
 */
class BasicRatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BasicRatesTable
     */
    public $BasicRates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BasicRates',
        'app.Reservations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BasicRates') ? [] : ['className' => BasicRatesTable::class];
        $this->BasicRates = TableRegistry::getTableLocator()->get('BasicRates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BasicRates);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
