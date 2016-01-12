<?php

use Illuminate\Database\Seeder;
use CodeDelivery\Models\OauthClient;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        factory(OauthClient::class)->create([
            'id' => 'appid01',
            'secret' => 'secret',
            'name' => 'Minha App Mobile'
        ]);
    }
}
