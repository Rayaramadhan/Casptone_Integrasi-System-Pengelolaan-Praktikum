<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== DEBUG SUBMISSIONS ===\n\n";

// Total submissions
echo "Total Submissions: " . Submission::count() . "\n\n";

// All submissions
echo "All Submissions:\n";
$submissions = DB::table('submissions')
    ->select('id', 'asprak_id', 'assignment_id', 'status', 'created_at')
    ->get();

foreach($submissions as $sub) {
    echo sprintf(
        "ID: %d | Asprak ID: %d | Assignment: %d | Status: %s | Created: %s\n",
        $sub->id,
        $sub->asprak_id,
        $sub->assignment_id,
        $sub->status,
        $sub->created_at
    );
}

echo "\n";

// All users yang asprak
echo "Users dengan role asprak:\n";
$asprakUsers = User::where('usertype', 'asprak')->get();
foreach($asprakUsers as $user) {
    echo sprintf("ID: %d | Name: %s | Email: %s\n", $user->id, $user->name, $user->email);
}

echo "\n=== END DEBUG ===\n";
