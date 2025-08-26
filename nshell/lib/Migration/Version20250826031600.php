<?php

declare(strict_types=1);

namespace OCA\nShell\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version20250826031600 extends SimpleMigrationStep {

    public function change(IOutput $output, Closure $schemaClosure, array $options): void {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('nshell_sessions')) {
            $table = $schema->createTable('nshell_sessions');
            $table->addColumn('id', 'string', [
                'autoincrement' => false,
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('user_id', 'string', [
                'notnull' => true,
                'length' => 64,
            ]);
            $table->addColumn('created_at', 'datetime', [
                'notnull' => true,
            ]);
            $table->addColumn('last_activity', 'datetime', [
                'notnull' => false, // Optional as per plan
            ]);
            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'nshell_sessions_user_id_index');
        }
    }
}
