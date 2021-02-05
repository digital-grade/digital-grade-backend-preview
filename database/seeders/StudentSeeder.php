<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\ClassesStudent;
use App\Models\Student;
use Illuminate\Database\Seeder;
use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Xvladqt\Faker\LoremFlickrProvider;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $faker->addProvider(new LoremFlickrProvider($faker));
        $faker->addProvider(new ImagesGeneratorProvider($faker));

        $classes = Classes::all()->pluck('id');

        for ($i = 0; $i < 15; $i++) {
            $nis = $faker->numberBetween(100000000000, 999999999999);

            $student = new Student();
            $student->name = $faker->firstName . " " . $faker->lastName;
            $student->phone_number = $faker->phoneNumber;
            $student->nisn = $faker->numberBetween(100000000000, 999999999999);
            $student->nis = $nis;
            $student->email = $faker->email;
            
            $student->address = $faker->address;
            $student->blood_type = $faker->randomElement($array = ['A', 'B', 'O', 'AB']);
            $student->place_of_birth = $faker->city;
            $student->date_of_birth = $faker->dateTimeThisCentury->format('Y-m-d');

            if($i%2 == 0){
                $student->gender = "Laki-laki";
            }else{
                $student->gender = "Perempuan";
            }

            $path = "public/students/" . $student->nis . "/profile";

            Storage::deleteDirectory($path);
            Storage::makeDirectory($path);
            $firstLetter = substr($student->name, 0, 1);
            $filenamePath = $faker->imageGenerator($dir = storage_path('app/public') . '/students/' . $student->nis . '/profile', $width = 200, $height = 200, $format = 'png', $fullPath = false, $text = ($firstLetter));

            $student->profile_picture_url = $filenamePath;

            $student->save();

            ClassesStudent::create([
                'student_nis' => $nis,
                'classes_id' => $faker->randomElement($classes)
            ]);
        }
    }
}
