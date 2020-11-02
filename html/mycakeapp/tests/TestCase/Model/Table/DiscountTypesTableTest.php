<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiscountTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiscountTypesTable Test Case
 */
class DiscountTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiscountTypesTable
     */
    public $DiscountTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DiscountTypes',
        'app.DiscountLogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DiscountTypes') ? [] : ['className' => DiscountTypesTable::class];
        $this->DiscountTypes = TableRegistry::getTableLocator()->get('DiscountTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DiscountTypes);

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
