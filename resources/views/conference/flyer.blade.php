<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I Am Attending &ndash; {{ $settings->event_name ?? 'Abuja AI Conference' }}</title>
    <meta property="og:title" content="I Am Attending &ndash; {{ $settings->event_name ?? 'Abuja AI Conference' }}">
    <meta property="og:description" content="Generate your personalised attending flyer">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#0d1b2a;color:#fff;min-height:100vh}
        .page-header{text-align:center;padding:24px 16px 0}
        .page-header h1{font-size:1.4rem;font-weight:700;letter-spacing:.04em;color:#fff}
        .page-header p{color:#aab4c4;font-size:.9rem;margin-top:4px}
        .container{max-width:620px;margin:0 auto;padding:16px}
        .form-section{background:#162032;border-radius:16px;padding:24px;margin-top:20px}
        .form-group{margin-bottom:16px}
        label{display:block;font-size:.82rem;color:#aab4c4;margin-bottom:6px;font-weight:500;letter-spacing:.03em}
        input[type=text]{width:100%;background:#0d1b2a;border:1.5px solid #253548;border-radius:8px;color:#fff;padding:10px 14px;font-size:.95rem;outline:none;transition:border .2s}
        input[type=text]:focus{border-color:#00C896}
        .photo-upload-area{border:2px dashed #253548;border-radius:12px;padding:20px;text-align:center;cursor:pointer;transition:border .2s;position:relative}
        .photo-upload-area:hover{border-color:#00C896}
        .photo-upload-area input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
        .photo-preview{width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #00C896;margin:0 auto 8px;display:block}
        .upload-icon{font-size:2rem;margin-bottom:8px}
        .upload-text{color:#aab4c4;font-size:.85rem}
        .btn-generate{width:100%;background:linear-gradient(135deg,#00C896,#00a07a);color:#fff;border:none;border-radius:10px;padding:14px;font-size:1rem;font-weight:700;cursor:pointer;margin-top:8px;transition:opacity .2s;letter-spacing:.05em}
        .btn-generate:hover{opacity:.88}
        .btn-generate:disabled{opacity:.5;cursor:wait}
        .preview-section{display:none;margin-top:24px}
        .preview-label{font-size:.8rem;color:#aab4c4;text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px;text-align:center}
        #flyer-preview-wrap{display:flex;justify-content:center;overflow:hidden}
        #flyer-preview-scaler{transform-origin:top center;display:inline-block}
        #flyer-preview{width:540px;overflow:hidden;border-radius:8px;box-shadow:0 8px 40px rgba(0,0,0,.6)}
        #flyer-render-target{position:fixed;left:-9999px;top:0;width:540px;pointer-events:none;z-index:-1}
        .result-section{display:none;margin-top:24px;text-align:center}
        #flyer-result{max-width:100%;border-radius:8px;box-shadow:0 8px 40px rgba(0,0,0,.6)}
        .share-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px}
        .share-grid .btn-full{grid-column:span 2}
        .btn-share{display:flex;align-items:center;justify-content:center;gap:8px;border:none;border-radius:8px;padding:11px 14px;font-size:.88rem;font-weight:600;cursor:pointer;text-decoration:none;transition:opacity .2s}
        .btn-share:hover{opacity:.85}
        .btn-download{background:#00C896;color:#fff}
        .btn-wa{background:#25D366;color:#fff}
        .btn-tw{background:#000;color:#fff}
        .btn-fb{background:#1877F2;color:#fff}
        .btn-li{background:#0A66C2;color:#fff}
        .btn-copy{background:#253548;color:#fff}
        .toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#00C896;color:#fff;padding:10px 22px;border-radius:20px;font-size:.88rem;font-weight:600;opacity:0;transition:opacity .3s;pointer-events:none;z-index:999}
        .toast.show{opacity:1}
        @media(max-width:560px){
            #flyer-preview{width:100%}
            .share-grid{grid-template-columns:1fr}
            .share-grid .btn-full{grid-column:span 1}
        }
    </style>
</head>
<body>
<div class="page-header">
    @if(!empty($settings->badge_logo_path))
        <img src="{{ asset('storage/'.$settings->badge_logo_path) }}" style="height:44px;object-fit:contain;margin-bottom:10px;" alt="Logo">
    @endif
    <h1>Generate Your Attending Flyer</h1>
    <p>{{ $settings->event_name ?? 'Abuja AI Conference' }} &mdash; {{ $settings->event_date ? \Carbon\Carbon::parse($settings->event_date)->format('jS F Y') : '7th July 2026' }}</p>
</div>

<div class="container">
    <div class="form-section">
        <div class="form-group">
            <label for="inp-name">Your Full Name *</label>
            <input type="text" id="inp-name" placeholder="e.g. Amara Okonkwo" maxlength="60" autocomplete="name">
        </div>
        <div class="form-group">
            <label for="inp-role">Title / Role (optional)</label>
            <input type="text" id="inp-role" placeholder="e.g. AI Engineer, Founder, Student" maxlength="60">
        </div>
        <div class="form-group">
            <label>Your Photo (optional)</label>
            <div class="photo-upload-area" id="photo-area">
                <input type="file" id="inp-photo" accept="image/*">
                <img id="photo-thumb" class="photo-preview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Ccircle cx='40' cy='40' r='40' fill='%23253548'/%3E%3Ccircle cx='40' cy='30' r='14' fill='%23aab4c4'/%3E%3Cellipse cx='40' cy='70' rx='24' ry='18' fill='%23aab4c4'/%3E%3C/svg%3E" alt="Preview" style="display:block">
                <div class="upload-text">Tap to upload a photo&nbsp;(JPEG / PNG)</div>
            </div>
        </div>
        <button class="btn-generate" id="btn-preview" style="background:linear-gradient(135deg,#253548,#1a2535);">&#128065; Preview Your Design</button>
        <button class="btn-generate" id="btn-gen" style="margin-top:10px;">&#10022; Generate &amp; Download Flyer</button>
    </div>

    <div class="preview-section" id="preview-section">
        <div class="preview-label">Your Flyer Preview</div>
        <div id="flyer-preview-wrap">
            <div id="flyer-preview-scaler">
                <div id="flyer-preview"></div>
            </div>
        </div>
    </div>

    {{-- Hidden full-size render target for html2canvas --}}
    <div id="flyer-render-target"></div>

    <div class="result-section" id="result-section">
        <div class="preview-label">Your Flyer is Ready!</div>
        <img id="flyer-result" alt="Your flyer">
        <div class="share-grid" id="share-btns">
            <button class="btn-share btn-download btn-full" id="btn-download">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 16l-5-5h3V4h4v7h3l-5 5zm-7 4v-2h14v2H5z"/></svg>
                Download PNG
            </button>
            <button class="btn-share btn-wa btn-full" id="btn-wa">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Share to WhatsApp
            </button>
            <a class="btn-share btn-tw" id="btn-tw" href="#" target="_blank" rel="noopener">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                Twitter / X
            </a>
            <a class="btn-share btn-fb" id="btn-fb" href="#" target="_blank" rel="noopener">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </a>
            <a class="btn-share btn-li" id="btn-li" href="#" target="_blank" rel="noopener">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                LinkedIn
            </a>
            <button class="btn-share btn-copy" id="btn-copy">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 1H4a2 2 0 00-2 2v14h2V3h12V1zm3 4H8a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h11v14z"/></svg>
                Copy Link
            </button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
(function(){
    var TEMPLATE = {!! json_encode($template) !!};
    var PAGE_URL = window.location.href;
    var currentPhotoDataUrl = '';
    var generatedBlob = null;
    var generatedDataUrl = '';

    function escHtml(s){
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function buildHtml(){
        var name = document.getElementById('inp-name').value.trim() || 'Your Name';
        var role = document.getElementById('inp-role').value.trim() || '';
        // Photo: use background-image CSS value so object-fit is respected by html2canvas
        var photoCss = currentPhotoDataUrl ? 'url("' + currentPhotoDataUrl + '")' : 'none';
        return TEMPLATE
            .replace(/\{\{NAME\}\}/g, escHtml(name))
            .replace(/\{\{ROLE\}\}/g, escHtml(role))
            .replace(/\{\{PHOTO\}\}/g, photoCss);
    }

    function renderPreview(){
        document.getElementById('flyer-preview').innerHTML = buildHtml();
    }

    function scalePreview(){
        var wrap = document.getElementById('flyer-preview-wrap');
        var scaler = document.getElementById('flyer-preview-scaler');
        var available = wrap.clientWidth;
        var scale = available >= 540 ? 1 : available / 540;
        scaler.style.transform = 'scale(' + scale + ')';
        scaler.style.width = '540px';
        wrap.style.height = Math.round(675 * scale) + 'px';
    }
    window.addEventListener('resize', scalePreview);

    // Preview button
    document.getElementById('btn-preview').addEventListener('click', function(){
        renderPreview();
        var ps = document.getElementById('preview-section');
        ps.style.display = 'block';
        scalePreview();
        this.textContent = '↺ Update Preview';
        ps.scrollIntoView({behavior:'smooth', block:'start'});
    });

    // Auto-update preview if already open
    function liveUpdate(){
        var ps = document.getElementById('preview-section');
        if(ps.style.display !== 'none') renderPreview();
    }
    document.getElementById('inp-name').addEventListener('input', liveUpdate);
    document.getElementById('inp-role').addEventListener('input', liveUpdate);

    document.getElementById('inp-photo').addEventListener('change', function(e){
        var file = e.target.files[0];
        if(!file) return;
        var reader = new FileReader();
        reader.onload = function(ev){
            currentPhotoDataUrl = ev.target.result;
            document.getElementById('photo-thumb').src = currentPhotoDataUrl;
            liveUpdate();
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('btn-gen').addEventListener('click', function(){
        var btn = this;
        btn.disabled = true;
        btn.textContent = 'Generating…';

        // Populate the hidden full-size render target (no transform applied)
        var renderTarget = document.getElementById('flyer-render-target');
        renderTarget.innerHTML = buildHtml();
        var captureEl = renderTarget.firstElementChild || renderTarget;

        html2canvas(captureEl, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            logging: false,
            backgroundColor: null,
            width: 540,
            height: 675
        }).then(function(canvas){
            generatedDataUrl = canvas.toDataURL('image/png');
            document.getElementById('flyer-result').src = generatedDataUrl;
            canvas.toBlob(function(blob){ generatedBlob = blob; }, 'image/png');
            document.getElementById('result-section').style.display = 'block';
            var name = document.getElementById('inp-name').value.trim() || 'I';
            var hashtag = '{{ addslashes($settings->flyer_hashtag ?? "#7AIAbuja2026") }}';
            var eventName = '{{ addslashes($settings->event_name ?? "Abuja AI Conference") }}';
            var msg = encodeURIComponent(name + ' is attending ' + eventName + '! ' + hashtag + ' ' + PAGE_URL);
            document.getElementById('btn-tw').href = 'https://twitter.com/intent/tweet?text=' + msg;
            document.getElementById('btn-fb').href = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(PAGE_URL);
            document.getElementById('btn-li').href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(PAGE_URL);
            document.getElementById('result-section').scrollIntoView({behavior:'smooth', block:'start'});
            btn.disabled = false;
            btn.textContent = '✦ Generate & Download Flyer';
        }).catch(function(err){
            btn.disabled = false;
            btn.textContent = '✦ Generate & Download Flyer';
            showToast('Generation failed. Please try again.');
            console.error(err);
        });
    });

    document.getElementById('btn-download').addEventListener('click', function(){
        if(!generatedDataUrl) return;
        var a = document.createElement('a');
        var name = (document.getElementById('inp-name').value.trim() || 'flyer').replace(/\s+/g,'-');
        a.download = name + '-attending-flyer.png';
        a.href = generatedDataUrl;
        a.click();
    });

    document.getElementById('btn-wa').addEventListener('click', function(){
        if(!generatedBlob) { showToast('Generate your flyer first.'); return; }
        var name = (document.getElementById('inp-name').value.trim() || 'flyer').replace(/\s+/g,'-');
        var file = new File([generatedBlob], name+'-attending-flyer.png', {type:'image/png'});
        var canShareFile = navigator.canShare && navigator.canShare({files:[file]});
        if(navigator.share && canShareFile){
            navigator.share({
                files: [file],
                title: 'I Am Attending – {{ addslashes($settings->event_name ?? "Abuja AI Conference") }}',
                text: '{{ addslashes($settings->flyer_hashtag ?? "#7AIAbuja2026") }}'
            }).catch(function(err){ if(err.name !== 'AbortError') showToast('Share cancelled.'); });
        } else {
            // Fallback: open WhatsApp with text (image can't be forced via URL)
            var n = document.getElementById('inp-name').value.trim() || 'I';
            var msg = encodeURIComponent(n + ' is attending {{ addslashes($settings->event_name ?? "Abuja AI Conference") }}! {{ addslashes($settings->flyer_hashtag ?? "#7AIAbuja2026") }} ' + PAGE_URL);
            window.open('https://wa.me/?text=' + msg, '_blank');
        }
    });

    document.getElementById('btn-copy').addEventListener('click', function(){
        navigator.clipboard.writeText(PAGE_URL).then(function(){
            showToast('Link copied!');
        }).catch(function(){
            showToast('Could not copy link.');
        });
    });

    function showToast(msg){
        var t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(function(){ t.classList.remove('show'); }, 2500);
    }
})();
</script>
</body>
</html>
