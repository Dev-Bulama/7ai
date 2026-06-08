<x-app-layout title="Blog — 7AI" description="Insights on smart homes, AI and technology for Africa.">
<div class="page-hero">
  <div class="section-inner" style="max-width:1280px;margin:0 auto;">
    <div class="section-badge" style="display:inline-flex;">Blog</div>
    <h1 style="font-size:clamp(32px,4vw,52px);font-weight:700;color:var(--dark);letter-spacing:-0.025em;margin-bottom:16px;">Intelligence Insights</h1>
    <p style="font-size:18px;color:var(--gray-600);max-width:480px;line-height:1.7;">Perspectives on AI, smart homes, energy, and technology shaping Africa's future.</p>
  </div>
</div>

<section class="section">
  <div class="section-inner">

    <!-- FEATURED POST -->
    <div style="display:grid;grid-template-columns:1.2fr 1fr;gap:48px;align-items:center;margin-bottom:80px;background:var(--gray-50);border-radius:20px;overflow:hidden;border:1px solid var(--gray-200);">
      <div style="height:360px;background:linear-gradient(135deg,var(--teal-dark),var(--teal-light));display:flex;align-items:center;justify-content:center;">
        <div style="color:rgba(255,255,255,0.15);font-size:80px;font-weight:700;">7AI</div>
      </div>
      <div style="padding:48px 48px 48px 0;">
        <span class="blog-tag" style="margin-bottom:16px;display:inline-block;">Featured · AI</span>
        <h2 style="font-size:28px;font-weight:700;color:var(--dark);letter-spacing:-0.02em;margin-bottom:16px;line-height:1.3;">The Future of Smart Homes in Sub-Saharan Africa</h2>
        <p style="font-size:15px;color:var(--gray-600);line-height:1.7;margin-bottom:24px;">How AI-powered home automation is reshaping urban living across Nigeria, Ghana, and Kenya — and what it means for the next decade of African urbanisation.</p>
        <div class="blog-meta" style="margin-bottom:24px;"><span>June 1, 2025</span><span>·</span><span>5 min read</span><span>·</span><span>By Adaeze Obi</span></div>
        <a href="#" class="btn btn-primary">Read Article</a>
      </div>
    </div>

    <!-- FILTER TAGS -->
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:40px;">
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--teal);background:var(--teal);color:#fff;font-size:13px;font-weight:600;cursor:pointer;">All</button>
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Smart Home</button>
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">AI</button>
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Energy</button>
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Security</button>
      <button style="padding:6px 16px;border-radius:100px;border:1.5px solid var(--gray-200);background:transparent;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;">Business</button>
    </div>

        <!-- BLOG GRID -->
    <div class="grid-3">
      @forelse($posts as $post)
      <div class="blog-card">
        <div class="blog-image" style="background:linear-gradient(135deg,#0D1B2A,var(--teal));{{ $post->featured_image ? 'background-image:url('.$post->featured_image.');background-size:cover;' : '' }}"></div>
        <div class="blog-content">
          <span class="blog-tag">{{ $post->category->name ?? 'Article' }}</span>
          <h3>{{ $post->title }}</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 120) }}</p>
          <div class="blog-meta">
            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
            <span>·</span>
            <span>{{ $post->read_time }} min read</span>
          </div>
        </div>
      </div>
      @empty
      <div class="blog-card">
        <div class="blog-image" style="background:linear-gradient(135deg,#0D1B2A,var(--teal));"></div>
        <div class="blog-content">
          <span class="blog-tag">AI</span>
          <h3>Predictive Analytics: Africa's Competitive Edge</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">Why African businesses leveraging AI are outperforming traditional competitors by 3x in key metrics.</p>
          <div class="blog-meta"><span>May 24, 2025</span><span>·</span><span>7 min read</span></div>
        </div>
      </div>
      <div class="blog-card">
        <div class="blog-image" style="background:linear-gradient(135deg,#0D2818,#1a6b3a);"></div>
        <div class="blog-content">
          <span class="blog-tag">Energy</span>
          <h3>Solar + AI: The Intelligent Energy Revolution</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">How combining solar power with AI management creates maximum efficiency and resilience for African homes.</p>
          <div class="blog-meta"><span>May 18, 2025</span><span>·</span><span>6 min read</span></div>
        </div>
      </div>
      <div class="blog-card">
        <div class="blog-image" style="background:linear-gradient(135deg,#1B1B2F,#2D3561);"></div>
        <div class="blog-content">
          <span class="blog-tag">Security</span>
          <h3>AI Security: Beyond CCTV in African Homes</h3>
          <p style="font-size:14px;color:var(--gray-600);line-height:1.6;">How facial recognition, behavioural AI, and smart perimeter systems are transforming home security.</p>
          <div class="blog-meta"><span>May 12, 2025</span><span>·</span><span>5 min read</span></div>
        </div>
      </div>
      @endforelse
    </div>

    @if(isset($posts) && $posts->hasPages())
    <div style="text-align:center;margin-top:48px;">
      {{ $posts->links() }}
    </div>
    @else
    <div style="text-align:center;margin-top:48px;">
      <button class="btn btn-outline btn-lg">Load More Articles</button>
    </div>
    @endif
  </div>
</section>

<!-- NEWSLETTER -->
<section class="section section-gray">
  <div class="section-inner" style="max-width:560px;margin:0 auto;text-align:center;">
    <div class="section-badge" style="display:inline-flex;margin-bottom:16px;">Newsletter</div>
    <h2 style="font-size:28px;font-weight:700;color:var(--dark);letter-spacing:-0.02em;margin-bottom:12px;">Intelligence in Your Inbox</h2>
    <p style="font-size:16px;color:var(--gray-600);margin-bottom:32px;">Weekly insights on AI, smart homes, and technology in Africa. No spam. Unsubscribe anytime.</p>
    <form style="display:flex;gap:12px;" onsubmit="event.preventDefault();this.innerHTML='<p style=\'color:var(--teal);font-weight:600;\'>✓ You\'re subscribed!</p>'">
      <input type="email" class="form-input" placeholder="your@email.com" required style="flex:1;">
      <button type="submit" class="btn btn-primary">Subscribe</button>
    </form>
  </div>
</section>
</x-app-layout>
