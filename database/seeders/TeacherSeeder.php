<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use bheller\ImagesGenerator\ImagesGeneratorProvider;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Xvladqt\Faker\LoremFlickrProvider;

class TeacherSeeder extends Seeder
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

        for ($i = 0; $i < 15; $i++) {
            $teacher = new Teacher();
            $teacher->name = $faker->name;
            $teacher->phone_number = $faker->phoneNumber;
            $teacher->nip = $faker->numberBetween(100000000000, 999999999999);
            $teacher->email = $faker->email;
            
            $teacher->address = $faker->address;
            $teacher->blood_type = $faker->randomElement($array = ['A', 'B', 'O', 'AB']);
            $teacher->place_of_birth = $faker->city;
            $teacher->date_of_birth = $faker->dateTimeThisCentury->format('Y-m-d');

            if($i%2 == 0){
                $teacher->gender = "Laki-laki";
            }else{
                $teacher->gender = "Perempuan";
            }


            $path = "public/teachers/" . $teacher->nip . "/profile";

            Storage::deleteDirectory($path);
            Storage::makeDirectory($path);
            $firstLetter = substr($teacher->name, 0, 1);
            $filenamePath = $faker->imageGenerator($dir = storage_path('app/public') . '/teachers/' . $teacher->nip . '/profile', $width = 200, $height = 200, $format = 'png', $fullPath = false, $text = ($firstLetter));

            $teacher->profile_picture_url = $filenamePath;

            $teacher->save();
        }
    }
}
