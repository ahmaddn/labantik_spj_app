<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>@yield('title', 'Spj App Labantik')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .preview-container {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;

            min-height: 100px;
            /* Diperkecil */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            overflow: auto;
            /* Tambahkan scroll jika perlu */
        }

        .preview-container.has-content {
            border-color: #007bff;
            background-color: #fff;
            padding: 0;
        }

        .preview-image {
            max-width: 100%;
            max-height: 500px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .upload-zone {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-zone:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        .upload-zone.dragover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }

        .upload-zone.loading {
            border-color: #007bff;
            background-color: #f8f9fa;
            pointer-events: none;
        }

        .settings-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .file-info {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
        }

        .loading-text {
            color: #007bff;
            font-size: 14px;
            margin-top: 10px;
        }

        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }

        .success-text {
            color: #28a745;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .processing-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            z-index: 10;
        }

        /* PDF Viewer Styles */
        #pdfViewer {
            width: 100%;
            max-height: 80vh;
            overflow: auto;
            background-color: #f0f0f0;
            display: none;
        }

        #pdfViewer canvas {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Navigation Controls */
        .pdf-navigation {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            gap: 10px;
        }

        .page-info {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
