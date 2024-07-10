<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;

class OauthController extends Controller
{
    protected $client;

    public function __construct(Guzzle $client)
    {
        $this->middleware('auth');
        $this->client = $client;
    }

    public function redirect()
    {
        $query = http_build_query(
            [
                'client_id' => '4',
                'redirect_uri' => 'http://127.0.0.1:90/auth/passport/callback',
                'response_type' => 'code',
                'scope' => '',
            ]
        );

        return redirect('http://127.0.0.1:8000/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $response = $this->client->post('http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '4',
                'client_secret' => 'Rs2msVZgS8V8I0GPOJFZc2Q53CnrJJuxET7qPVJQ',
                'redirect_uri' => 'http://127.0.0.1:90/auth/passport/callback',
                'code' => $request->code,
            ]
        ]);

        $response = json_decode($response->getBody(), true);

        $request->user()->token()->delete();

        $request->user()->token()->create([
            'access_token' => $response['access_token'],
        ]);

        return redirect('/home');
    }
}
