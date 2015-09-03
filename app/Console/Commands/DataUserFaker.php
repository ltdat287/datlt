<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User as Users;
use Faker\Factory as Faker;
use Validator;

class DataUserFaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'faker:user {boss_id} {--limit}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $boss_id = $this->argument('boss_id');
        $limit = $this->option('limit');

        // Validate input values of boss_id
        $valids = Validator::make(array(
            'boss_id' => $boss_id,
            'limit' => $limit
        ), array(
            'boss_id' => 'required|numeric',
            'limit' => 'required|numeric'
        ));

        if ($valids->fails()) {
            foreach($valids->messages()->all() as $msg){
                $this->error($msg);
                return $this->error('You need set values.');
            }
        } else {
            if ($this->confirm('Do you want add user used Faker? [y/n]')) {
                // Insert data faker for users.
                $faker = Faker::create();
                for ($i = 0; $i < $limit; $i++) {
                    $user = new Users;
                    $user->name         = $faker->name;
                    $user->email        = $faker->email;
                    $user->password     = bcrypt('123456789');
                    $user->kana         = $faker->name;
                    $user->telephone_no = $faker->phoneNumber;
                    $user->birthday     = $faker->date($format = 'Y-m-d', $max = 'now');
                    $user->note         = $faker->text;
                    if (count($boss_id)) {
                        $user->role     = 'boss';
                    } else {
                        $user->role     = 'employee';
                    }
                    $user->boss_id      = $boss_id;
                    $user->updated_at   = $faker->dateTime($max = 'now');
                    $user->created_at   = $faker->dateTime($max = $user->updated_at);
                    $user->save();

                    $this->info('Inserted ' . $i . ' records for user to database with boss_id:' . $boss_id);

                }

                // Draw table into console.
                $headers = ['id', 'name', 'email', 'password', 'boss_id'];
                $content = Users::all(['id', 'name', 'email', '123456789', 'boss_id'])->toArray();
                $this->table($headers, $content);

                return $this->info('Inserted database successful!');        
            }

            return $this->error('Errors insert database!');
        }
    }
}