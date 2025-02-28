<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files_arr = scandir(dirname(__FILE__)); // Get all files in the directory

        foreach ($files_arr as $file) {
            if ($file !== 'DatabaseSeeder.php' && $file[0] !== '.' && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                // Get class name without the .php extension
                $className = pathinfo($file, PATHINFO_FILENAME);

                // Add namespace for Laravel seeders
                $fullyQualifiedClass = "Database\\Seeders\\$className";

                // Ensure the class exists before calling it
                if (class_exists($fullyQualifiedClass)) {
                    $this->call($fullyQualifiedClass);
                } else {
                    echo "Class $fullyQualifiedClass not found.\n";
                }
            }
        }
    }
}
