<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Nav CTA settings
        $navSettings = [
            'nav_cta_text'        => 'AI CONFERENCE',
            'nav_cta_url'         => '/abuja',
            'nav_secondary_text'  => 'About',
            'nav_secondary_url'   => '/about',
        ];
        foreach ($navSettings as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['key' => $key, 'value' => $value, 'group' => 'nav', 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // /abuja landing page
        $exists = DB::table('pages')->where('slug', 'abuja')->exists();
        if (!$exists) {
            DB::table('pages')->insert([
                'title'            => 'Abuja AI Conference',
                'slug'             => 'abuja',
                'meta_description' => 'Register for FREE to learn how AI can impact your work, home and organisation.',
                'content'          => '<h2>Abuja AI Conference Registration</h2>
<p>Register for FREE to learn how AI can impact your work, home and organisation.</p>

<h3>What You Will Learn</h3>
<ul>
  <li>How AI is transforming homes across Africa — smart lighting, security, and energy</li>
  <li>How businesses in Abuja are using AI to cut costs and serve customers better</li>
  <li>Practical AI tools you can start using today — no technical background needed</li>
  <li>What the AI era means for Nigeria and how to position yourself ahead of it</li>
</ul>

<h3>Who Should Attend</h3>
<ul>
  <li>Professionals and business owners in Abuja, FCT</li>
  <li>Government staff and policy makers interested in AI</li>
  <li>Homeowners curious about smart home automation</li>
  <li>Anyone who wants to understand and benefit from Africa\'s AI transition</li>
</ul>

<h3>Event Details</h3>
<p>Location: Abuja, FCT — venue to be confirmed to registered attendees.<br>
Registration is free. Limited seats available.</p>

<p><strong>Register now</strong> using the contact form below and our team will send you the full event details.</p>',
                'template'         => 'landing',
                'status'           => 'published',
                'created_by'       => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['nav_cta_text','nav_cta_url','nav_secondary_text','nav_secondary_url'])->delete();
        DB::table('pages')->where('slug', 'abuja')->delete();
    }
};
