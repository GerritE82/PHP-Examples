<?php

/*
    The Random class can be used to generate data for the database similar to "Faker".
*/

namespace App\Classes;

class Random
{
    public static function password(int $length) : string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        
        $password = '';

        for($i=0; $i<$length; $i++)
        {
            $password .= $characters[random_int(0, strlen($characters) -1)];
        }
        return $password;
    }

    public static function firstName(string $gender) : string
    {
        $names = NULL;

        switch ($gender) {
            case 'male':
                $names = file(public_path('assets/textfiles/malenames.txt'));
                break;

            case 'female':
                $names = file(public_path('assets/textfiles/femalenames.txt'));
                break;

            case 'other':
                if(random_int(0,100) < 50)
                {
                    $names = file(public_path('assets/textfiles/malenames.txt'));
                }
                else
                {
                    $names = file(public_path('assets/textfiles/femalenames.txt'));
                }
                break;
        }

        return $names[array_rand($names)];
    }

    public static function surname() : string
    {
        $names = file(public_path('assets/textfiles/surnames.txt'));

        return $names[array_rand($names)];
    }

    public static function dateOfBirth()
    {
        // Set the format that corresponds with date() format
        $dateFormat = 'Y-m-d H:i:s';

        // Calculate the maximum range of birth year (users are 18+)
        $maxYear = date('Y') - 18;

        // Generate Random Values
        $year = random_int(1950, $maxYear);
        $month = random_int(1,12);
        $day = random_int(1,28);    // can implement correct month legth later...

        // Return random Date with correct formatting
        return date($dateFormat, strtotime("$year-$month-$day 00:00:00"));
    }

    public static function email(string $name, string $surname="") : string
    {
        $domains = ['hotmail', 'gmail', 'yahoo', 'aol', 'msn', 'wanadoo', 'live', 'nasa', 'skynet', 'frontier', 'lycosmail'];
        $extensions = ['.nl', '.com', '.co.uk', '.gov', '.net', '.fr', '.de'];

        $identifier = '';

        if($surname === "")
        {
            $identifier .= trim(strtolower($name));
        }
        else
        {
            if(random_int(0,100) < 50)
            {
                $identifier .= trim(strtolower($name[0])) . '.' . trim(strtolower(str_replace(' ', '', $surname)));
            }
            else
            {
                $identifier .= trim(strtolower($name));
            }
        }

        $email = $identifier . '@' . $domains[array_rand($domains)] . $extensions[array_rand($extensions)];

        return $email;
    }

    public static function phoneNumber() : string
    {
        $phoneNumber = '';

        if(random_int(0,100) < 50)
        {
            $phoneNumber .= '06';
        }
        else
        {
            $phoneNumber .= '05';
        }

        for($i=0; $i<8;$i++)
        {
            $phoneNumber .= random_int(0,9);
        }

        return $phoneNumber;
    }

    public static function streetName() : string
    {
        $names = file(public_path('assets/textfiles/streetnames.txt'));

        return $names[array_rand($names)];
    }

    public static function postalCode() : string
    {
        $postalCode = random_int(1000,9999);

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $letters = '';

        for($i=0; $i<2; $i++)
        {
            $letters .= $chars[random_int(0, strlen($chars) -1)];
        }

        return $postalCode . ' ' . $letters;
    }

    public static function houseNumber() : string
    {
        $chars = 'abcd';

        $houseNumber = random_int(1, 130);
        if(random_int(0,100) < 10)
        {
            $houseNumber .= $chars[random_int(0, strlen($chars) -1)];
        }

        return $houseNumber;
    }

    public static function townName() : string
    {
        $names = file(public_path('assets/textfiles/townnames.txt'));

        return $names[array_rand($names)];
    }

    public static function price($min, $max)
    {
        $whole = random_int($min, $max);
        $decimal = random_int(0,9999);

        $price = "$whole.$decimal";
        $price = round($price, 2);

        return number_format($price, 2);
    }
}