<?php

use Migrations\AbstractMigration;

class CreateCreditcards extends AbstractMigration
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
        $table = $this->table('creditcards');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('owner_name', 'string', [
            'default' => null,
            'limit' => 100,
        ]);
        $table->addColumn('creditcard_number', 'string', [
            'default' => null,
            'limit' => 100,
        ]);
        $table->addColumn('expiration_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('is_deleted', 'boolean', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
