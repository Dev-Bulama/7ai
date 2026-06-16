<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CtaController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\TicketController as CustomerTicketController;
use App\Http\Controllers\LeadCaptureController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InvestorController;

// Public frontend routes
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/solutions', [FrontendController::class, 'solutions'])->name('solutions');
Route::get('/smart-homes', [FrontendController::class, 'smartHomes'])->name('smart-homes');
Route::get('/ai-solutions', [FrontendController::class, 'aiSolutions'])->name('ai-solutions');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('/case-studies', [FrontendController::class, 'caseStudies'])->name('case-studies');
Route::get('/industries', [FrontendController::class, 'industries'])->name('industries');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/careers', [FrontendController::class, 'careers'])->name('careers');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::get('/support', [FrontendController::class, 'support'])->name('support');
Route::get('/docs', [FrontendController::class, 'docs'])->name('docs');
Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/terms', [FrontendController::class, 'terms'])->name('terms');
Route::post('/contact', [LeadCaptureController::class, 'store'])->name('contact.submit');
Route::get('/investors', [FrontendController::class, 'investors'])->name('investors');
Route::post('/investors/register', [InvestorController::class, 'store'])->name('investors.register');

// Pillar pages
Route::get('/smart-home', [FrontendController::class, 'smartHome'])->name('smart-home');
Route::get('/business-automation', [FrontendController::class, 'businessAutomation'])->name('business-automation');
Route::get('/personal-ai', [FrontendController::class, 'personalAi'])->name('personal-ai');
Route::get('/advisory', [FrontendController::class, 'advisory'])->name('advisory');

// Public form view & submission
Route::get('/forms/{form:slug}', [FrontendController::class, 'showForm'])->name('forms.show');
Route::post('/forms/{form}/submit', [FrontendController::class, 'submitForm'])->name('forms.submit');

// Dynamic public form paths (e.g. /abuja)
Route::get('/{formPath}', [FrontendController::class, 'dynamicFormPage'])
    ->where('formPath', '^(?!login|register|logout|admin|dashboard|forms|solutions|smart-homes?|ai-solutions|pricing|case-studies|industries|about|careers|blog|contact|support|docs|privacy|terms|investors|business-automation|personal-ai|advisory)[a-z0-9][a-z0-9\-]*$')
    ->name('form.dynamic');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->prefix('dashboard')->name('customer.')->group(function () {
    Route::get('/', [CustomerDashboard::class, 'index'])->name('dashboard');
    Route::get('/projects', [CustomerDashboard::class, 'projects'])->name('projects');
    Route::get('/invoices', [CustomerDashboard::class, 'invoices'])->name('invoices');
    Route::resource('tickets', CustomerTicketController::class)->only(['index','create','store','show']);
    Route::post('tickets/{ticket}/reply', [CustomerTicketController::class, 'reply'])->name('tickets.reply');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class)->except(['create','store']);

    // CMS Pages
    Route::resource('pages', PageController::class);
    Route::post('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');

    // Blog Posts
    Route::resource('posts', PostController::class);

    // Services
    Route::resource('service-categories', ServiceCategoryController::class);
    Route::resource('services', ServiceController::class);

    // Testimonials, FAQs, Cards, CTAs, Banners
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::resource('faqs', FaqController::class)->except(['show']);
    Route::resource('cards', CardController::class)->except(['show']);
    Route::resource('ctas', CtaController::class)->except(['show']);
    Route::resource('banners', BannerController::class)->except(['show']);

    // Team Management
    Route::resource('team', TeamController::class)->except(['show']);

    // Form Builder
    Route::resource('forms', FormController::class)->except(['show']);
    Route::post('forms/{form}/fields', [FormController::class, 'storeField'])->name('forms.fields.store');
    Route::put('forms/{form}/fields/{field}', [FormController::class, 'updateField'])->name('forms.fields.update');
    Route::delete('forms/{form}/fields/{field}', [FormController::class, 'destroyField'])->name('forms.fields.destroy');
    Route::get('forms/{form}/submissions', [FormController::class, 'submissions'])->name('forms.submissions');
    Route::get('forms/{form}/submissions/export', [FormController::class, 'exportSubmissions'])->name('forms.submissions.export');
    Route::delete('forms/{form}/submissions/{submission}', [FormController::class, 'destroySubmission'])->name('form-submissions.destroy');
    Route::post('form-submissions/{submission}/read', [FormController::class, 'markRead'])->name('form-submissions.read');
    Route::post('forms/{form}/submissions/{submission}/resend-email', [FormController::class, 'resendEmail'])->name('form-submissions.resend-email');

    // Menu Builder
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
    Route::put('menus/{menu}/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
    Route::delete('menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');

    // Email Marketing
    Route::resource('campaigns', CampaignController::class);
    Route::post('campaigns/ai-generate', [CampaignController::class, 'generateAi'])->name('campaigns.ai-generate');
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::post('subscribers', [SubscriberController::class, 'store'])->name('subscribers.store');
    Route::delete('subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::post('subscriber-lists', [SubscriberController::class, 'storeList'])->name('subscriber-lists.store');

    // CRM
    Route::resource('leads', LeadController::class)->except(['create','store']);

    // Support
    Route::resource('tickets', AdminTicketController::class)->only(['index','show','update']);
    Route::post('tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');

    // Media Library
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');

    // Unified Settings (canonical: /admin/settings)
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/test-email', [SettingsController::class, 'sendTestEmail'])->name('settings.test-email');
    Route::get('settings/smtp-diagnostics', [SettingsController::class, 'smtpDiagnostics'])->name('settings.smtp-diagnostics');
    Route::post('settings/social', [SettingsController::class, 'storeSocial'])->name('settings.social.store');
    Route::delete('settings/social/{socialLink}', [SettingsController::class, 'destroySocial'])->name('settings.social.destroy');

    // Redirect old site-settings URL to unified settings
    Route::get('site-settings', fn() => redirect()->route('admin.settings.index'))->name('site-settings.index');
    Route::put('site-settings', fn() => redirect()->route('admin.settings.index'))->name('site-settings.update');
    Route::post('site-settings/social', fn() => redirect()->route('admin.settings.index'))->name('site-settings.social.store');
    Route::delete('site-settings/social/{socialLink}', fn() => redirect()->route('admin.settings.index'))->name('site-settings.social.destroy');

    // Popup Flyer Manager
    Route::get('popups', [\App\Http\Controllers\Admin\PopupController::class, 'index'])->name('popups.index');
    Route::post('popups', [\App\Http\Controllers\Admin\PopupController::class, 'store'])->name('popups.store');
    Route::put('popups/{popup}', [\App\Http\Controllers\Admin\PopupController::class, 'update'])->name('popups.update');
    Route::delete('popups/{popup}', [\App\Http\Controllers\Admin\PopupController::class, 'destroy'])->name('popups.destroy');
    Route::post('popups/{popup}/toggle', [\App\Http\Controllers\Admin\PopupController::class, 'toggle'])->name('popups.toggle');

    // Email Templates
    Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
    Route::get('email-templates/{emailTemplate}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
    Route::put('email-templates/{emailTemplate}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
    Route::patch('email-templates/{emailTemplate}/reset', [EmailTemplateController::class, 'reset'])->name('email-templates.reset');

    // Admin docs/guide
    Route::get('docs', [\App\Http\Controllers\Admin\DocsController::class, 'index'])->name('docs.index');
});

// Dynamic CMS pages (city landing pages etc.) — must be last
Route::get('/{slug}', [FrontendController::class, 'cmsPage'])->name('cms-page')->where('slug', '[a-z0-9\-]+');
