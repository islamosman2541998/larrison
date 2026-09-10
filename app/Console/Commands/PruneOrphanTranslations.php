<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Removes translation rows whose owner record no longer exists.
 *
 * Deleting a category used to leave its translations behind. Those rows kept
 * owning their slug, so any category later created with the same slug resolved
 * to a missing record and the public page answered 404.
 */
class PruneOrphanTranslations extends Command
{
    protected $signature = 'translations:prune-orphans {--dry-run : Only report what would be deleted}';

    protected $description = 'Delete translation rows that no longer belong to an existing record';

    /**
     * translation table => [owner table, foreign key]
     */
    private array $map = [
        'product_category_translations' => ['product_categories', 'product_category_id'],
        'parent_category_translations'  => ['parent_categories', 'parent_category_id'],
        'product_translations'          => ['products', 'product_id'],
    ];

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $total  = 0;

        foreach ($this->map as $table => [$ownerTable, $foreignKey]) {
            if (! DB::getSchemaBuilder()->hasTable($table) || ! DB::getSchemaBuilder()->hasTable($ownerTable)) {
                $this->warn("skipped {$table} (table not found)");
                continue;
            }

            $orphans = DB::table($table)
                ->whereNotExists(function ($q) use ($table, $ownerTable, $foreignKey) {
                    $q->select(DB::raw(1))
                      ->from($ownerTable)
                      ->whereColumn($ownerTable . '.id', $table . '.' . $foreignKey);
                });

            $count = (clone $orphans)->count();
            $total += $count;

            if ($count === 0) {
                $this->line("{$table}: clean");
                continue;
            }

            $sample = (clone $orphans)->limit(10)->pluck('slug')->filter()->implode(', ');
            $this->line("{$table}: {$count} orphan row(s)" . ($sample ? " — e.g. {$sample}" : ''));

            if (! $dryRun) {
                $orphans->delete();
            }
        }

        $this->newLine();
        $this->info($dryRun
            ? "Dry run finished. {$total} row(s) would be deleted."
            : "Done. {$total} orphan row(s) deleted.");

        return self::SUCCESS;
    }
}
