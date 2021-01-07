<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiscountLogsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiscountLogsTable Test Case
 */
class DiscountLogsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiscountLogsTable
     */
    public $DiscountLogs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DiscountLogs',
        'app.DiscountTypes',
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
        $config = TableRegistry::getTableLocator()->exists('DiscountLogs') ? [] : ['className' => DiscountLogsTable::class];
        $this->DiscountLogs = TableRegistry::getTableLocator()->get('DiscountLogs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DiscountLogs);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
