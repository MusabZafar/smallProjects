<?php

use Illuminate\Support\Facades\Route;

$jobs = [
    [
        'id' => 1,
        'title' => 'Manager',
        'salary' => '$50000'
    ],
    [
        'id' => 2,
        'title' => 'Engineer',
        'salary' => '$40000'
    ],
    [
        'id' => 3,
        'title' => 'Technician',
        'salary' => '$32000'
    ]
];

Route::get('/', function () {
    return view('home');
});

Route::get('/jobs', function () use ($jobs) {
    return view('jobs', [
        'jobs' => $jobs
    ]);
});

Route::get('/jobs/{id}', function ($id) use ($jobs) {
    $job = \Illuminate\Support\Arr::first($jobs, fn($job) => $job['id'] == $id);

    return view('job', [
        'job' => $job
    ]);
});

Route::get('/contact', function () {
    return view('contact');
});