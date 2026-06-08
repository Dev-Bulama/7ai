<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\SubscriberList;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index() {
        $campaigns = Campaign::with('creator','subscriberList')->latest()->paginate(20);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create() {
        $lists = SubscriberList::all();
        return view('admin.campaigns.create', compact('lists'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required','subject'=>'required','content'=>'required',
            'from_name'=>'required','from_email'=>'required|email',
            'type'=>'required','status'=>'required',
            'subscriber_list_id'=>'nullable|exists:subscriber_lists,id',
            'scheduled_at'=>'nullable|date',
        ]);
        $data['created_by'] = auth()->id();
        Campaign::create($data);
        return redirect()->route('admin.campaigns.index')->with('success','Campaign created.');
    }

    public function show(Campaign $campaign) {
        $campaign->load('sends','abTests');
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign) {
        $lists = SubscriberList::all();
        return view('admin.campaigns.edit', compact('campaign','lists'));
    }

    public function update(Request $request, Campaign $campaign) {
        $data = $request->validate([
            'name'=>'required','subject'=>'required','content'=>'required',
            'from_name'=>'required','from_email'=>'required|email',
            'type'=>'required','status'=>'required',
        ]);
        $campaign->update($data);
        return redirect()->route('admin.campaigns.index')->with('success','Campaign updated.');
    }

    public function destroy(Campaign $campaign) {
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success','Campaign deleted.');
    }

    public function generateAi(Request $request)
    {
        $request->validate(['goal'=>'required','audience'=>'required','tone'=>'required']);
        // In production this would call an AI API. For now returns a structured template.
        $subject = $this->buildSubject($request->goal, $request->tone);
        $preview = $this->buildPreview($request->goal);
        $body    = $this->buildBody($request->goal, $request->audience, $request->tone, $request->offer ?? '');
        return response()->json(['subject'=>$subject,'preview'=>$preview,'body'=>$body]);
    }

    private function buildSubject(string $goal, string $tone): string {
        $templates = [
            'Discover the future of smart living 🏠',
            'Your home, transformed — see how',
            'Exclusive offer: AI automation for your home',
            'The intelligence upgrade your business needs',
            '🚀 Ready to automate everything?',
        ];
        return $templates[array_rand($templates)];
    }

    private function buildPreview(string $goal): string {
        return 'Click to discover how 7AI is transforming homes and businesses across Africa.';
    }

    private function buildBody(string $goal, string $audience, string $tone, string $offer): string {
        return "<p>Dear {first_name},</p>
<p>At 7AI, we believe that intelligent technology should work for every African home and business.</p>
<p>Whether you're looking to automate your home, optimise your energy usage, or deploy AI to drive business results — we have the solution built specifically for your needs.</p>
<p><strong>Here's what we're offering you today:</strong></p>
<ul>
<li>Free 30-minute consultation with our experts</li>
<li>Custom solution design tailored to your requirements</li>
<li>Transparent pricing with no hidden fees</li>
</ul>
<p>Africa's intelligent era has arrived. Don't get left behind.</p>
<p><a href='https://7ai.africa/contact' style='background:#0B4F6C;color:white;padding:12px 24px;border-radius:6px;text-decoration:none;display:inline-block;margin-top:16px;'>Book Your Free Consultation →</a></p>
<p>Best regards,<br>The 7AI Team</p>";
    }
}
