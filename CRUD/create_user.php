<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::updateOrCreate(
    ['email' => 'pete@abc.com'],
    ['name' => 'Peter', 'password' => Hash::make('qwerty1234')]
);

echo "User created with ID: " . $user->id . "\n";
