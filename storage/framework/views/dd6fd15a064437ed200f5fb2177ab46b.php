<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <title>ESD Garment Locker Status</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 16px;
        }

        /* Main Container - Full Width Responsive */
        .container {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Header - White Text Centered */
        .header {
            text-align: center;
            margin: 20px 0 30px 0;
        }

        .header h1 {
            color: white;
            font-size: clamp(24px, 6vw, 36px);
            font-weight: 700;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: clamp(14px, 4vw, 16px);
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Legend - Responsive */
        .legend-wrapper {
            background: white;
            border-radius: 50px;
            padding: 12px 24px;
            display: inline-flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: clamp(16px, 4vw, 32px);
            margin: 20px auto 30px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: fit-content;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: clamp(12px, 3.5vw, 14px);
            font-weight: 500;
            white-space: nowrap;
        }

        .legend-dot {
            width: clamp(10px, 3vw, 12px);
            height: clamp(10px, 3vw, 12px);
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .dot-available { background: linear-gradient(135deg, #f05252 0%, #ef4444 100%); }
        .dot-filled { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .dot-process { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .dot-finish { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }

        /* Dashboard Grid - 2 Kolom Fixed tanpa Wrapping */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
        }

        .column {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            min-width: 0; /* Mencegah overflow */
        }

        .column-header {
            padding: 0 12px 16px 12px;
            border-bottom: 2px solid #f3f4f6;
            margin-bottom: 16px;
        }

        .column-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #4b5563;
            letter-spacing: 0.5px;
        }

        .column-header h2 i {
            margin-right: 8px;
            color: #8b5cf6;
        }

        /* Locker Items - Grid Layout tanpa Wrap */
        .locker-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .locker-item {
            background: white;
            border-radius: 16px;
            padding: 16px 20px;
            display: grid;
            grid-template-columns: 110px 1fr auto;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            width: 100%;
        }

        .locker-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
            border-color: #8b5cf6;
        }

        .locker-number {
            font-weight: 700;
            font-size: 15px;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }

        .locker-number i {
            font-size: 16px;
            color: #8b5cf6;
            width: 20px;
            text-align: center;
        }

        .locker-info {
            display: grid;
            grid-template-columns: 100px 140px 100px;
            gap: 12px;
            align-items: center;
            min-width: 0;
        }

        .locker-meta {
            font-size: 14px;
            color: #4b5563;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .locker-meta.nik {
            min-width: 0;
        }

        .locker-meta.name {
            min-width: 0;
        }

        .locker-meta.dept {
            min-width: 0;
        }

        .locker-meta.status {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-end;
            white-space: nowrap;
        }

        .status-badge {
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-badge i {
            font-size: 12px;
        }

        .status-Available {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .status-Filled {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .status-On-Process-Measure {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-Finish {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .btn-check {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 100px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            white-space: nowrap;
        }

        .btn-check:hover {
            background: #f9fafb;
            border-color: #8b5cf6;
            color: #8b5cf6;
        }

        /* Modal - Responsif dan Terpusat */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 32px;
            width: 100%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
            padding: clamp(24px, 5vw, 32px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalSlideIn 0.3s ease;
            margin: auto;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .modal-header h3 {
            font-size: clamp(20px, 5vw, 24px);
            font-weight: 700;
            color: #1f2937;
        }

        .modal-header h3 span {
            color: #8b5cf6;
            background: #f3f4f6;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: clamp(14px, 4vw, 16px);
            margin-left: 8px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 20px;
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s;
            padding: 8px;
        }

        .close-modal:hover {
            color: #4b5563;
        }

        /* Form Grid Responsif */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: clamp(12px, 3.5vw, 14px);
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: clamp(10px, 3vw, 12px) clamp(12px, 3.5vw, 16px);
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            font-size: clamp(14px, 4vw, 15px);
            transition: all 0.2s;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }

        .form-group input[readonly] {
            background: #f9fafb;
            border-color: #e5e7eb;
            color: #6b7280;
        }

        /* Numpad Styles - Responsif */
        .numpad-wrapper {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px dashed #e5e7eb;
        }

        .numpad-title {
            font-size: clamp(13px, 3.5vw, 14px);
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .numpad-title i {
            color: #8b5cf6;
            font-size: clamp(14px, 4vw, 16px);
        }

        .numpad-input-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            padding: 8px 12px;
            background: #f3f4f6;
            border-radius: 12px;
            font-size: clamp(12px, 3vw, 13px);
            color: #4b5563;
            flex-wrap: wrap;
        }

        .numpad-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 8px;
        }

        .numpad-btn {
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: clamp(12px, 4vw, 16px);
            font-size: clamp(18px, 6vw, 24px);
            font-weight: 700;
            color: #1f2937;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            min-height: 60px;
        }

        .numpad-btn:hover {
            background: #8b5cf6;
            border-color: #8b5cf6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -4px rgba(139, 92, 246, 0.3);
        }

        .numpad-btn:active {
            transform: translateY(0);
        }

        .numpad-btn.special {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            border-color: #8b5cf6;
            color: white;
            font-size: clamp(16px, 5vw, 20px);
        }

        .numpad-btn.special:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            border-color: #7c3aed;
        }

        .numpad-btn.clear {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
            font-size: clamp(14px, 4vw, 18px);
        }

        .numpad-btn.clear:hover {
            background: #fecaca;
            border-color: #fca5a5;
        }

        .numpad-btn.delete {
            background: #f3f4f6;
            border-color: #e5e7eb;
            color: #4b5563;
            font-size: clamp(16px, 5vw, 20px);
        }

        .numpad-btn.delete:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1 1 auto;
            min-width: 120px;
            padding: clamp(12px, 3vw, 14px) clamp(16px, 4vw, 24px);
            border: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: clamp(14px, 4vw, 15px);
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            color: white;
            box-shadow: 0 4px 6px -2px rgba(139, 92, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -4px rgba(139, 92, 246, 0.4);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #4b5563;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-reset {
            background: #fee2e2;
            color: #991b1b;
            border: none;
            width: 100%;
            margin-top: 12px;
            padding: clamp(12px, 3vw, 14px);
        }

        .btn-reset:hover {
            background: #fecaca;
        }

        /* Toast - Responsif */
        .toast {
            position: fixed;
            bottom: clamp(16px, 5vw, 24px);
            right: clamp(16px, 5vw, 24px);
            left: clamp(16px, 5vw, 24px);
            background: white;
            color: #1f2937;
            padding: clamp(12px, 4vw, 16px) clamp(16px, 5vw, 24px);
            border-radius: 100px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            display: none;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 2000;
            animation: toastSlideIn 0.3s ease;
            border-left: 4px solid #10b981;
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }

        .toast.show {
            display: flex;
        }

        .toast i {
            color: #10b981;
            font-size: clamp(18px, 5vw, 20px);
        }

        .toast span {
            font-size: clamp(14px, 4vw, 15px);
        }

        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Confirmation Modal - Responsif */
        .confirm-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1500;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .confirm-modal.show {
            display: flex;
        }

        .confirm-content {
            background: white;
            border-radius: 24px;
            padding: clamp(24px, 6vw, 32px);
            max-width: 400px;
            width: 100%;
            text-align: center;
            animation: modalSlideIn 0.3s ease;
            margin: auto;
        }

        .confirm-content i {
            font-size: clamp(36px, 10vw, 48px);
            color: #f59e0b;
            margin-bottom: 16px;
        }

        .confirm-content p {
            font-size: clamp(16px, 5vw, 18px);
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 24px;
        }

        .confirm-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-confirm-yes, .btn-confirm-no {
            flex: 1 1 auto;
            min-width: 100px;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            font-size: clamp(14px, 4vw, 15px);
        }

        .btn-confirm-yes {
            background: #10b981;
            color: white;
        }

        .btn-confirm-yes:hover {
            background: #059669;
        }

        .btn-confirm-no {
            background: #ef4444;
            color: white;
        }

        .btn-confirm-no:hover {
            background: #dc2626;
        }

        /* Responsive Breakpoints - Memastikan card tetap di samping */
        @media (max-width: 1400px) {
            .locker-info {
                grid-template-columns: 90px 120px 90px;
                gap: 8px;
            }
            
            .locker-item {
                grid-template-columns: 100px 1fr auto;
                padding: 14px 16px;
            }
        }

        @media (max-width: 1200px) {
            .locker-info {
                grid-template-columns: 80px 100px 80px;
                gap: 6px;
            }
            
            .locker-meta {
                font-size: 13px;
            }
            
            .status-badge {
                padding: 4px 12px;
                font-size: 12px;
            }
        }

        @media (max-width: 1024px) {
            .dashboard {
                gap: 16px;
            }
            
            .locker-item {
                grid-template-columns: 90px 1fr auto;
                padding: 12px 14px;
            }
            
            .locker-info {
                grid-template-columns: 70px 90px 70px;
            }
        }

        @media (max-width: 900px) {
            .locker-info {
                grid-template-columns: 60px 80px 60px;
                gap: 4px;
            }
            
            .locker-meta {
                font-size: 12px;
            }
            
            .status-badge {
                padding: 4px 8px;
                font-size: 11px;
            }
            
            .btn-check {
                padding: 4px 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 0 12px;
            }

            /* Tetap 2 kolom di tablet */
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .column {
                padding: 16px;
            }

            .legend-wrapper {
                padding: 10px 16px;
                width: 100%;
                justify-content: space-around;
            }

            .legend-item {
                font-size: 12px;
            }

            /* Menyesuaikan ukuran untuk tablet */
            .locker-item {
                grid-template-columns: 1fr;
                gap: 8px;
                padding: 12px;
            }

            .locker-number {
                width: 100%;
                justify-content: space-between;
                border-bottom: 1px solid #f3f4f6;
                padding-bottom: 6px;
            }

            .locker-info {
                grid-template-columns: repeat(3, 1fr);
                width: 100%;
                gap: 8px;
            }

            .locker-meta.status {
                justify-content: flex-start;
                width: 100%;
                margin-top: 4px;
            }

            .modal-content {
                padding: 20px;
            }

            .numpad-btn {
                min-height: 50px;
                padding: 12px;
            }

            .toast {
                left: 16px;
                right: 16px;
                max-width: none;
                border-radius: 16px;
            }
        }

        @media (max-width: 640px) {
            .locker-info {
                grid-template-columns: 1fr;
                gap: 4px;
            }
            
            .locker-meta.nik,
            .locker-meta.name,
            .locker-meta.dept {
                text-align: left;
            }
        }

        @media (max-width: 480px) {
            /* Tetap 2 kolom di mobile kecil */
            .dashboard {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .column {
                padding: 12px;
            }

            .column-header h2 {
                font-size: 14px;
            }

            .locker-item {
                padding: 10px;
            }

            .locker-number {
                font-size: 13px;
            }

            .locker-number i {
                font-size: 14px;
                width: 18px;
            }

            .locker-meta {
                font-size: 11px;
            }

            .status-badge {
                padding: 3px 6px;
                font-size: 10px;
            }

            .status-badge i {
                font-size: 9px;
            }

            .modal-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .modal-header h3 span {
                margin-left: 0;
                margin-top: 4px;
                display: inline-block;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .modal-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .numpad-grid {
                gap: 6px;
            }

            .numpad-btn {
                min-height: 45px;
                font-size: 20px;
            }

            .confirm-actions {
                flex-direction: column;
            }

            .btn-confirm-yes, .btn-confirm-no {
                width: 100%;
            }
        }

        /* Untuk layar sangat kecil */
        @media (max-width: 360px) {
            .legend-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .legend-item {
                width: 100%;
            }

            .dashboard {
                gap: 6px;
            }

            .column {
                padding: 8px;
            }

            .locker-item {
                padding: 8px;
            }

            .locker-number {
                font-size: 12px;
            }
        }

        /* Landscape mode untuk mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            .modal-content {
                max-height: 85vh;
            }

            .numpad-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .numpad-btn {
                min-height: 40px;
                padding: 8px;
            }
        }

        /* Utility classes */
        .text-center {
            text-align: center;
        }

        .d-flex {
            display: flex;
        }

        .justify-center {
            justify-content: center;
        }

        .items-center {
            align-items: center;
        }

        .w-100 {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header - White Text Centered -->
        <div class="header">
            <h1>ESD Garment Locker Status</h1>
            <div class="header-subtitle">Real-time locker monitoring system</div>
        </div>

        <!-- Legend - Centered -->
        <div class="d-flex justify-center">
            <div class="legend-wrapper">
                <div class="legend-item">
                    <span class="legend-dot dot-available"></span>
                    <span>Available</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot dot-filled"></span>
                    <span>Filled</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot dot-process"></span>
                    <span>On Process</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot dot-finish"></span>
                    <span>Finish</span>
                </div>
            </div>
        </div>

        <!-- Success Toast -->
        <div class="toast" id="toast">
            <i class="fas fa-check-circle"></i>
            <span id="toastMessage"></span>
        </div>

        <!-- Dashboard -->
        <div class="dashboard">
            <!-- Column 1 (1-10) -->
            <div class="column">
                <div class="column-header">
                    <h2><i class="fas fa-tshirt"></i> Locker 1 - 10</h2>
                </div>
                <div class="locker-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 10; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $locker = $lockers->firstWhere('locker_number', $i);
                        ?>
                        <div class="locker-item <?php echo e($locker ? '' : 'no-data'); ?>" 
                             data-locker-number="<?php echo e($i); ?>"
                             data-nik="<?php echo e($locker->nik ?? ''); ?>"
                             data-name="<?php echo e($locker->name ?? ''); ?>"
                             data-dept="<?php echo e($locker->dept ?? ''); ?>"
                             data-status="<?php echo e($locker->status ?? 'Available'); ?>">
                            <div class="locker-number">
                                <i class="fas <?php echo e($locker ? getStatusIcon($locker->status) : 'fa-unlock'); ?>"></i>
                                Locker <?php echo e($i); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($locker): ?>
                                <div class="locker-info">
                                    <div class="locker-meta nik"><?php echo e($locker->nik ?? '-'); ?></div>
                                    <div class="locker-meta name"><?php echo e($locker->name ?? '-'); ?></div>
                                    <div class="locker-meta dept"><?php echo e($locker->dept ?? '-'); ?></div>
                                </div>
                                <div class="locker-meta status">
                                    <span class="status-badge status-<?php echo e(str_replace(' ', '-', $locker->status)); ?>">
                                        <i class="fas <?php echo e(getStatusIcon($locker->status)); ?>"></i>
                                        <?php echo e($locker->status); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($locker->status === 'Finish'): ?>
                                        <button class="btn-check" data-locker-number="<?php echo e($i); ?>">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="locker-info">
                                    <div class="locker-meta nik">-</div>
                                    <div class="locker-meta name">-</div>
                                    <div class="locker-meta dept">-</div>
                                </div>
                                <div class="locker-meta status">
                                    <span class="status-badge status-Available">
                                        <i class="fas fa-unlock"></i> Available
                                    </span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>

            <!-- Column 2 (11-20) -->
            <div class="column">
                <div class="column-header">
                    <h2><i class="fas fa-tshirt"></i> Locker 11 - 20</h2>
                </div>
                <div class="locker-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 11; $i <= 20; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $locker = $lockers->firstWhere('locker_number', $i);
                        ?>
                        <div class="locker-item <?php echo e($locker ? '' : 'no-data'); ?>" 
                             data-locker-number="<?php echo e($i); ?>"
                             data-nik="<?php echo e($locker->nik ?? ''); ?>"
                             data-name="<?php echo e($locker->name ?? ''); ?>"
                             data-dept="<?php echo e($locker->dept ?? ''); ?>"
                             data-status="<?php echo e($locker->status ?? 'Available'); ?>">
                            <div class="locker-number">
                                <i class="fas <?php echo e($locker ? getStatusIcon($locker->status) : 'fa-unlock'); ?>"></i>
                                Locker <?php echo e($i); ?>

                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($locker): ?>
                                <div class="locker-info">
                                    <div class="locker-meta nik"><?php echo e($locker->nik ?? '-'); ?></div>
                                    <div class="locker-meta name"><?php echo e($locker->name ?? '-'); ?></div>
                                    <div class="locker-meta dept"><?php echo e($locker->dept ?? '-'); ?></div>
                                </div>
                                <div class="locker-meta status">
                                    <span class="status-badge status-<?php echo e(str_replace(' ', '-', $locker->status)); ?>">
                                        <i class="fas <?php echo e(getStatusIcon($locker->status)); ?>"></i>
                                        <?php echo e($locker->status); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($locker->status === 'Finish'): ?>
                                        <button class="btn-check" data-locker-number="<?php echo e($i); ?>">
                                            <i class="fas fa-check"></i> Confirm
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="locker-info">
                                    <div class="locker-meta nik">-</div>
                                    <div class="locker-meta name">-</div>
                                    <div class="locker-meta dept">-</div>
                                </div>
                                <div class="locker-meta status">
                                    <span class="status-badge status-Available">
                                        <i class="fas fa-unlock"></i> Available
                                    </span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Modal -->
    <div class="modal" id="lockerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Locker Detail <span id="modalLockerNumber">#1</span></h3>
                <button class="close-modal" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="lockerForm">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="lockerNumberInput" name="locker_number">
                
                <!-- Form Grid Responsif -->
                <div class="form-grid">
                    <!-- Kolom Kiri -->
                    <div>
                        <div class="form-group">
                            <label><i class="fas fa-id-card" style="color: #8b5cf6; margin-right: 4px;"></i> NIK</label>
                            <input type="text" id="nikInput" name="nik" placeholder="Enter NIK" autocomplete="off" required>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-building" style="color: #8b5cf6; margin-right: 4px;"></i> Department</label>
                            <input type="text" id="deptInput" name="dept" placeholder="Auto-filled" readonly required>
                        </div>
                    </div>
                    
                    <!-- Kolom Kanan -->
                    <div>
                        <div class="form-group">
                            <label><i class="fas fa-user" style="color: #8b5cf6; margin-right: 4px;"></i> Name</label>
                            <input type="text" id="nameInput" name="name" placeholder="Auto-filled" readonly required>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-info-circle" style="color: #8b5cf6; margin-right: 4px;"></i> Status</label>
                            <input type="text" id="statusInput" name="status_display" readonly style="font-weight: 600; color: #1f2937;">
                            <input type="hidden" id="statusInputHidden" name="status">
                        </div>
                    </div>
                </div>

                <!-- Numpad Section -->
                <div class="numpad-wrapper">
                    <div class="numpad-title">
                        <i class="fas fa-keyboard"></i>
                        <span>Numpad Input</span>
                    </div>
                    
                    <div class="numpad-input-indicator">
                        <i class="fas fa-hand-pointer"></i>
                        <span>Click numbers to enter NIK</span>
                    </div>
                    
                    <div class="numpad-grid">
                        <button type="button" class="numpad-btn" data-num="1">1</button>
                        <button type="button" class="numpad-btn" data-num="2">2</button>
                        <button type="button" class="numpad-btn" data-num="3">3</button>
                        <button type="button" class="numpad-btn" data-num="4">4</button>
                        <button type="button" class="numpad-btn" data-num="5">5</button>
                        <button type="button" class="numpad-btn" data-num="6">6</button>
                        <button type="button" class="numpad-btn" data-num="7">7</button>
                        <button type="button" class="numpad-btn" data-num="8">8</button>
                        <button type="button" class="numpad-btn" data-num="9">9</button>
                        <button type="button" class="numpad-btn delete" id="numpadDelete">
                            <i class="fas fa-backspace"></i>
                        </button>
                        <button type="button" class="numpad-btn" data-num="0">0</button>
                        <button type="button" class="numpad-btn clear" id="numpadClear">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                    <div class="numpad-grid">
                        <button type="button" class="numpad-btn special" id="numpadEnter" style="grid-column: span 3;">
                            <i class="fas fa-check-circle"></i> Enter
                        </button>
                    </div>
                </div>
                
                <!-- Modal Actions -->
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="closeModalBtn2">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                
                <button type="button" id="resetLockerBtn" class="btn btn-reset">
                    <i class="fas fa-undo-alt"></i> Reset to Available
                </button>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="confirm-modal" id="confirmModal">
        <div class="confirm-content">
            <i class="fas fa-question-circle"></i>
            <p id="confirmMessage">Confirm Uniform?</p>
            <div class="confirm-actions">
                <button class="btn-confirm-yes" id="confirmYesBtn">Yes</button>
                <button class="btn-confirm-no" id="confirmNoBtn">No</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // DOM Elements
        const modal = document.getElementById('lockerModal');
        const confirmModal = document.getElementById('confirmModal');
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toastMessage');
        
        // Form Elements
        const lockerNumberSpan = document.getElementById('modalLockerNumber');
        const lockerNumberInput = document.getElementById('lockerNumberInput');
        const nikInput = document.getElementById('nikInput');
        const nameInput = document.getElementById('nameInput');
        const deptInput = document.getElementById('deptInput');
        const statusInput = document.getElementById('statusInput');
        const statusHidden = document.getElementById('statusInputHidden');
        
        // Numpad Elements
        const numpadDelete = document.getElementById('numpadDelete');
        const numpadClear = document.getElementById('numpadClear');
        const numpadEnter = document.getElementById('numpadEnter');
        
        let employees = [];
        let currentLockerNumber = null;
        let confirmResolve = null;

        // Status Icon Helper
        function getStatusIconClass(status) {
            switch(status) {
                case 'Available': return 'fa-unlock';
                case 'Filled': return 'fa-lock';
                case 'On Process Measure': return 'fa-rocket';
                case 'Finish': return 'fa-circle-check';
                default: return 'fa-question-circle';
            }
        }

        // Show Toast
        function showToast(message, isSuccess = true) {
            toastMessage.textContent = message;
            toast.classList.add('show');
            toast.style.borderLeftColor = isSuccess ? '#10b981' : '#ef4444';
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Update Locker Display
        function updateLockerDisplay(lockerNumber, nik, name, dept, status) {
            const lockerItem = document.querySelector(`.locker-item[data-locker-number="${lockerNumber}"]`);
            if (!lockerItem) return;

            lockerItem.setAttribute('data-nik', nik);
            lockerItem.setAttribute('data-name', name);
            lockerItem.setAttribute('data-dept', dept);
            lockerItem.setAttribute('data-status', status);

            const iconClass = getStatusIconClass(status);
            const statusClass = status.replace(/ /g, '-');

            lockerItem.innerHTML = `
                <div class="locker-number">
                    <i class="fas ${iconClass}"></i>
                    Locker ${lockerNumber}
                </div>
                <div class="locker-info">
                    <div class="locker-meta nik">${nik || '-'}</div>
                    <div class="locker-meta name">${name || '-'}</div>
                    <div class="locker-meta dept">${dept || '-'}</div>
                </div>
                <div class="locker-meta status">
                    <span class="status-badge status-${statusClass}">
                        <i class="fas ${iconClass}"></i>
                        ${status}
                    </span>
                    ${status === 'Finish' ? `
                        <button class="btn-check" data-locker-number="${lockerNumber}">
                            <i class="fas fa-check"></i> Confirm
                        </button>
                    ` : ''}
                </div>
            `;

            // Re-attach confirm button listener
            if (status === 'Finish') {
                const confirmBtn = lockerItem.querySelector('.btn-check');
                if (confirmBtn) {
                    confirmBtn.addEventListener('click', async (e) => {
                        e.stopPropagation();
                        showConfirmModal(`Confirm Uniform for Locker ${lockerNumber}?`).then(async (confirmed) => {
                            if (confirmed) {
                                await resetLocker(lockerNumber);
                            }
                        });
                    });
                }
            }
        }

        // Reset Locker
        async function resetLocker(lockerNumber) {
            try {
                const response = await fetch("<?php echo e(route('locker.update')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        locker_number: lockerNumber,
                        nik: '',
                        name: '',
                        dept: '',
                        status: 'Available'
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    updateLockerDisplay(lockerNumber, '', '', '', 'Available');
                    showToast(`Locker ${lockerNumber} reset successfully!`);
                    if (modal.classList.contains('show')) {
                        modal.classList.remove('show');
                    }
                } else {
                    showToast('Failed to reset locker.', false);
                }
            } catch (error) {
                showToast('Error: ' + error.message, false);
            }
        }

        // Show Confirm Modal
        function showConfirmModal(message) {
            return new Promise((resolve) => {
                confirmResolve = resolve;
                document.getElementById('confirmMessage').textContent = message;
                confirmModal.classList.add('show');
            });
        }

        // Check NIK and auto-fill
        function checkNIK(nik) {
            const matched = employees.find(emp => emp.nik === nik);
            if (matched) {
                nameInput.value = matched.name;
                deptInput.value = matched.dept;
                statusInput.value = 'Filled';
                statusHidden.value = 'Filled';
            } else {
                nameInput.value = '';
                deptInput.value = '';
                statusInput.value = statusInput.value === 'Filled' ? '' : statusInput.value;
            }
        }

        // Numpad Functions
        function addNumberToNIK(num) {
            if (nikInput.disabled) return;
            nikInput.value += num;
            checkNIK(nikInput.value);
        }

        function deleteLastChar() {
            if (nikInput.disabled) return;
            nikInput.value = nikInput.value.slice(0, -1);
            checkNIK(nikInput.value);
        }

        function clearNIK() {
            if (nikInput.disabled) return;
            nikInput.value = '';
            nameInput.value = '';
            deptInput.value = '';
        }

        // Numpad Event Listeners
        document.querySelectorAll('.numpad-btn[data-num]').forEach(btn => {
            btn.addEventListener('click', () => {
                addNumberToNIK(btn.getAttribute('data-num'));
            });
        });

        numpadDelete.addEventListener('click', deleteLastChar);
        numpadClear.addEventListener('click', clearNIK);
        
        numpadEnter.addEventListener('click', () => {
            if (nikInput.value.trim()) {
                document.getElementById('saveBtn').click();
            } else {
                showToast('Please enter NIK', false);
            }
        });

        // Keyboard support
        document.addEventListener('keydown', (e) => {
            if (!modal.classList.contains('show') || nikInput.disabled) return;

            if (e.key === 'Enter') {
                e.preventDefault();
                numpadEnter.click();
            } 
            else if (e.key === 'Backspace') {
                setTimeout(() => {
                    checkNIK(nikInput.value);
                }, 0);
            } 
            else if (e.key === 'Delete' || e.key === 'Escape') {
                clearNIK();
            }
        });

        // Fetch Employees
        fetch('/employees')
            .then(response => response.json())
            .then(data => {
                employees = data;
            })
            .catch(error => {
                console.error('Failed to load employees:', error);
            });

        // NIK Input Handler
        nikInput.addEventListener('input', function() {
            const inputNik = this.value.trim();
            checkNIK(inputNik);
        });

        // Locker Click Handler
        document.querySelectorAll('.locker-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.classList.contains('btn-check')) return;
                
                const lockerNumber = item.getAttribute('data-locker-number');
                const nik = item.getAttribute('data-nik') || '';
                const name = item.getAttribute('data-name') || '';
                const dept = item.getAttribute('data-dept') || '';
                const status = item.getAttribute('data-status') || 'Available';

                lockerNumberSpan.textContent = `#${lockerNumber}`;
                lockerNumberInput.value = lockerNumber;
                nikInput.value = nik;
                nameInput.value = name;
                deptInput.value = dept;
                statusInput.value = status;
                statusHidden.value = status;
                currentLockerNumber = lockerNumber;

                // Disable NIK input and numpad if not Available
                const isAvailable = status === 'Available';
                nikInput.disabled = !isAvailable;
                nikInput.readOnly = !isAvailable;
                
                // Enable/disable numpad buttons
                document.querySelectorAll('.numpad-btn').forEach(btn => {
                    btn.style.opacity = isAvailable ? '1' : '0.5';
                    btn.style.pointerEvents = isAvailable ? 'auto' : 'none';
                });
                
                modal.classList.add('show');
                
                // Auto focus
                setTimeout(() => {
                    if (isAvailable) {
                        nikInput.focus();
                        nikInput.select();
                    }
                }, 100);
            });
        });

        // Confirm Button Handlers
        document.querySelectorAll('.btn-check').forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.stopPropagation();
                const lockerNumber = btn.getAttribute('data-locker-number');
                showConfirmModal(`Confirm Uniform for Locker ${lockerNumber}?`).then(async (confirmed) => {
                    if (confirmed) {
                        await resetLocker(lockerNumber);
                    }
                });
            });
        });

        // Confirm Modal Handlers
        document.getElementById('confirmYesBtn').addEventListener('click', () => {
            if (confirmResolve) {
                confirmResolve(true);
                confirmModal.classList.remove('show');
            }
        });

        document.getElementById('confirmNoBtn').addEventListener('click', () => {
            if (confirmResolve) {
                confirmResolve(false);
                confirmModal.classList.remove('show');
            }
        });

        // Close Modal Handlers
        function closeModal() {
            modal.classList.remove('show');
        }

        document.getElementById('closeModalBtn').addEventListener('click', closeModal);
        document.getElementById('closeModalBtn2').addEventListener('click', closeModal);

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
            if (e.target === confirmModal) {
                confirmModal.classList.remove('show');
            }
        });

        // Form Submit Handler
        document.getElementById('lockerForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const lockerNumber = lockerNumberInput.value;
            const nik = nikInput.value.trim();
            const name = nameInput.value.trim();
            const dept = deptInput.value.trim();
            const status = statusInput.value;

            if (status === 'Filled' && !nik) {
                showToast('NIK is required for Filled status', false);
                return;
            }

            try {
                const response = await fetch("<?php echo e(route('locker.update')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ locker_number: lockerNumber, nik, name, dept, status }),
                });

                const data = await response.json();

                if (data.success) {
                    updateLockerDisplay(lockerNumber, nik, name, dept, status);
                    closeModal();
                    showToast(`Locker ${lockerNumber} updated successfully!`);
                } else {
                    showToast('Failed to update locker.', false);
                }
            } catch (error) {
                showToast('Error: ' + error.message, false);
            }
        });

        // Reset Button Handler
        document.getElementById('resetLockerBtn').addEventListener('click', async () => {
            const lockerNumber = lockerNumberInput.value;
            
            showConfirmModal(`Reset Locker ${lockerNumber} to Available?`).then(async (confirmed) => {
                if (confirmed) {
                    await resetLocker(lockerNumber);
                }
            });
        });

        // Fetch Locker Data
        async function fetchLockerData() {
            try {
                const response = await fetch("<?php echo e(route('locker.status')); ?>");
                const data = await response.json();

                if (data.lockers && Array.isArray(data.lockers)) {
                    data.lockers.forEach(locker => {
                        updateLockerDisplay(
                            locker.locker_number,
                            locker.nik || '',
                            locker.name || '',
                            locker.dept || '',
                            locker.status || 'Available'
                        );
                    });
                }
            } catch (error) {
                console.error('Error fetching locker data:', error);
            }
        }

        // Initialize and start polling
        fetchLockerData();
        setInterval(fetchLockerData, 5000);
    </script>

    <?php
        function getStatusIcon($status) {
            return match ($status) {
                'Available' => 'fa-unlock',
                'Filled' => 'fa-lock',
                'On Process Measure' => 'fa-rocket',
                'Finish' => 'fa-circle-check',
                default => 'fa-question-circle',
            };
        }
    ?>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/locker/locker-status.blade.php ENDPATH**/ ?>