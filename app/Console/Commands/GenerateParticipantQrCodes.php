<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\ConferenceSetting;
use Illuminate\Support\Str;

class GenerateParticipantQrCodes extends Command
{
    protected $signature = 'conference:generate-participant-qrcodes
                            {--form= : Slug of the conference form (defaults to all conference forms)}
                            {--force : Re-generate even if already set}';

    protected $description = 'Generate participant IDs and QR tokens for conference form submissions';

    public function handle(): int
    {
        $query = Form::where('is_conference_form', true);

        if ($slug = $this->option('form')) {
            $query->where('slug', $slug);
        }

        $forms = $query->get();

        if ($forms->isEmpty()) {
            $this->error('No conference forms found. Mark a form as is_conference_form=true first.');
            return 1;
        }

        foreach ($forms as $form) {
            $this->processForm($form);
        }

        return 0;
    }

    private function processForm(Form $form): void
    {
        $settings = ConferenceSetting::firstOrCreate(
            ['form_id' => $form->id],
            ['event_name' => $form->name, 'participant_id_prefix' => 'CONF']
        );

        $prefix = strtoupper($settings->participant_id_prefix ?: 'CONF');
        $force  = $this->option('force');

        $submissions = $form->submissions()
            ->when(!$force, fn($q) => $q->whereNull('qr_token'))
            ->get();

        if ($submissions->isEmpty()) {
            $this->info("[{$form->name}] No submissions need QR tokens.");
            return;
        }

        $bar = $this->output->createProgressBar($submissions->count());
        $bar->start();

        $seq = FormSubmission::whereNotNull('participant_id')
            ->where('participant_id', 'like', "{$prefix}-%")
            ->count();

        foreach ($submissions as $submission) {
            $seq++;
            $participantId = $prefix . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
            $qrToken       = Str::random(32) . base_convert($submission->id, 10, 36);

            $submission->update([
                'participant_id' => $participantId,
                'qr_token'       => $qrToken,
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("[{$form->name}] Generated {$submissions->count()} QR tokens.");

        $settings->update(['qr_generated_at' => now()->toDateTimeString()]);
    }
}
