/**
 * TechnicalBabaOffice - Main JavaScript
 */
(function() {
  'use strict';

  /* ========== Preloader ========== */
  window.addEventListener('load', function () {
    const preloader = document.getElementById('preloader');
    if (preloader) {
      setTimeout(() => preloader.classList.add('hidden'), 400);
    }
  });

  /* ========== Navbar Scroll ========== */
  const navbar = document.getElementById('mainNav');
  if (navbar) {
    window.addEventListener('scroll', function () {
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
  }

  /* ========== Back to Top ========== */
  const backToTop = document.getElementById('backToTop');
  if (backToTop) {
    window.addEventListener('scroll', function () {
      backToTop.classList.toggle('visible', window.scrollY > 300);
    });
    backToTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ========== Animate on Scroll ========== */
  function initScrollAnimations() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    if (!elements.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    elements.forEach(el => observer.observe(el));
  }
  initScrollAnimations();

  /* ========== Counter Animation ========== */
  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-count') || '0', 10);
    if (!target) return;
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;

    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        current = target;
        clearInterval(timer);
        // Add + suffix for large numbers
        if (target >= 100) {
          el.textContent = current >= 10000000 ? '1 Cr+' : (current >= 100000 ? (current/100000).toFixed(0) + 'L+' : Math.round(current) + '+');
        } else {
          el.textContent = Math.round(current) + (target > 10 ? '' : '');
        }
      } else {
        el.textContent = Math.round(current).toLocaleString('en-IN');
      }
    }, 16);
  }

  const statNumbers = document.querySelectorAll('.tb-stat-number[data-count]');
  if (statNumbers.length) {
    const statsObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          statsObs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    statNumbers.forEach(el => statsObs.observe(el));
  }

  /* ========== Video Modal ========== */
  const videoModal = document.getElementById('videoModal');
  if (videoModal) {
    const iframe = document.getElementById('videoIframe');
    // Open modal on play button click
    document.querySelectorAll('.tb-video-thumb[data-yt-id]').forEach(thumb => {
      thumb.addEventListener('click', function () {
        const ytId = this.getAttribute('data-yt-id');
        if (iframe) iframe.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0';
        const modal = new bootstrap.Modal(videoModal);
        modal.show();
      });
    });
    // Stop video when modal closes
    videoModal.addEventListener('hidden.bs.modal', function () {
      if (iframe) iframe.src = '';
    });
  }

  /* ========== Contact Form AJAX ========== */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn = this.querySelector('[type="submit"]');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Bhej raha hoon...';
      btn.disabled = true;

      const formData = new FormData(this);

      fetch('contact-handler.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        const alertDiv = document.getElementById('contactAlert');
        if (alertDiv) {
          alertDiv.className = 'tb-alert ' + (data.success ? 'tb-alert-success' : 'tb-alert-error');
          alertDiv.textContent = data.message;
          alertDiv.style.display = 'block';
          if (data.success) contactForm.reset();
          setTimeout(() => { alertDiv.style.display = 'none'; }, 6000);
        }
      })
      .catch(() => {
        alert('Kuch galat ho gaya. Please dobara try karo.');
      })
      .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
      });
    });
  }

  /* ========== Smooth section reveal ========== */
  document.querySelectorAll('[data-animate]').forEach((el, i) => {
    const delay = el.getAttribute('data-delay') || (i * 100);
    el.style.transitionDelay = delay + 'ms';
    el.classList.add('animate-on-scroll');
    // Re-trigger observer
    initScrollAnimations();
  });

})();
