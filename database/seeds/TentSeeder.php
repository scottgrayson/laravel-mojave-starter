<?php

use Illuminate\Database\Seeder;

class TentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tents = [];

        foreach ([1,2,3,4,5,6] as $grade) {
            foreach (['m', 'f'] as $sex) {
                $tents []= [
                    'name' => $grade . $this->ordinal_suffix($grade) . ' Grade ' . ($sex === 'm' ? 'Boys' : 'Girls'),
                    'sex' => $sex,
                    'grade' => $grade,
                    'camper_limit' => 30,
                ];
            }
        }

        DB::table('tents')->insert($tents);
    }

    public function ordinal_suffix($num)
    {
        $num = $num % 100; // protect against large numbers
        if ($num < 11 || $num > 13) {
            switch ($num % 10) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
            }
        }
        return 'th';
    }
}
