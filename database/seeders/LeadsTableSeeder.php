<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LeadsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        for ($i = 1; $i <= 50; $i++) {
            Leads::create([
                'lead_id' => Str::uuid(),
                'lead_email' => "lead{$i}@example.com",
                'lead_phone' => rand(7000000000, 9999999999),
                'lead_enquiry_for' => 'Service Consultation',
                'lead_type' => 'Hot',
                'lead_status' => 'Converted', // '',
                'lead_given_date' => Carbon::now()->toDateString(),
                'lead_user_id' => 'USR' . rand(100, 999),
                'lead_create_date' => Carbon::now(),
                'lead_update_date' => Carbon::now(),
                'lead_delete' => 'N',
            ]);
        }
    }
}
