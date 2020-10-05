<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SheetsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SheetsTable Test Case
 */
class SheetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SheetsTable
     */
    protected $Sheets;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Sheets',
        'app.Users',
        'app.Apis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Sheets') ? [] : ['className' => SheetsTable::class];
        $this->Sheets = $this->getTableLocator()->get('Sheets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Sheets);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
