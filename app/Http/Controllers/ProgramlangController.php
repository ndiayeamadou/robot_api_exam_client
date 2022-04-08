<?php

namespace App\Http\Controllers;

use App\helper\HttpClient;

class ProgramlangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $url = env("BASE_API_URL") . "programming_languages";
        $options = [
            "data"  =>  ['format' => 'json'],
            'headers' =>['Content-Type' => 'application/json']
        ];
        $rest = HttpClient::get($url, $options);

        return $rest;
    }

    public function index_test()
    {
        $array = [
            [
              "code"=> "ruby",
              "displayName"=> "Ruby"
            ],
            [
              "code"=> "python",
              "displayName"=> "Python"
            ],
            [
              "code"=> "java",
              "displayName"=> "Java"
            ]
        ];
        return response()->json($array);
    }

}
