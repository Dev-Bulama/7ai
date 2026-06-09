// ── Mobile Drawer ────────────────────────────────────────
(function () {
  var btn     = document.querySelector('.mobile-menu-btn');
  var menu    = document.getElementById('mobile-menu');
  var overlay = document.getElementById('mobile-overlay');
  var closeBtn= document.getElementById('mobile-menu-close');

  if (!btn || !menu) return;

  function open() {
    menu.classList.add('open');
    overlay.classList.add('open');
    btn.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }
  function close() {
    menu.classList.remove('open');
    overlay.classList.remove('open');
    btn.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  btn.addEventListener('click', function() { menu.classList.contains('open') ? close() : open(); });
  if (closeBtn) closeBtn.addEventListener('click', close);
  if (overlay)  overlay.addEventListener('click', close);
  document.addEventListener('keydown', function(e) { if (e.key === 'Escape') close(); });

  // Close on link click (not accordion button)
  menu.querySelectorAll('a').forEach(function(a) { a.addEventListener('click', close); });

  // Solutions accordion inside drawer
  var accBtn   = document.getElementById('solutions-acc-btn');
  var accPanel = document.getElementById('solutions-acc-panel');
  if (accBtn && accPanel) {
    accBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      var isOpen = accPanel.classList.contains('open');
      accPanel.classList.toggle('open', !isOpen);
      accBtn.classList.toggle('open', !isOpen);
      accBtn.setAttribute('aria-expanded', String(!isOpen));
    });
  }
})();

// Accordion
document.querySelectorAll('.accordion-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const item = btn.closest('.accordion-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.accordion-item').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
  });
});

// Smooth scroll offset for fixed nav
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href');
    if (id === '#') return;
    const el = document.querySelector(id);
    if (el) {
      e.preventDefault();
      const top = el.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

// Hero Canvas — AI Network Animation
const canvas = document.getElementById('hero-canvas');
if (canvas) {
  const ctx = canvas.getContext('2d');
  let nodes = [], W, H, animId;

  function resize() {
    W = canvas.width = canvas.offsetWidth;
    H = canvas.height = canvas.offsetHeight;
  }

  function init() {
    nodes = [];
    for (let i = 0; i < 60; i++) {
      nodes.push({
        x: Math.random() * W,
        y: Math.random() * H,
        vx: (Math.random() - 0.5) * 0.4,
        vy: (Math.random() - 0.5) * 0.4,
        r: Math.random() * 2 + 1,
      });
    }
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    // Draw connections
    for (let i = 0; i < nodes.length; i++) {
      for (let j = i + 1; j < nodes.length; j++) {
        const dx = nodes[i].x - nodes[j].x;
        const dy = nodes[i].y - nodes[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 140) {
          ctx.beginPath();
          ctx.strokeStyle = `rgba(255,255,255,${0.15 * (1 - dist / 140)})`;
          ctx.lineWidth = 0.8;
          ctx.moveTo(nodes[i].x, nodes[i].y);
          ctx.lineTo(nodes[j].x, nodes[j].y);
          ctx.stroke();
        }
      }
    }
    // Draw nodes
    nodes.forEach(n => {
      ctx.beginPath();
      ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2);
      ctx.fillStyle = 'rgba(255,255,255,0.6)';
      ctx.fill();
      n.x += n.vx;
      n.y += n.vy;
      if (n.x < 0 || n.x > W) n.vx *= -1;
      if (n.y < 0 || n.y > H) n.vy *= -1;
    });
    animId = requestAnimationFrame(draw);
  }

  window.addEventListener('resize', () => { resize(); init(); });
  resize();
  init();
  draw();
}

// Counter animation
function animateCounter(el) {
  const target = parseInt(el.dataset.target);
  const suffix = el.dataset.suffix || '';
  const duration = 1500;
  const step = target / (duration / 16);
  let current = 0;
  const timer = setInterval(() => {
    current = Math.min(current + step, target);
    el.textContent = Math.floor(current).toLocaleString() + suffix;
    if (current >= target) clearInterval(timer);
  }, 16);
}

const counters = document.querySelectorAll('[data-target]');
if (counters.length) {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        animateCounter(e.target);
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => observer.observe(c));
}
