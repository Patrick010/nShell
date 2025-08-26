<?php

declare(strict_types=1);

namespace OCA\nShell\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\DB\Types;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version100Date20250826000000 extends SimpleMigrationStep {
    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
     * @param array $options
     * @return null|ISchemaWrapper
     */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('n_shell_sessions')) {
            $table = $schema->createTable('n_shell_sessions');

            $table->addColumn('uid', Types::STRING, [
                'notnull' => true,
                'length' => 64,
            ]);

            $table->addColumn('session_id', Types::STRING, [
                'notnull' => true,
                'length' => 255,
            ]);

            $table->addColumn('created_at', Types::INTEGER, [
                'notnull' => true,
                'length' => 11,
                'unsigned' => true,
            ]);

            $table->addColumn('expires_at', Types::INTEGER, [
                'notnull' => true,
                'length' => 11,
                'unsigned' => true,
            ]);

            $table->setPrimaryKey(['session_id']);
            $table->addIndex(['uid'], 'n_shell_sessions_uid_idx');
        }

        return $schema;
    }
}