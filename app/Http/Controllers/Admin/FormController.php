<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
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
            'label' => 'required|max:255',
            'placeholder' => 'nullable|max:255',
            'help_text' => 'nullable',
            'is_required' => 'nullable|boolean',
            'options' => 'nullable',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_required'] = $request->boolean('is_required');
        $data['is_active'] = $request->boolean('is_active', true);
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
}

