<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>بطاقة دخول - {{ $participant->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A6 landscape;
            margin: 0;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            width: 148mm;
            height: 105mm;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }

        .ticket-container {
            width: 100%;
            height: 100%;
            padding: 15mm;
            position: relative;
            color: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 8mm;
        }

        .logo {
            max-height: 15mm;
            margin-bottom: 3mm;
        }

        .conference-name {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 2mm;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .conference-dates {
            font-size: 10pt;
            opacity: 0.95;
        }

        .content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            padding: 8mm;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: relative;
        }

        .participant-info {
            margin-bottom: 5mm;
        }

        .info-row {
            margin-bottom: 3mm;
            display: table;
            width: 100%;
        }

        .info-label {
            font-size: 9pt;
            color: #666;
            font-weight: normal;
            display: table-cell;
            width: 30mm;
        }

        .info-value {
            font-size: 11pt;
            font-weight: bold;
            color: #333;
            display: table-cell;
        }

        .type-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 2mm 4mm;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
        }

        .qr-section {
            position: absolute;
            bottom: 8mm;
            left: 8mm;
            text-align: center;
        }

        .qr-code {
            width: 25mm;
            height: 25mm;
            border: 2px solid #667eea;
            border-radius: 4px;
            padding: 1mm;
            background: #fff;
        }

        .qr-label {
            font-size: 7pt;
            color: #666;
            margin-top: 1mm;
        }

        .token {
            position: absolute;
            bottom: 8mm;
            right: 8mm;
            font-size: 8pt;
            color: #999;
            font-family: monospace;
        }

        .watermark {
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%) rotate(-45deg);
            font-size: 40pt;
            color: rgba(102, 126, 234, 0.05);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }

        .decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 30mm;
            height: 30mm;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 0 100%;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="decoration"></div>

        <div class="header">
            @if($participant->conference->logo)
                <img src="{{ public_path('storage/' . $participant->conference->logo) }}" alt="Logo" class="logo">
            @endif
            <div class="conference-name">
                {{ app()->getLocale() == 'ar' ? $participant->conference->title_ar : $participant->conference->title_en }}
            </div>
            @if($participant->conference->start_date && $participant->conference->end_date)
                <div class="conference-dates">
                    {{ \Carbon\Carbon::parse($participant->conference->start_date)->format('d/m/Y') }} -
                    {{ \Carbon\Carbon::parse($participant->conference->end_date)->format('d/m/Y') }}
                </div>
            @endif
        </div>

        <div class="content">
            <div class="watermark">TICKET</div>

            <div class="participant-info">
                <div class="info-row">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $participant->name }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">البريد:</span>
                    <span class="info-value">{{ $participant->email }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">النوع:</span>
                    <span class="info-value">
                        <span class="type-badge">
                            @if($participant->type == 'visitor') زائر
                            @elseif($participant->type == 'exhibitor') عارض
                            @elseif($participant->type == 'speaker') متحدث
                            @else راعي
                            @endif
                        </span>
                    </span>
                </div>

                @if($participant->company)
                <div class="info-row">
                    <span class="info-label">الشركة:</span>
                    <span class="info-value">{{ $participant->company }}</span>
                </div>
                @endif
            </div>

            <div class="qr-section">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" class="qr-code">
                <div class="qr-label">امسح للدخول</div>
            </div>

            <div class="token">
                #{{ substr($participant->approval_token, 0, 8) }}
            </div>
        </div>
    </div>
</body>
</html>
