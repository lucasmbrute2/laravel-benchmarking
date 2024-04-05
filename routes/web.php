<?php

use App\Models\City;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Route;

Route::get('/seeding', function () {
    $arr =  json_decode(file_get_contents(public_path('test-file.json')), true);
    $testFile = array_map(function ($val) {
        return [
            'destino_turistico' => $val['Destino Turístico'],
            'aeroporto' => $val['Aeroporto']?? '',
            'distancia' => $val['Distância']
        ];
    },$arr);
    City::insert($testFile);
});

Route::get('/find-json', function () {
    $input = 'este destino não existe';
    Benchmark::dd([
        'Scenario 1' => function () use ($input){
            return City::whereFullText(['destino_turistico'], $input)->get();
        },
        'Scenario 2' => function () use ($input){
            $arr =  json_decode(file_get_contents(public_path('test-file.json')), true);
            return array_filter($arr, function ($item) use ($input) {
                if (isset($item['Destino Turístico']) && str_contains($item['Destino Turístico'], $input) ) {
                    return $item;
                }
                return null;
            });
        },
    ], iterations: 10000);
});

