<?php

namespace Larafor\Bloodgroup\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateBloodGroupMigration extends Command
{
    protected $signature = 'bloodgroup:create-migration {table : The name of the table to modify}';
    protected $description = 'Create a migration for adding blood_group_id to a specified table';

    const COLUMN_NAME = 'blood_group_id';
    const FOREIGN_TABLE = 'blood_groups';

    public function handle(): void
    {
        $table = trim($this->argument('table'));

        // Check if column already exists
        if ($this->columnExists($table, self::COLUMN_NAME)) {
            $this->error("The column '" . self::COLUMN_NAME . "' already exists in the '$table' table.");
            return;
        }

        $migrationName = "add_" . self::COLUMN_NAME . "_to_{$table}_table";

        if ($this->migrationExists($migrationName)) {
            $this->error("Migration file '$migrationName' already exists.");
            return;
        }

        $migrationPath = database_path('migrations/' . now()->format('Y_m_d_His') . "_{$migrationName}.php");
        File::put($migrationPath, $this->generateMigrationContent($table));

        $this->info("✅ Migration created successfully:\n$migrationPath");
    }

    protected function columnExists(string $table, string $column): bool
    {
        return Schema::hasColumn($table, $column);
    }

    protected function migrationExists(string $migrationName): bool
    {
        return collect(File::files(database_path('migrations')))
            ->contains(fn ($file) => Str::contains($file->getFilename(), $migrationName));
    }

    protected function generateMigrationContent(string $table): string
    {
        $column = self::COLUMN_NAME;
        $foreignTable = self::FOREIGN_TABLE;

        return <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('$table', function (Blueprint \$table) {
            \$table->unsignedBigInteger('$column')->nullable();
            \$table->foreign('$column')->references('id')->on('$foreignTable')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('$table', function (Blueprint \$table) {
            \$table->dropForeign(['$column']);
            \$table->dropColumn('$column');
        });
    }
};
PHP;
    }
}
