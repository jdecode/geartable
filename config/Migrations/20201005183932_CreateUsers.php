<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('active', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('email_verified', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('email_verified_at', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('remember_me_token', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
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
            'email',
        
            ], [
            'name' => 'EMAIL_INDEX',
            'unique' => false,
        ]);
        $table->addIndex([
            'remember_me_token',
        
            ], [
            'name' => 'REMEMBER_ME_TOKEN_INDEX',
            'unique' => false,
        ]);
        $table->create();
    }
}
