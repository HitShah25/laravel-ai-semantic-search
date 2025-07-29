<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Example usage: php artisan import:categories storage/app/categories.xlsx
     */
    protected $signature = 'import:categories {path=storage/app/categories.xlsx}';

    /**
     * The console command description.
     */
    protected $description = 'Import categories from an Excel file into the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path');

        if (!file_exists($path)) {
            $this->error("File not found at: {$path}");
            return Command::FAILURE;
        }

        $this->info("Importing categories from: {$path}");

        $rows = Excel::toCollection(null, $path)->first();

        if (!$rows) {
            $this->error('No data found in the Excel file.');
            return Command::FAILURE;
        }

        foreach ($rows as $row) {
            $name = trim($row['category'] ?? $row[0] ?? '');

            if ($name !== '') {
                Category::firstOrCreate(['name' => $name]);
                $this->line("Imported: {$name}");
            }
        }

        $this->info('Import completed successfully.');
        return Command::SUCCESS;
    }
}
