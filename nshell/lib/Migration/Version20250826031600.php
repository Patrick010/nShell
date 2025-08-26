<?php

declare(strict_types=1);

namespace OCA\nShell\Migration;

use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\ISchemaMigration;

class Version20250826031600 implements ISchemaMigration {

    public function changeSchema(ISchemaWrapper $schema, IOutput $output): void {
        if (!$schema->hasTable('nshell_sessions')) {
            $table = $schema->createTable('nshell_sessions');

            $table->addColumn('id', 'string', [
                'length' => 64,
                'notnull' => true,
            ]);
            $table->addColumn('user_id', 'string', [
                'length' => 64,
                'notnull' => true,
            ]);
            $table->addColumn('created_at', 'datetime', [
                'notnull' => true,
            ]);
            $table->addColumn('last_activity', 'datetime', [
                'notnull' => false, // Optional as per plan
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'nshell_sessions_user_id_index');

            $output->info('nshell_sessions table created');
        }
    }

    public function postSchemaChange(ISchemaWrapper $schema, IOutput $output): void {
        // No post-migration steps needed for this version.
    }
}
