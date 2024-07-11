<?php

namespace App\Livewire\Admin\FatSecret;

use GuzzleHttp\Client;
use Livewire\Component;

class FatSecretComponent extends Component
{

    public $search_value, $foods;

    public function mount()
    {
    }

    public function searchFoods()
    {
        $query = $this->search_value;

        $client = new Client();

        // update token if it's expired
        if (!session()->has('oauth2_token_expires_in') || (session()->get('oauth2_token_expires_in') < time())) {
            $token_response = $client->post('https://oauth.fatsecret.com/connect/token', [
                'form_params' => [
                    "grant_type" => 'client_credentials',
                    "client_id" => '4c0fcd962f204fe8a26f1e3b4e0a5c39',
                    "client_secret" => '6a07115e9fa04730af2f74de4c581097',
                    "scope" => 'premier barcode'
                ]
            ]);

            $token = json_decode($token_response->getBody(), true)['access_token'];
            $expires_in = json_decode($token_response->getBody(), true)['expires_in'];

            // session
            session()->put('oauth2_token', $token);
            session()->put('oauth2_token_expires_in', time() + $expires_in);
        }

        $oauth2Token = session()->get('oauth2_token');

        $response = $client->get('https://platform.fatsecret.com/rest/server.api', [
            'query' => [
                'method' => 'foods.search.v3',
                'search_expression' => $query,
                'format' => 'json',
                'include_sub_categories' => 'true',
                'flag_default_serving' => 'true',
                'max_results' => 25,
                'language' => 'en',
                'region' => 'US',
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $oauth2Token,
            ],
        ]);

        $foods = json_decode($response->getBody(), true)['foods_search']['results']['food'];
        $this->foods = $foods;

        $this->dispatch('reload_scripts');
    }

    public function render()
    {
        return view('livewire.admin.fat-secret.fat-secret-component')->layout('livewire.admin.layouts.base');
    }
}
