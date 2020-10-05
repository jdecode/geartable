<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateApis extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('apis');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('hash', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('sheet_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('active', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('api_range', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addIndex([
            'hash',
        
            ], [
            'name' => 'HASH_INDEX',
            'unique' => false,
        ]);
        $table->addIndex([
            'sheet_id',
        
            ], [
            'name' => 'SHEET_ID_INDEX',
            'unique' => false,
        ]);
        $table->addIndex([
            'api_range',
        
            ], [
            'name' => 'API_RANGE_INDEX',
            'unique' => false,
        ]);
        $table->addIndex([
            'user_id',
        
            ], [
            'name' => 'USER_ID_INDEX',
            'unique' => false,
        ]);
        $table->create();
    }
}
