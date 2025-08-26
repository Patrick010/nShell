<?php
namespace OCA\nShell\Migration;

use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version00001 extends SimpleMigrationStep {

    public function changeSchema(\OCP\DB\ISchemaWrapper $schema, IOutput $output) {
        // Check if table already exists to avoid errors
        if (!$schema->hasTable('nshell_sessions')) {
            $table = $schema->createTable('nshell_sessions');

            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('uid', 'string', ['length' => 64, 'notnull' => true]);
            $table->addColumn('session_id', 'string', ['length' => 64, 'notnull' => true]);
            $table->addColumn('created_at', 'integer', ['notnull' => true]);
            $table->addColumn('expires_at', 'integer', ['notnull' => true]);

            $table->setPrimaryKey(['id']);
            $table->addUniqueIndex(['session_id']);
            $table->addIndex(['uid']);
        }
    }
}
