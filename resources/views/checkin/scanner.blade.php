@extends('admin.layouts.app')

@php
    $locale = app()->getLocale();
    $isArabic = $locale === 'ar';
@endphp

@section('title', $isArabic ? 'مسح بطاقات الدخول' : 'Scan Entry Tickets')
@section('page-title', $isArabic ? 'نقطة التحقق من الدخول' : 'Check-in Point')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-qrcode me-2"></i>{{ $isArabic ? 'مسح بطاقة الدخول' : 'Scan Entry Ticket' }}</h4>
            </div>
            <div class="card-body p-4">
                <!-- Scanner Area -->
                <div class="text-center mb-4">
                    <div id="scanner-container" class="mx-auto" style="max-width: 500px; position: relative;">
                        <div id="qr-reader" style="border: 3px dashed #667eea; border-radius: 12px; padding: 20px;"></div>
                        <div id="manual-input-toggle" class="mt-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleManualInput()">
                                <i class="fas fa-keyboard me-2"></i>{{ $isArabic ? 'إدخال يدوي' : 'Manual Input' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Manual Input (Hidden by default) -->
                <div id="manual-input-section" class="d-none mb-4">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <label class="form-label">{{ $isArabic ? 'أدخل رمز QR يدوياً' : 'Enter QR Code Manually' }}</label>
                            <div class="input-group">
                                <input type="text" id="manual-qr-input" class="form-control" placeholder="{{ $isArabic ? 'الصق بيانات QR هنا...' : 'Paste QR data here...' }}">
                                <button class="btn btn-primary" onclick="verifyManualInput()">
                                    <i class="fas fa-check me-2"></i>{{ $isArabic ? 'تحقق' : 'Verify' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Result Display -->
                <div id="result-container" class="mt-4"></div>

                <!-- Statistics -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3 id="success-count" class="mb-0">0</h3>
                                <small>{{ $isArabic ? 'دخول ناجح اليوم' : 'Successful Today' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3 id="duplicate-count" class="mb-0">0</h3>
                                <small>{{ $isArabic ? 'محاولات مكررة' : 'Duplicates' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h3 id="failed-count" class="mb-0">0</h3>
                                <small>{{ $isArabic ? 'فشل التحقق' : 'Failed' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let successCount = 0;
let duplicateCount = 0;
let failedCount = 0;
let html5QrCode;
const isArabic = {{ $isArabic ? 'true' : 'false' }};

// Initialize QR Scanner
function initScanner() {
    html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error("Unable to start scanning", err);
        showResult('error', isArabic ? 'فشل تشغيل الكاميرا. استخدم الإدخال اليدوي.' : 'Failed to start camera. Use manual input.');
    });
}

function onScanSuccess(decodedText, decodedResult) {
    // Pause scanning temporarily
    html5QrCode.pause();

    // Verify the QR code
    verifyQRCode(decodedText);

    // Resume after 3 seconds
    setTimeout(() => {
        html5QrCode.resume();
    }, 3000);
}

function onScanError(errorMessage) {
    // Ignore scan errors (they happen frequently)
}

function verifyQRCode(qrData) {
    fetch('{{ route("checkin.verify") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ qr_data: qrData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            successCount++;
            document.getElementById('success-count').textContent = successCount;
            showResult('success', data.message, data.participant, data.total_days);
            playSound('success');
        } else {
            if (data.message.includes('مسبقاً') || data.message.includes('already')) {
                duplicateCount++;
                document.getElementById('duplicate-count').textContent = duplicateCount;
            } else {
                failedCount++;
                document.getElementById('failed-count').textContent = failedCount;
            }
            showResult('error', data.message);
            playSound('error');
        }
    })
    .catch(error => {
        failedCount++;
        document.getElementById('failed-count').textContent = failedCount;
        showResult('error', isArabic ? 'حدث خطأ في الاتصال' : 'Connection error');
        playSound('error');
    });
}

function showResult(type, message, participant = null, totalDays = 0) {
    const container = document.getElementById('result-container');
    let html = '';

    if (type === 'success') {
        html = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-check-circle me-2"></i>${message}</h5>
                ${participant ? `
                    <hr>
                    <p class="mb-1"><strong>${isArabic ? 'الاسم:' : 'Name:'}</strong> ${participant.name}</p>
                    <p class="mb-1"><strong>${isArabic ? 'البريد:' : 'Email:'}</strong> ${participant.email}</p>
                    <p class="mb-1"><strong>${isArabic ? 'النوع:' : 'Type:'}</strong> ${participant.type}</p>
                    <p class="mb-0"><strong>${isArabic ? 'إجمالي أيام الحضور:' : 'Total attendance days:'}</strong> ${totalDays}</p>
                ` : ''}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    } else {
        html = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-times-circle me-2"></i>${message}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }

    container.innerHTML = html;

    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        container.innerHTML = '';
    }, 5000);
}

function toggleManualInput() {
    const section = document.getElementById('manual-input-section');
    section.classList.toggle('d-none');
}

function verifyManualInput() {
    const input = document.getElementById('manual-qr-input');
    const qrData = input.value.trim();

    if (qrData) {
        verifyQRCode(qrData);
        input.value = '';
    }
}

function playSound(type) {
    // Optional: Add sound effects
    const audio = new Audio(type === 'success' ? '/sounds/success.mp3' : '/sounds/error.mp3');
    audio.play().catch(() => {});
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initScanner();
});
</script>
@endpush

@push('styles')
<style>
#qr-reader {
    background: #f8f9fa;
}

.alert {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush
