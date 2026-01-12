/**
 * animasi.js - JavaScript sederhana untuk animasi smooth
 * File tunggal untuk semua halaman SPBU Pertamina
 */

// Tunggu hingga DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    
    // ANIMASI UNTUK SEMUA HALAMAN
    initSmoothAnimations();
    
    // FUNGSI KHUSUS UNTUK HALAMAN UTAMA
    if (document.querySelector('.stock-card')) {
        initStockAnimations();
    }
    
    // FUNGSI KHUSUS UNTUK FORM KELUHAN
    if (document.getElementById('complaintForm')) {
        initComplaintFormAnimations();
    }
    
    // FUNGSI KHUSUS UNTUK DASHBOARD
    if (document.querySelector('.dashboard-stats')) {
        initDashboardAnimations();
    }
    
    // NOTIFIKASI SEDERHANA
    initSimpleNotifications();
    
    // UPDATE WAKTU REAL-TIME
    initRealTimeClock();
});

// ANIMASI SMOOTH UNTUK SEMUA HALAMAN
// ============================================
function initSmoothAnimations() {
    console.log('Animasi SPBU diaktifkan');
    
    // A. Animasi untuk semua card
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        // Delay animasi untuk efek berurutan
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100 * index);
        
        // Efek hover sederhana
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
            this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
    
    // B. Animasi untuk semua button
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
        
        // Efek klik
        button.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.95)';
        });
        
        button.addEventListener('mouseup', function() {
            this.style.transform = 'scale(1.05)';
        });
    });
    
    // C. Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // D. Animasi untuk navbar
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > lastScroll && currentScroll > 100) {
                // Scroll down
                navbar.style.transform = 'translateY(-100%)';
                navbar.style.transition = 'transform 0.3s ease';
            } else {
                // Scroll up
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });
    }
}

// ANIMASI KHUSUS HALAMAN UTAMA (STOK BENSIN)
// ============================================
function initStockAnimations() {
    console.log('Animasi stok diaktifkan');
    
    // A. Animasi angka counter untuk stok
    const stockValues = document.querySelectorAll('.stock-value');
    stockValues.forEach(valueElement => {
        const targetValue = parseInt(valueElement.textContent.replace(/\./g, '')) || 0;
        animateCounter(valueElement, targetValue, 2000);
    });
    
    // B. Animasi progress bar
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width || '0%';
        bar.style.width = '0%';
        
        setTimeout(() => {
            bar.style.transition = 'width 1.5s ease-in-out';
            bar.style.width = width;
        }, 500);
    });
    
    // C. Auto-refresh stok sederhana (setiap 60 detik)
    setInterval(() => {
        simulateStockUpdate();
    }, 60000);
    
    // D. Tombol refresh manual
    const refreshBtn = document.createElement('button');
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
    refreshBtn.className = 'btn btn-sm btn-outline-danger position-fixed';
    refreshBtn.style.cssText = `
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 18px;
    `;
    refreshBtn.title = 'Refresh Stok';
    
    refreshBtn.addEventListener('click', function() {
        this.classList.add('rotating');
        simulateStockUpdate();
        
        setTimeout(() => {
            this.classList.remove('rotating');
        }, 1000);
    });
    
    document.body.appendChild(refreshBtn);
}

function animateCounter(element, target, duration) {
    let start = 0;
    const increment = target / (duration / 16); // 60fps
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target.toLocaleString('id-ID');
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start).toLocaleString('id-ID');
        }
    }, 16);
}

function simulateStockUpdate() {
    // Tampilkan efek loading
    const stockCards = document.querySelectorAll('.stock-card');
    stockCards.forEach(card => {
        card.classList.add('updating');
        
        // Update angka sedikit (simulasi)
        const valueElement = card.querySelector('.stock-value');
        if (valueElement) {
            const current = parseInt(valueElement.textContent.replace(/\./g, '')) || 0;
            const change = Math.floor(Math.random() * 100) - 50; // -50 sampai +50
            const newValue = Math.max(0, current + change);
            
            animateCounter(valueElement, newValue, 1000);
        }
        
        // Update progress bar
        const progressBar = card.querySelector('.progress-bar');
        if (progressBar) {
            const currentWidth = parseInt(progressBar.style.width) || 0;
            const newWidth = Math.max(10, Math.min(100, currentWidth + (Math.random() * 20 - 10)));
            
            progressBar.style.transition = 'width 1s ease';
            progressBar.style.width = newWidth + '%';
            
            // Update warna berdasarkan persentase
            if (newWidth < 20) {
                progressBar.className = 'progress-bar bg-danger';
            } else if (newWidth < 50) {
                progressBar.className = 'progress-bar bg-warning';
            } else {
                progressBar.className = 'progress-bar bg-success';
            }
        }
        
        // Hapus class updating setelah 1 detik
        setTimeout(() => {
            card.classList.remove('updating');
        }, 1000);
    });
    
    // Tampilkan notifikasi
    showSimpleNotification('Stok telah diperbarui', 'success');
}


// ANIMASI FORM KELUHAN
// ============================================
function initComplaintFormAnimations() {
    console.log('Animasi form keluhan diaktifkan');
    
    const form = document.getElementById('complaintForm');
    if (!form) return;
    
    // A. Validasi real-time
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        // Efek focus
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            validateField(this);
        });
        
        // Efek input
        input.addEventListener('input', function() {
            this.parentElement.classList.add('typing');
            setTimeout(() => {
                this.parentElement.classList.remove('typing');
            }, 300);
        });
    });
    
    // B. Character counter untuk textarea
    const textarea = document.getElementById('deskripsi');
    if (textarea) {
        const counter = document.createElement('small');
        counter.className = 'form-text text-end d-block';
        counter.textContent = '0/500 karakter';
        textarea.parentNode.appendChild(counter);
        
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/500 karakter`;
            
            // Warna berdasarkan panjang
            if (length > 450) {
                counter.style.color = '#ffc107';
            } else if (length > 490) {
                counter.style.color = '#dc3545';
            } else {
                counter.style.color = '#6c757d';
            }
            
            // Auto-expand
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
    
    // C. Animasi submit button
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        form.addEventListener('submit', function(e) {
            // Validasi sederhana
            const nama = document.getElementById('nama')?.value.trim();
            const deskripsi = document.getElementById('deskripsi')?.value.trim();
            
            if (!nama || nama.length < 3) {
                e.preventDefault();
                showFieldError('nama', 'Nama minimal 3 karakter');
                return;
            }
            
            if (!deskripsi || deskripsi.length < 10) {
                e.preventDefault();
                showFieldError('deskripsi', 'Deskripsi minimal 10 karakter');
                return;
            }
            
            // Animasi loading
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
            submitBtn.disabled = true;
            
            // Simulasi pengiriman
            setTimeout(() => {
                showSimpleNotification('Keluhan berhasil dikirim!', 'success');
            }, 1500);
        });
    }
}

function validateField(field) {
    const value = field.value.trim();
    
    if (field.required && !value) {
        showFieldError(field, 'Field ini wajib diisi');
        return false;
    }
    
    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'Format email tidak valid');
        return false;
    }
    
    clearFieldError(field);
    return true;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    field.classList.add('is-invalid');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    
    field.parentNode.appendChild(errorDiv);
    
    // Animasi shake
    field.parentElement.classList.add('shake');
    setTimeout(() => {
        field.parentElement.classList.remove('shake');
    }, 500);
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    const existingError = field.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// ANIMASI DASHBOARD
// ============================================
function initDashboardAnimations() {
    console.log('Animasi dashboard diaktifkan');
    
    // A. Animasi statistik cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
        }, 200 * index);
        
        // Counter animasi untuk angka
        const numberElement = card.querySelector('.stat-number');
        if (numberElement) {
            const target = parseInt(numberElement.textContent) || 0;
            animateCounter(numberElement, target, 1500);
        }
    });
    
    // B. Animasi tabel rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 100 * index);
        
        // Efek hover row
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(13, 110, 253, 0.05)';
            this.style.transition = 'background-color 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // C. Modal animations
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            const modalContent = this.querySelector('.modal-content');
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'translateY(-50px) scale(0.9)';
            
            setTimeout(() => {
                modalContent.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                modalContent.style.opacity = '1';
                modalContent.style.transform = 'translateY(0) scale(1)';
            }, 10);
        });
    });
}

// NOTIFIKASI SEDERHANA
// ============================================
function initSimpleNotifications() {
    console.log('Sistem notifikasi diaktifkan');
    
    // Buat container notifikasi
    const container = document.createElement('div');
    container.id = 'notification-container';
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 300px;
    `;
    document.body.appendChild(container);
}

function showSimpleNotification(message, type = 'info') {
    const container = document.getElementById('notification-container');
    if (!container) return;
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.style.cssText = `
        animation: slideInRight 0.3s ease;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    const icons = {
        'success': 'fas fa-check-circle',
        'danger': 'fas fa-exclamation-circle',
        'warning': 'fas fa-exclamation-triangle',
        'info': 'fas fa-info-circle'
    };
    
    notification.innerHTML = `
        <i class="${icons[type] || icons.info} me-2"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    
    container.appendChild(notification);
    
    // Auto remove setelah 5 detik
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            notification.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }
    }, 5000);
}

// WAKTU REAL-TIME
// ============================================
function initRealTimeClock() {
    function updateClock() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        const timeStr = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        // Update semua elemen clock
        document.querySelectorAll('.real-time-date').forEach(el => {
            el.textContent = dateStr;
        });
        
        document.querySelectorAll('.real-time-clock').forEach(el => {
            el.textContent = timeStr;
        });
        
        // Update badge stok
        document.querySelectorAll('.stock-time').forEach(el => {
            el.textContent = `Update: ${now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            })}`;
        });
    }
    
    // Update setiap detik
    updateClock();
    setInterval(updateClock, 1000);
}

// CSS ANIMATIONS (ditambahkan via JavaScript)
// ============================================
function addAnimationStyles() {
    const style = document.createElement('style');
    style.textContent = `
        /* Animasi dasar */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Class untuk animasi */
        .updating {
            animation: pulse 0.5s ease-in-out;
        }
        
        .rotating {
            animation: rotate 1s linear infinite;
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Loading spinner */
        .spinner-border {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            vertical-align: text-bottom;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: rotate 0.75s linear infinite;
        }
        
        /* Smooth transitions */
        .card, .btn, .navbar {
            transition: all 0.3s ease;
        }
        
        /* Focus state untuk form */
        .focused {
            position: relative;
        }
        
        .focused::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #dc3545, #ffc107);
            animation: widthGrow 0.3s ease;
        }
        
        @keyframes widthGrow {
            from { width: 0; }
            to { width: 100%; }
        }
        
        /* Typing effect */
        .typing input,
        .typing textarea {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #notification-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    `;
    
    document.head.appendChild(style);
}

// Fungsi untuk menambahkan styles
addAnimationStyles();

window.SPBUAnimations = {
    showNotification: showSimpleNotification,
    animateCounter: animateCounter,
    refreshStock: simulateStockUpdate,
    
    // Fungsi untuk debug
    debug: function() {
        console.log('SPBU Animations Active');
        console.log('Cards:', document.querySelectorAll('.card').length);
        console.log('Stock Cards:', document.querySelectorAll('.stock-card').length);
        console.log('Forms:', document.querySelectorAll('form').length);
    }
};