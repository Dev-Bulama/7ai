<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use App\Services\SmtpMailService;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function index() {
        $forms = Form::withCount('submissions')->orderByDesc('created_at')->paginate(20);
        return view('admin.forms.index', compact('forms'));
    }
    public function create() { return view('admin.forms.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name'               => 'required|max:255',
            'slug'               => 'nullable|unique:forms,slug',
            'public_path'        => 'nullable|max:100',
            'title'              => 'nullable|max:255',
            'subtitle'           => 'nullable|max:500',
            'description'        => 'nullable',
            'success_message'    => 'nullable',
            'redirect_url'       => 'nullable|max:255',
            'notification_email' => 'nullable|email|max:255',
            'store_submissions'  => 'nullable|boolean',
            'is_active'          => 'nullable|boolean',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        if (!empty($data['public_path']) && !str_starts_with($data['public_path'], '/')) {
            $data['public_path'] = '/' . $data['public_path'];
        }
        $data['store_submissions'] = $request->boolean('store_submissions', true);
        $data['is_active'] = $request->boolean('is_active', true);
        $form = Form::create($data);
        return redirect()->route('admin.forms.edit', $form)->with('success', 'Form created. Now add fields.');
    }
    public function edit(Form $form) {
        $form->load('fields');
        return view('admin.forms.edit', compact('form'));
    }
    public function update(Request $request, Form $form) {
        $data = $request->validate([
            'name'               => 'required|max:255',
            'slug'               => 'nullable|unique:forms,slug,' . $form->id,
            'public_path'        => 'nullable|max:100',
            'title'              => 'nullable|max:255',
            'subtitle'           => 'nullable|max:500',
            'description'        => 'nullable',
            'success_message'    => 'nullable',
            'redirect_url'       => 'nullable|max:255',
            'notification_email' => 'nullable|email|max:255',
            'store_submissions'        => 'nullable|boolean',
            'is_active'                => 'nullable|boolean',
            'welcome_email_enabled'    => 'nullable|boolean',
            'welcome_email_subject'    => 'nullable|max:255',
            'welcome_email_body'       => 'nullable',
            'welcome_email_from_name'  => 'nullable|max:255',
            'welcome_email_from_address' => 'nullable|email|max:255',
            'welcome_email_field'      => 'nullable|max:100',
        ]);
        if (empty($data['slug'])) $data['slug'] = Str::slug($data['name']);
        if (!empty($data['public_path']) && !str_starts_with($data['public_path'], '/')) {
            $data['public_path'] = '/' . $data['public_path'];
        }
        $data['store_submissions'] = $request->boolean('store_submissions', true);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['welcome_email_enabled'] = $request->boolean('welcome_email_enabled', false);
        $form->update($data);
        return redirect()->route('admin.forms.edit', $form)->with('success', 'Form updated.');
    }
    public function destroy(Form $form) {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted.');
    }

    // Field management
    public function storeField(Request $request, Form $form) {
        $data = $request->validate([
            'label' => 'required|max:255',
            'name' => 'required|max:100|regex:/^[a-z_][a-z0-9_]*$/',
            'field_type' => 'required|in:text,email,phone,number,textarea,select,radio,checkbox,file,date,hidden',
            'placeholder' => 'nullable|max:255',
            'help_text' => 'nullable',
            'is_required' => 'nullable|boolean',
            'options' => 'nullable',
            'sort_order' => 'nullable|integer',
        ]);
        $data['form_id'] = $form->id;
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active'] = true;
        FormField::create($data);
        return redirect()->route('admin.forms.edit', $form)->with('success', 'Field added.');
    }
    public function updateField(Request $request, Form $form, FormField $field) {
        $data = $request->validate([
            'label'      => 'required|max:255',
            'name'       => ['required', 'max:100', 'regex:/^[a-z_][a-z0-9_]*$/',
                             \Illuminate\Validation\Rule::unique('form_fields', 'name')
                                 ->where('form_id', $form->id)
                                 ->ignore($field->id)],
            'field_type' => 'required|in:text,email,phone,number,textarea,select,radio,checkbox,file,date,hidden',
            'placeholder'=> 'nullable|max:255',
            'help_text'  => 'nullable',
            'is_required'=> 'nullable|boolean',
            'options'    => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active']   = $request->boolean('is_active', true);
        $field->update($data);
        return redirect()->route('admin.forms.edit', $form)->with('success', 'Field updated.');
    }
    public function destroyField(Form $form, FormField $field) {
        $field->delete();
        return redirect()->route('admin.forms.edit', $form)->with('success', 'Field deleted.');
    }

    // Submissions
    public function submissions(Form $form) {
        $submissions = FormSubmission::where('form_id', $form->id)->orderByDesc('created_at')->paginate(30);
        $form->load('fields');
        return view('admin.forms.submissions', compact('form', 'submissions'));
    }
    public function markRead(FormSubmission $submission) {
        $submission->update(['is_read' => true]);
        return back()->with('success', 'Marked as read.');
    }

    public function exportSubmissions(Form $form)
    {
        $submissions = FormSubmission::where('form_id', $form->id)->orderByDesc('created_at')->get();
        $fields = $form->fields()->orderBy('sort_order')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $form->slug . '-submissions-' . now()->format('Ymd') . '.csv"',
        ];

        $callback = function () use ($submissions, $fields, $form) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM for Excel

            // Header row
            $cols = ['ID', 'Form', 'Date'];
            foreach ($fields as $f) $cols[] = $f->label;
            $cols[] = 'IP Address';
            $cols[] = 'User Agent';
            fputcsv($handle, $cols);

            // Data rows
            foreach ($submissions as $sub) {
                $row = [$sub->id, $form->name, $sub->created_at->format('Y-m-d H:i:s')];
                foreach ($fields as $f) {
                    $val = $sub->data[$f->name] ?? '';
                    $row[] = is_array($val) ? implode(', ', $val) : $val;
                }
                $row[] = $sub->ip_address;
                $row[] = $sub->user_agent;
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroySubmission(Form $form, FormSubmission $submission)
    {
        abort_if($submission->form_id !== $form->id, 404);
        $submission->delete();
        return redirect()->route('admin.forms.submissions', $form)->with('success', 'Submission deleted.');
    }

    public function resendEmail(Form $form, FormSubmission $submission)
    {
        abort_if($submission->form_id !== $form->id, 404);

        if (!$form->welcome_email_enabled) {
            return back()->with('error', 'Welcome email is not enabled for this form. Enable it in the Welcome Email tab first.');
        }

        $data = is_array($submission->data) ? $submission->data : [];

        // Resolve recipient using same priority logic as FrontendController
        $toEmail = null;
        if ($form->welcome_email_field && !empty($data[$form->welcome_email_field])) {
            $toEmail = $data[$form->welcome_email_field];
        }
        if (!$toEmail) {
            foreach (['email', 'email_address', 'your_email', 'registrant_email'] as $key) {
                if (!empty($data[$key]) && filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $data[$key];
                    break;
                }
            }
        }
        if (!$toEmail) {
            $emailField = $form->fields->where('field_type', 'email')->where('is_active', true)->first();
            if ($emailField && !empty($data[$emailField->name])) {
                $toEmail = $data[$emailField->name];
            }
        }
        if (!$toEmail) {
            foreach ($data as $val) {
                if (is_string($val) && filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $toEmail = $val;
                    break;
                }
            }
        }

        if (!$toEmail) {
            return back()->with('error', 'No email address found in this submission.');
        }

        $siteName     = Setting::get('site_name', '7AI');
        $supportEmail = Setting::get('support_email') ?: Setting::get('contact_email', '');
        $submittedName = $data['name']
            ?? $data['full_name']
            ?? (trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?: null)
            ?? $data['your_name']
            ?? '';

        $vars = array_merge($data, [
            'name'          => $submittedName,
            'email'         => $toEmail,
            'form_name'     => $form->name,
            'site_name'     => $siteName,
            'support_email' => $supportEmail,
            'current_year'  => date('Y'),
        ]);

        $replace = fn(string $text) => preg_replace_callback(
            '/\{\{(\w+)\}\}/',
            fn($m) => $vars[$m[1]] ?? '',
            $text
        );

        $subject = $replace($form->welcome_email_subject ?: 'Thank you for registering — ' . $form->name);

        $defaultBody = '<div style="font-family:sans-serif;max-width:560px;margin:40px auto;padding:32px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">'
            . '<h2 style="color:#0b4f6c;margin-top:0;">Hello ' . e($vars['name']) . ',</h2>'
            . '<p style="color:#374151;line-height:1.7;">Thank you for registering for <strong>' . e($vars['form_name']) . '</strong>.</p>'
            . '<p style="color:#374151;line-height:1.7;">We have received your submission successfully. Our team will review your details and contact you if necessary.</p>'
            . '<p style="color:#374151;line-height:1.7;">Thank you,<br><strong>' . e($vars['site_name']) . '</strong></p>'
            . '<hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">'
            . '<p style="font-size:12px;color:#9ca3af;">© ' . $vars['current_year'] . ' ' . e($vars['site_name']) . '</p></div>';

        $htmlBody = $form->welcome_email_body ? $replace($form->welcome_email_body) : $defaultBody;
        $fromName = $form->welcome_email_from_name    ?: Setting::get('mail_from_name', '7AI');
        $fromAddr = $form->welcome_email_from_address ?: Setting::get('mail_from_address', 'hello@7ai.africa');

        try {
            $configured = SmtpMailService::configure();
            if (!$configured) {
                return back()->with('error', 'SMTP is not configured. Go to Settings → Email and save your SMTP credentials.');
            }

            Mail::html($htmlBody, function ($msg) use ($toEmail, $subject, $fromName, $fromAddr) {
                $msg->to($toEmail)->subject($subject)->from($fromAddr, $fromName);
            });

            \Log::info('[FORM EMAIL] Admin resent welcome email', [
                'to'   => $toEmail,
                'form' => $form->id,
                'sub'  => $submission->id,
            ]);

            return back()->with('success', "Welcome email resent to {$toEmail}.");

        } catch (\Throwable $e) {
            \Log::error('[FORM EMAIL ERROR] Admin resend failed', [
                'to'    => $toEmail,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Failed to send: ' . $e->getMessage());
        }
    }
}

