<x-admin-layout title="Admin Guide">
<style>
  .doc-section { margin-bottom: 40px; }
  .doc-section h2 { font-size: 18px; font-weight: 700; color: #0d1b2a; margin-bottom: 8px; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb; }
  .doc-section h3 { font-size: 14px; font-weight: 600; color: #0B4F6C; margin: 20px 0 8px; }
  .doc-section p, .doc-section li { font-size: 14px; color: #374151; line-height: 1.7; }
  .doc-section ul, .doc-section ol { margin: 8px 0 16px 20px; }
  .doc-section li { margin-bottom: 5px; }
  .tip { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #166534; margin: 10px 0; }
  .warn { background: #fefce8; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #92400e; margin: 10px 0; }
  .code { background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 5px; padding: 2px 7px; font-family: monospace; font-size: 12px; color: #0B4F6C; }
  .card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 20px; }
  .toc { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 22px; margin-bottom: 32px; }
  .toc h3 { font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px; }
  .toc a { display: block; font-size: 13px; color: #0B4F6C; text-decoration: none; padding: 3px 0; }
  .toc a:hover { text-decoration: underline; }
  pre { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; font-size: 12px; overflow-x: auto; margin: 10px 0; line-height: 1.6; }
</style>

<div style="max-width:800px;">

<div class="toc">
  <h3>Contents</h3>
  <a href="#pages">1. Pages &amp; City Landing Pages</a>
  <a href="#nav">2. Navigation CTA Button</a>
  <a href="#blog">3. Blog Posts</a>
  <a href="#leads">4. Leads &amp; Contact Enquiries</a>
  <a href="#investors">5. Investor Registrations</a>
  <a href="#campaigns">6. Email Campaigns</a>
  <a href="#settings">7. Site Settings</a>
  <a href="#tips">8. Tips &amp; Best Practices</a>
</div>

<!-- PAGES -->
<div class="doc-section card" id="pages">
  <h2>1. Pages &amp; City Landing Pages</h2>
  <p>The Pages section lets you create custom content pages — including city-specific landing pages like <span class="code">/abuja</span>, <span class="code">/lagos</span>, <span class="code">/nairobi</span> — without touching any code.</p>

  <h3>Creating a city landing page</h3>
  <ol>
    <li>Go to <strong>Admin → Pages → New Page</strong></li>
    <li>Enter a <strong>Title</strong> (e.g. <em>Abuja</em>). The slug auto-fills as <span class="code">abuja</span> — this becomes the URL: <span class="code">7ai.africa/abuja</span></li>
    <li>In <strong>Meta Description</strong>, write a short subtitle shown under the title in the page hero (e.g. "Smart home automation services in Abuja, FCT")</li>
    <li>In <strong>Content</strong>, write your page body. HTML is supported:
<pre>&lt;h2&gt;Smart Homes in Abuja&lt;/h2&gt;
&lt;p&gt;7AI provides premium smart home automation across Abuja, FCT.
Whether you're in Maitama, Asokoro, or Wuse, we can transform
your home into an intelligent living space.&lt;/p&gt;

&lt;h3&gt;Our Abuja Services&lt;/h3&gt;
&lt;ul&gt;
  &lt;li&gt;Smart lighting and energy management&lt;/li&gt;
  &lt;li&gt;AI security systems with local support&lt;/li&gt;
  &lt;li&gt;Voice-controlled home automation&lt;/li&gt;
&lt;/ul&gt;

&lt;h3&gt;Why Choose 7AI in Abuja?&lt;/h3&gt;
&lt;p&gt;Our dedicated Abuja team provides same-day consultation,
installation within 7 days, and 24/7 local support.&lt;/p&gt;</pre>
    </li>
    <li>Set <strong>Template</strong> to <em>Landing Page</em> and <strong>Status</strong> to <em>Published</em></li>
    <li>Click <strong>Create</strong> — the page is immediately live at <span class="code">7ai.africa/abuja</span></li>
  </ol>

  <div class="tip">💡 Use the Meta Description field to set the hero subtitle shown on the page banner.</div>
  <div class="warn">⚠️ Avoid slugs that conflict with existing routes: <span class="code">contact</span>, <span class="code">about</span>, <span class="code">blog</span>, <span class="code">pricing</span>, <span class="code">login</span>, <span class="code">admin</span>, <span class="code">dashboard</span>, <span class="code">investors</span>.</div>

  <h3>Editing an existing page</h3>
  <ol>
    <li>Go to <strong>Admin → Pages</strong></li>
    <li>Click <strong>Edit</strong> next to the page you want to change</li>
    <li>Update the content and click <strong>Save</strong></li>
  </ol>

  <h3>Taking a page offline</h3>
  <p>Set the Status from <em>Published</em> to <em>Draft</em>. The URL returns a 404 until you republish.</p>
</div>

<!-- NAV CTA -->
<div class="doc-section card" id="nav">
  <h2>2. Navigation CTA Button</h2>
  <p>The button on the top-right of every page (e.g. "Book Consultation", "Register Free") is controlled from Settings — no code changes needed.</p>

  <h3>Changing the button text and link</h3>
  <ol>
    <li>Go to <strong>Admin → Settings</strong></li>
    <li>Scroll to the <strong>Navigation CTA</strong> section</li>
    <li>Update <strong>Primary Button Text</strong> (e.g. <em>Register Free</em>)</li>
    <li>Update <strong>Primary Button URL</strong> (e.g. <span class="code">/investors</span> or <span class="code">/register</span> or a full URL)</li>
    <li>Optionally update the secondary ghost button (e.g. "Support" linking to <span class="code">/support</span>)</li>
    <li>Click <strong>Save Settings</strong> — takes effect immediately on all pages</li>
  </ol>

  <div class="tip">💡 The URL can be a relative path (<span class="code">/contact</span>) or a full URL (<span class="code">https://wa.me/234...</span>).</div>
</div>

<!-- BLOG -->
<div class="doc-section card" id="blog">
  <h2>3. Blog Posts</h2>
  <p>Blog posts appear at <span class="code">/blog</span> and are managed under <strong>Admin → Blog Posts</strong>.</p>

  <h3>Creating a post</h3>
  <ol>
    <li>Go to <strong>Admin → Blog Posts → New Post</strong></li>
    <li>Write a Title, select a Category, add your Content</li>
    <li>Set Status to <em>Published</em> and set a <strong>Published At</strong> date/time</li>
    <li>Fill in Meta Title and Description for SEO</li>
    <li>Click <strong>Create</strong></li>
  </ol>

  <h3>Statuses</h3>
  <ul>
    <li><strong>Draft</strong> — only visible to admins, hidden from public blog</li>
    <li><strong>Published</strong> — live on the blog from the Published At date</li>
    <li><strong>Scheduled</strong> — will go live at the specified future date</li>
  </ul>
</div>

<!-- LEADS -->
<div class="doc-section card" id="leads">
  <h2>4. Leads &amp; Contact Enquiries</h2>
  <p>Every contact form submission creates a Lead in <strong>Admin → Leads / CRM</strong>.</p>
  <ul>
    <li>View full details, update the status (New → Contacted → Qualified → Won / Lost)</li>
    <li>Add internal notes visible only to your team</li>
    <li>Leads are sorted newest-first; use search to find by name or email</li>
  </ul>
  <div class="tip">💡 Check leads daily — these are prospective clients who reached out directly.</div>
</div>

<!-- INVESTORS -->
<div class="doc-section card" id="investors">
  <h2>5. Investor Registrations</h2>
  <p>When someone submits the form at <span class="code">/investors</span>, a Lead is created with <strong>Service Interest = investor</strong>. The investor type and investment range are stored in the notes/message field.</p>
  <p>To view investor leads:</p>
  <ol>
    <li>Go to <strong>Admin → Leads / CRM</strong></li>
    <li>Look for leads with Service Interest = <em>investor</em></li>
    <li>The message field shows: Investor Type, Investment Range, and any message they wrote</li>
  </ol>
</div>

<!-- CAMPAIGNS -->
<div class="doc-section card" id="campaigns">
  <h2>6. Email Campaigns</h2>

  <h3>Creating a campaign</h3>
  <ol>
    <li>Go to <strong>Admin → Campaigns → New Campaign</strong></li>
    <li>Write a Subject and HTML body</li>
    <li>Select a Subscriber List to send to</li>
    <li>Use <strong>AI Generate</strong> to draft the email body automatically</li>
    <li>Save as Draft, review, then send</li>
  </ol>

  <h3>Managing subscribers</h3>
  <p>Go to <strong>Admin → Subscribers</strong> to view, add, or remove email subscribers and manage lists.</p>
</div>

<!-- SETTINGS -->
<div class="doc-section card" id="settings">
  <h2>7. Site Settings</h2>
  <p>Found under <strong>Admin → Settings</strong>. Controls global site values:</p>
  <ul>
    <li><strong>Site Name / Tagline</strong> — used in browser titles and emails</li>
    <li><strong>Contact Email / Phone</strong> — displayed in footer and contact sections</li>
    <li><strong>SEO Meta Title / Description</strong> — default values for pages without their own SEO fields</li>
    <li><strong>Email From Name / Address</strong> — the "From" field in all system emails</li>
    <li><strong>Navigation CTA</strong> — the top-right button text and link on all pages (see section 2)</li>
  </ul>
</div>

<!-- TIPS -->
<div class="doc-section card" id="tips">
  <h2>8. Tips &amp; Best Practices</h2>

  <h3>HTML content quick reference</h3>
  <ul>
    <li>Heading: <span class="code">&lt;h2&gt;Your Heading&lt;/h2&gt;</span></li>
    <li>Sub-heading: <span class="code">&lt;h3&gt;Sub Heading&lt;/h3&gt;</span></li>
    <li>Paragraph: <span class="code">&lt;p&gt;Your text here.&lt;/p&gt;</span></li>
    <li>Bold: <span class="code">&lt;strong&gt;bold text&lt;/strong&gt;</span></li>
    <li>Bullet list: <span class="code">&lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt;</span></li>
    <li>Link: <span class="code">&lt;a href="/contact"&gt;Contact Us&lt;/a&gt;</span></li>
  </ul>

  <h3>Recommended city page structure</h3>
  <ol>
    <li>Opening paragraph about the city/region and why 7AI is there</li>
    <li>Services available in that city</li>
    <li>Local team / response time / coverage areas</li>
    <li>Brief call-to-action paragraph with a link to <span class="code">/contact</span></li>
  </ol>

  <h3>SEO tips</h3>
  <ul>
    <li>Always fill Meta Title and Description for city pages you want to rank in Google</li>
    <li>Include the city name naturally in the title and first paragraph</li>
    <li>Keep Meta Descriptions under 155 characters</li>
    <li>Use <span class="code">h2</span> headings in the content body (not <span class="code">h1</span> — the page title is already h1)</li>
  </ul>
</div>

</div>
</x-admin-layout>
