<?php

namespace Database\Factories;

use App\Models\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gender>
 */
class GenderFactory extends Factory
{   
    protected $model = Gender::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $genderIndex = 0;
        $genders = ['Male', 'Female'];

        if ($genderIndex >= count($genders)) {
            $genderIndex = 0; // Reset after both genders are used
        }

        return [
            'gender' => $genders[$genderIndex++], // Cycles through Male → Female
        ];
    }

    public static function checkGenderExists($genderId) {
        return Gender::where('id', $genderId)->exists();
    }
}
