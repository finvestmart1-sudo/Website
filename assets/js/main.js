/* ============================================================
   FINVESTMART - MAIN JAVASCRIPT
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  /* ── Navbar scroll effect ── */
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
    });
  }

  /* ── Hamburger / Mobile Menu ── */
  const hamburger = document.querySelector('.hamburger');
  const mobileMenu = document.querySelector('.mobile-menu');
  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      mobileMenu.classList.toggle('open');
      const spans = hamburger.querySelectorAll('span');
      if (mobileMenu.classList.contains('open')) {
        spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
        spans[1].style.opacity = '0';
        spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
      } else {
        spans[0].style.transform = '';
        spans[1].style.opacity = '';
        spans[2].style.transform = '';
      }
    });
    document.addEventListener('click', (e) => {
      if (!hamburger.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.remove('open');
        const spans = hamburger.querySelectorAll('span');
        spans[0].style.transform = '';
        spans[1].style.opacity = '';
        spans[2].style.transform = '';
      }
    });
  }

  /* ── Sidebar toggle (Dashboard) ── */
  const sidebarToggle = document.querySelector('.sidebar-toggle');
  const sidebar = document.querySelector('.sidebar');
  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }

  /* ── Product Tabs ── */
  const tabs = document.querySelectorAll('.product-tab');
  const panels = document.querySelectorAll('.tab-panel');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      panels.forEach(p => p.classList.remove('active'));
      tab.classList.add('active');
      const target = document.getElementById(tab.dataset.tab);
      if (target) target.classList.add('active');
    });
  });

  /* ── Animate Numbers on Scroll ── */
  function animateNumber(el) {
    const target = parseFloat(el.dataset.target);
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
    const duration = 1500;
    const startTime = performance.now();
    const isDecimal = String(target).includes('.');

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = eased * target;
      el.textContent = prefix + (isDecimal ? current.toFixed(1) : Math.floor(current).toLocaleString('en-IN')) + suffix;
      if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
  }

  const animatedNumbers = document.querySelectorAll('[data-target]');
  if (animatedNumbers.length > 0) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
          entry.target.classList.add('animated');
          animateNumber(entry.target);
        }
      });
    }, { threshold: 0.5 });
    animatedNumbers.forEach(el => observer.observe(el));
  }

  /* ── Scroll Reveal Animation ── */
  const revealElements = document.querySelectorAll('.reveal');
  if (revealElements.length > 0) {
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    revealElements.forEach(el => revealObserver.observe(el));
  }

  /* ── Toast Notifications ── */
  window.showToast = function (message, type = 'info') {
    let container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }
    const icons = { success: 'fa-check-circle', error: 'fa-times-circle', info: 'fa-info-circle' };
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `<i class="fas ${icons[type] || icons.info} toast-icon"></i><span class="toast-text">${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; toast.style.transform = 'translateX(100%)'; setTimeout(() => toast.remove(), 300); }, 3500);
  };

  /* ── Form Validation ── */
  function validateForm(form) {
    let valid = true;
    form.querySelectorAll('[required]').forEach(input => {
      const group = input.closest('.form-group');
      if (!input.value.trim()) {
        valid = false;
        input.style.borderColor = '#EF4444';
        if (group && !group.querySelector('.form-error')) {
          const err = document.createElement('span');
          err.className = 'form-error';
          err.style.cssText = 'color:#EF4444;font-size:0.75rem;margin-top:4px;';
          err.textContent = 'This field is required';
          group.appendChild(err);
        }
      } else {
        input.style.borderColor = '';
        if (group) { const err = group.querySelector('.form-error'); if (err) err.remove(); }
      }

      if (input.type === 'email' && input.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input.value)) {
          valid = false;
          input.style.borderColor = '#EF4444';
        }
      }

      if (input.type === 'tel' && input.value) {
        const phoneRegex = /^[6-9]\d{9}$/;
        if (!phoneRegex.test(input.value.replace(/\s/g, ''))) {
          valid = false;
          input.style.borderColor = '#EF4444';
        }
      }
    });
    return valid;
  }

  /* ── Register Form ── */
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!validateForm(this)) return;
      const btn = this.querySelector('[type="submit"]');
      const originalText = btn.textContent;
      btn.innerHTML = '<span class="loading-spinner"></span> Creating Account...';
      btn.disabled = true;

      const data = new FormData(this);
      try {
        const res = await fetch('api/auth/register.php', { method: 'POST', body: data });
        const result = await res.json();
        if (result.success) {
          showToast('Account created successfully! Redirecting...', 'success');
          setTimeout(() => window.location.href = 'dashboard.html', 1500);
        } else {
          showToast(result.message || 'Registration failed. Try again.', 'error');
          btn.textContent = originalText;
          btn.disabled = false;
        }
      } catch {
        showToast('Connection error. Please try again.', 'error');
        btn.textContent = originalText;
        btn.disabled = false;
      }
    });
  }

  /* ── Login Form ── */
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!validateForm(this)) return;
      const btn = this.querySelector('[type="submit"]');
      const originalText = btn.textContent;
      btn.innerHTML = '<span class="loading-spinner"></span> Signing In...';
      btn.disabled = true;

      const data = new FormData(this);
      try {
        const res = await fetch('api/auth/login.php', { method: 'POST', body: data });
        const result = await res.json();
        if (result.success) {
          showToast('Login successful! Redirecting...', 'success');
          setTimeout(() => window.location.href = 'dashboard.html', 1000);
        } else {
          showToast(result.message || 'Invalid credentials.', 'error');
          btn.textContent = originalText;
          btn.disabled = false;
        }
      } catch {
        showToast('Connection error. Please try again.', 'error');
        btn.textContent = originalText;
        btn.disabled = false;
      }
    });
  }

  /* ── Apply Form ── */
  const applyForm = document.getElementById('applyForm');
  if (applyForm) {
    applyForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      if (!validateForm(this)) return;
      const btn = this.querySelector('[type="submit"]');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<span class="loading-spinner"></span> Submitting...';
      btn.disabled = true;

      const data = new FormData(this);
      try {
        const res = await fetch('api/applications/submit.php', { method: 'POST', body: data });
        const result = await res.json();
        if (result.success) {
          showToast('Application submitted! We will review and contact you.', 'success');
          setTimeout(() => window.location.href = 'dashboard.html', 2000);
        } else {
          showToast(result.message || 'Submission failed. Try again.', 'error');
          btn.innerHTML = originalText;
          btn.disabled = false;
        }
      } catch {
        showToast('Connection error. Please try again.', 'error');
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    });
  }

  /* ── Claim Reward ── */
  document.querySelectorAll('.claim-reward-btn').forEach(btn => {
    btn.addEventListener('click', async function () {
      const rewardId = this.dataset.rewardId;
      const originalText = this.textContent;
      this.innerHTML = '<span class="loading-spinner"></span>';
      this.disabled = true;

      try {
        const data = new FormData();
        data.append('reward_id', rewardId);
        const res = await fetch('api/rewards/claim.php', { method: 'POST', body: data });
        const result = await res.json();
        if (result.success) {
          showToast(`₹${result.amount} reward claimed successfully!`, 'success');
          this.textContent = 'Claimed ✓';
          this.style.background = '#E8FFF7';
          this.style.color = '#00a87e';
        } else {
          showToast(result.message || 'Claim failed.', 'error');
          this.textContent = originalText;
          this.disabled = false;
        }
      } catch {
        showToast('Connection error.', 'error');
        this.textContent = originalText;
        this.disabled = false;
      }
    });
  });

  /* ── Smooth scroll for anchor links ── */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href === '#') return;
      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        if (mobileMenu) mobileMenu.classList.remove('open');
      }
    });
  });

  /* ── Password Toggle ── */
  document.querySelectorAll('.password-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
      const input = this.previousElementSibling;
      if (input && input.type === 'password') {
        input.type = 'text';
        this.querySelector('i').className = 'fas fa-eye-slash';
      } else if (input) {
        input.type = 'password';
        this.querySelector('i').className = 'fas fa-eye';
      }
    });
  });

});


