<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\ConferenceSetting;
use App\Models\ParticipantScanLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedConferenceTestData extends Command
{
    protected $signature = 'conference:seed-test-data
                            {--force : Re-seed even if test data already exists}';

    protected $description = 'Create safe test accounts and dummy participants for the conference system';

    private array $staffAccounts = [
        ['name' => '7AI Admin Test',    'email' => 'admin.test@7ai.africa',   'role' => 'admin'],
        ['name' => 'Front Desk One',    'email' => 'frontdesk1@7ai.africa',   'role' => 'front-desk-staff'],
        ['name' => 'Front Desk Two',    'email' => 'frontdesk2@7ai.africa',   'role' => 'front-desk-staff'],
        ['name' => 'Lunch Scanner One', 'email' => 'lunch1@7ai.africa',       'role' => 'lunch-staff'],
        ['name' => 'Lunch Scanner Two', 'email' => 'lunch2@7ai.africa',       'role' => 'lunch-staff'],
    ];

    private array $participants = [
        ['full_name'=>'Aisha Musa',         'email'=>'aisha.musa@testmail.dev',        'phone'=>'+2348011111001','occupation'=>'Student',                'course'=>'AI & Machine Learning Fundamentals'],
        ['full_name'=>'Daniel Okafor',      'email'=>'daniel.okafor@testmail.dev',     'phone'=>'+2348011111002','occupation'=>'Business Owner',          'course'=>'AI for Business & Productivity'],
        ['full_name'=>'Fatima Bello',       'email'=>'fatima.bello@testmail.dev',      'phone'=>'+2348011111003','occupation'=>'Employee / Professional', 'course'=>'Prompt Engineering & ChatGPT Mastery'],
        ['full_name'=>'Chinedu Eze',        'email'=>'chinedu.eze@testmail.dev',       'phone'=>'+2348011111004','occupation'=>'Freelancer',              'course'=>'AI Automation & No-Code Tools'],
        ['full_name'=>'Maryam Abubakar',    'email'=>'maryam.abubakar@testmail.dev',   'phone'=>'+2348011111005','occupation'=>'Government Worker',       'course'=>'Data Science & Analytics with AI'],
        ['full_name'=>'John Adewale',       'email'=>'john.adewale@testmail.dev',      'phone'=>'+2348011111006','occupation'=>'Job Seeker',              'course'=>'Natural Language Processing (NLP)'],
        ['full_name'=>'Grace Ibrahim',      'email'=>'grace.ibrahim@testmail.dev',     'phone'=>'+2348011111007','occupation'=>'Student',                 'course'=>'Computer Vision & Image Recognition'],
        ['full_name'=>'Peter Ojo',          'email'=>'peter.ojo@testmail.dev',         'phone'=>'+2348011111008','occupation'=>'Employee / Professional', 'course'=>'AI & Machine Learning Fundamentals'],
        ['full_name'=>'Zainab Aliyu',       'email'=>'zainab.aliyu@testmail.dev',      'phone'=>'+2348011111009','occupation'=>'Business Owner',          'course'=>'AI for Business & Productivity'],
        ['full_name'=>'Samuel Johnson',     'email'=>'samuel.johnson@testmail.dev',    'phone'=>'+2348011111010','occupation'=>'Freelancer',              'course'=>'Prompt Engineering & ChatGPT Mastery'],
        ['full_name'=>'Esther Nnaji',       'email'=>'esther.nnaji@testmail.dev',      'phone'=>'+2348011111011','occupation'=>'Student',                 'course'=>'AI Automation & No-Code Tools'],
        ['full_name'=>'Mohammed Sani',      'email'=>'mohammed.sani@testmail.dev',     'phone'=>'+2348011111012','occupation'=>'Government Worker',       'course'=>'Data Science & Analytics with AI'],
        ['full_name'=>'Blessing Uche',      'email'=>'blessing.uche@testmail.dev',     'phone'=>'+2348011111013','occupation'=>'Job Seeker',              'course'=>'Natural Language Processing (NLP)'],
        ['full_name'=>'David Hassan',       'email'=>'david.hassan@testmail.dev',      'phone'=>'+2348011111014','occupation'=>'Employee / Professional', 'course'=>'Computer Vision & Image Recognition'],
        ['full_name'=>'Halima Yusuf',       'email'=>'halima.yusuf@testmail.dev',      'phone'=>'+2348011111015','occupation'=>'Business Owner',          'course'=>'AI & Machine Learning Fundamentals'],
    ];

    public function handle(): int
    {
        $this->info('=== Conference Test Data Seeder ===');
        $this->newLine();

        $this->seedStaffAccounts();
        $this->newLine();
        $this->seedParticipants();
        $this->newLine();
        $this->info('✓ Done. Use password "password" for all test accounts.');
        $this->info('⚠  These are TEST accounts. Do not use in production without changing passwords.');

        return 0;
    }

    private function seedStaffAccounts(): void
    {
        $this->info('── Staff Accounts ──────────────────');
        $force = $this->option('force');

        foreach ($this->staffAccounts as $account) {
            $exists = User::where('email', $account['email'])->exists();

            if ($exists && !$force) {
                $this->line("  SKIP  {$account['email']} (already exists)");
                continue;
            }

            $user = User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name'      => $account['name'],
                    'password'  => Hash::make('password'),
                    'is_active' => true,
                ]
            );

            // Sync role (remove old roles first to avoid duplicates)
            $user->syncRoles([$account['role']]);

            $this->line("  CREATE {$account['email']} → {$account['role']}");
        }
    }

    private function seedParticipants(): void
    {
        $this->info('── Dummy Participants ──────────────');

        // Find a conference form to attach participants to
        $form = Form::where('is_conference_form', true)->first()
            ?? Form::whereIn('slug', ['abuja', 'learnai'])->first()
            ?? Form::first();

        if (!$form) {
            $this->warn('  No form found. Create a form first.');
            return;
        }

        $this->info("  Attaching to form: {$form->name} (ID: {$form->id})");

        // Ensure conference settings exist
        $settings = ConferenceSetting::firstOrCreate(
            ['form_id' => $form->id],
            [
                'event_name'            => $form->name,
                'participant_id_prefix' => 'CONF',
                'lunch_enabled'         => true,
                'lunch_rounds'          => 1,
                'badge_enabled'         => true,
            ]
        );

        $prefix  = strtoupper($settings->participant_id_prefix ?: 'CONF');
        $force   = $this->option('force');

        // Get current max sequence
        $seq = FormSubmission::whereNotNull('participant_id')
            ->where('participant_id', 'like', "{$prefix}-%")
            ->count();

        // Mixed statuses for test realism
        $checkInStatuses = [true, true, true, true, true, false, false, false, true, false, true, true, false, true, false];
        $lunchStatuses   = [true, true, true, false, true, false, false, false, true, false, false, true, false, true, false];

        foreach ($this->participants as $idx => $p) {
            $exists = FormSubmission::where('form_id', $form->id)
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.email')) = ?", [$p['email']])
                ->exists();

            if ($exists && !$force) {
                $this->line("  SKIP  {$p['full_name']} (already exists)");
                continue;
            }

            $seq++;
            $participantId = $prefix . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
            $qrToken       = Str::random(32) . base_convert($seq + 1000, 10, 36);

            $shouldCheckIn = $checkInStatuses[$idx] ?? false;
            $shouldLunch   = $shouldCheckIn && ($lunchStatuses[$idx] ?? false);

            $submission = FormSubmission::updateOrCreate(
                [
                    'form_id' => $form->id,
                    'participant_id' => $participantId,
                ],
                [
                    'data' => array_merge($p, [
                        'learning_mode'  => 'Online (Live Sessions)',
                        'experience_level'=> 'Some Technical Background',
                        'referral_source' => 'Friend or Colleague',
                    ]),
                    'ip_address'          => '127.0.0.' . ($idx + 1),
                    'user_agent'          => 'Mozilla/5.0 (Test Seed)',
                    'is_read'             => 1,
                    'qr_token'            => $qrToken,
                    'attendance_verified' => $shouldCheckIn,
                    'checked_in_at'       => $shouldCheckIn ? now()->subMinutes(rand(5, 180)) : null,
                    'lunch_collected'     => $shouldLunch,
                    'lunch_collected_at'  => $shouldLunch ? now()->subMinutes(rand(5, 120)) : null,
                    'created_at'          => now()->subDays(rand(1, 7)),
                    'updated_at'          => now(),
                ]
            );

            $checkedIn = $shouldCheckIn ? '✓ IN' : '  OUT';
            $lunch     = $shouldLunch   ? '🍽 YES' : '     ';
            $this->line("  CREATE [{$participantId}] {$p['full_name']} {$checkedIn} {$lunch}");
        }

        // Update settings to record QR generation
        $settings->update(['qr_generated_at' => now()]);

        // Mark form as conference form if not already
        if (!$form->is_conference_form) {
            $form->update(['is_conference_form' => true]);
            $this->info("  ✓ Enabled conference mode on form: {$form->name}");
        }
    }
}
