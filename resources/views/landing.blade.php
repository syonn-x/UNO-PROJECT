<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>U.N.O (USE NOT OWN) | Platform Rental E-Commerce No. 1 di Indonesia</title>
    <meta name="description" content="Sewa kamera, drone 4K, tenda camping, motor, laptop, dan perlengkapan berkualitas tanpa harus beli mahal. Hemat, aman dengan verifikasi e-KTP, dan fleksibel bersama U.N.O.">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Pro/Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Bootstrap 4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --primary-light: #38bdf8;
            --secondary: #6366f1;
            --accent: #f59e0b;
            --emerald: #10b981;
            --dark: #090d16;
            --dark-card: #0f172a;
            --dark-surface: #1e293b;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-400: #94a3b8;
            --slate-600: #475569;
            --slate-800: #1e293b;
            --radius-xl: 20px;
            --radius-lg: 14px;
            --shadow-subtle: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --shadow-float: 0 20px 40px -15px rgba(2, 132, 199, 0.15);
            --shadow-card: 0 10px 30px -5px rgba(0, 0, 0, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* Ambient Lighting / Aurora Animations */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.45; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.08); }
        }

        @keyframes shimmerGlow {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Glassmorphism Classes */
        .glass-panel {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .glass-panel-dark {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        /* Navbar */
        .uno-navbar {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1040;
        }

        .brand-badge {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(226, 232, 240, 0.9);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .brand-badge:hover {
            transform: scale(1.06);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.2);
        }

        .brand-logo-img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .nav-link-custom {
            color: #334155 !important;
            font-weight: 600;
            font-size: 0.93rem;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover {
            color: var(--primary) !important;
            background: rgba(2, 132, 199, 0.06);
        }

        /* Hero Section */
        .hero-wrapper {
            background: radial-gradient(100% 80% at 50% 0%, #1e293b 0%, #090d16 100%);
            padding: 130px 0 110px 0;
            position: relative;
            overflow: hidden;
            color: #ffffff;
        }

        /* Ambient Orbs */
        .hero-orb-1 {
            position: absolute;
            top: -100px;
            right: -80px;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.35) 0%, rgba(99, 102, 241, 0.15) 50%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: pulseGlow 7s ease-in-out infinite;
        }

        .hero-orb-2 {
            position: absolute;
            bottom: -150px;
            left: -120px;
            width: 650px;
            height: 650px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, rgba(56, 189, 248, 0.05) 50%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            animation: pulseGlow 9s ease-in-out infinite alternate;
        }

        /* Subtle grid background texture */
        .hero-grid-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.07) 1px, transparent 1px);
            background-size: 32px 32px;
            opacity: 0.7;
            pointer-events: none;
        }

        .hero-pill-badge {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
            padding: 7px 18px;
            border-radius: 30px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #7dd3fc;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 24px;
        }

        .hero-pill-pulse {
            width: 8px;
            height: 8px;
            background: #38bdf8;
            border-radius: 50%;
            margin-right: 10px;
            box-shadow: 0 0 10px #38bdf8;
            animation: pulseGlow 1.8s infinite;
        }

        .hero-title-main {
            font-size: 3.6rem;
            font-weight: 900;
            letter-spacing: -1.5px;
            line-height: 1.12;
            margin-bottom: 24px;
            color: #ffffff;
        }

        .text-gradient-cyan {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-description {
            font-size: 1.15rem;
            color: #cbd5e1;
            line-height: 1.65;
            max-width: 570px;
            margin-bottom: 36px;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff !important;
            font-weight: 700;
            border: none;
            padding: 15px 32px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(2, 132, 199, 0.4);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
        }
        .btn-gradient-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(2, 132, 199, 0.5);
            background: linear-gradient(135deg, #0369a1 0%, #1d4ed8 100%);
        }

        .btn-glass-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #ffffff !important;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.22);
            padding: 15px 28px;
            border-radius: 14px;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none !important;
        }
        .btn-glass-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
        }

        /* Hero Right Mockup Showcase */
        .hero-visual-card {
            position: relative;
            border-radius: 26px;
            overflow: visible;
            animation: floatSlow 6s ease-in-out infinite;
        }

        .hero-img-main {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 26px;
            border: 3px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.6);
        }

        /* Floating Widgets over Hero Image */
        .hero-float-card-1 {
            position: absolute;
            top: 25px;
            left: -35px;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 14px 18px;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 5;
            max-width: 270px;
        }

        .hero-float-card-2 {
            position: absolute;
            bottom: -25px;
            right: -25px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            padding: 14px 20px;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            color: #0f172a;
            z-index: 5;
        }

        .hero-stats-banner {
            margin-top: 45px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            flex-wrap: wrap;
            gap: 28px;
        }

        .hero-stat-item {
            display: flex;
            flex-direction: column;
        }
        .hero-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }
        .hero-stat-label {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 4px;
        }

        /* Floating Search Bar */
        .search-floating-card {
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(226, 232, 240, 0.9);
            padding: 26px 32px;
            margin-top: -65px;
            position: relative;
            z-index: 20;
        }

        .search-input-group {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 16px;
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .search-input-group:focus-within {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.12);
        }

        .search-input-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.6px;
            color: #64748b;
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }

        .search-input-field {
            border: none;
            background: transparent;
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
            width: 100%;
            padding: 0;
            outline: none;
        }
        .search-input-field::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        .trending-search-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            background: #f1f5f9;
            color: #475569;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 600;
            text-decoration: none !important;
            transition: all 0.2s ease;
            margin-right: 6px;
            margin-bottom: 6px;
        }
        .trending-search-pill:hover {
            background: #e2e8f0;
            color: var(--primary);
            transform: translateY(-1px);
        }

        /* Section Headings */
        .section-tag-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 16px;
            background: rgba(2, 132, 199, 0.08);
            border: 1px solid rgba(2, 132, 199, 0.2);
            color: var(--primary);
            border-radius: 30px;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -0.8px;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: #64748b;
            line-height: 1.6;
            max-width: 620px;
            margin: 0 auto;
        }

        /* Category Grid Cards */
        .category-card-modern {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 20px;
            padding: 24px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .category-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0284c7, #6366f1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .category-card-modern:hover {
            transform: translateY(-7px);
            box-shadow: 0 16px 35px rgba(2, 132, 199, 0.12);
            border-color: #cbd5e1;
        }
        .category-card-modern:hover::before {
            opacity: 1;
        }

        .category-icon-box {
            width: 68px;
            height: 68px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.65rem;
            margin-bottom: 16px;
            transition: transform 0.3s ease;
        }
        .category-card-modern:hover .category-icon-box {
            transform: scale(1.1);
        }

        .cat-bg-blue { background: rgba(2, 132, 199, 0.1); color: #0284c7; }
        .cat-bg-purple { background: rgba(99, 102, 241, 0.1); color: #6366f1; }
        .cat-bg-amber { background: rgba(245, 158, 11, 0.1); color: #d97706; }
        .cat-bg-emerald { background: rgba(16, 185, 129, 0.1); color: #059669; }
        .cat-bg-rose { background: rgba(244, 63, 94, 0.1); color: #e11d48; }
        .cat-bg-cyan { background: rgba(6, 182, 212, 0.1); color: #0891b2; }

        .category-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .category-unit-count {
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Product Cards (Tokopedia / Airbnb hybrid polish) */
        .product-rental-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }
        .product-rental-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.1);
            border-color: #e2e8f0;
        }

        .product-img-wrapper {
            position: relative;
            padding-top: 66%;
            overflow: hidden;
            background: #f1f5f9;
        }
        .product-img-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-rental-card:hover .product-img-wrapper img {
            transform: scale(1.07);
        }

        .badge-cond-pill {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            color: #ffffff;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 2;
        }

        .badge-cat-pill {
            position: absolute;
            bottom: 14px;
            left: 14px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 2;
        }

        .product-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title-link {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.35;
            margin-bottom: 8px;
            text-decoration: none !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 44px;
            transition: color 0.2s ease;
        }
        .product-title-link:hover {
            color: var(--primary);
        }

        .product-location-store {
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .product-pricing-wrap {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .product-price-amount {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            font-family: 'Outfit', sans-serif;
        }
        .product-price-amount small {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
        }

        .btn-rent-instant {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff !important;
            font-size: 0.84rem;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
            cursor: pointer;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }
        .btn-rent-instant:hover {
            transform: scale(1.04);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.4);
            color: #ffffff;
        }

        /* Filter Tab Pills on Featured Section */
        .filter-tab-pill {
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            text-decoration: none !important;
            transition: all 0.2s ease;
            margin: 4px;
            display: inline-flex;
            align-items: center;
        }
        .filter-tab-pill:hover, .filter-tab-pill.active {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
        }

        /* Bento Features Grid (Value Proposition) */
        .bento-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 35px 28px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .bento-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .bento-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 22px;
        }

        /* Step Timeline */
        .step-node-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 35px 24px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            text-align: center;
        }
        .step-node-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(2, 132, 199, 0.09);
        }

        .step-badge-number {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.3);
            font-family: 'Outfit', sans-serif;
        }

        /* Store Card */
        .store-partner-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            padding: 28px 20px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .store-partner-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.09);
            border-color: #cbd5e1;
        }

        .store-avatar-wrap {
            position: relative;
            display: inline-block;
            margin: 0 auto 16px auto;
        }
        .store-avatar-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }
        .store-verified-pill {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #10b981;
            color: #ffffff;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            border: 2px solid #ffffff;
        }

        /* Testimonial Card */
        .testimonial-modern-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 28px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .testimonial-modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.07);
        }

        /* FAQ Accordion */
        .faq-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px !important;
            margin-bottom: 14px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        .faq-card:hover {
            border-color: #cbd5e1;
        }
        .faq-header-btn {
            width: 100%;
            text-align: left;
            padding: 20px 24px;
            background: none;
            border: none;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            text-decoration: none !important;
        }
        .faq-header-btn:focus {
            outline: none;
        }
        .faq-body-text {
            padding: 0 24px 22px 24px;
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.65;
        }

        /* High-Converting CTA Box */
        .cta-radiant-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #0369a1 100%);
            border-radius: 30px;
            padding: 70px 40px;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 60px -15px rgba(2, 132, 199, 0.3);
        }
        .cta-radiant-banner::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.3) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
        }

        /* Footer */
        .footer-ultra {
            background: #090d16;
            color: #94a3b8;
            padding: 85px 0 35px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }
        .footer-heading {
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 22px;
            text-transform: uppercase;
        }
        .footer-link {
            color: #94a3b8;
            text-decoration: none !important;
            transition: color 0.2s ease;
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .footer-link:hover {
            color: #38bdf8;
            transform: translateX(3px);
        }

        /* Modal Rental Calculator */
        .modal-rent-header {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #ffffff;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
        }
        .price-summary-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 14px;
            padding: 20px;
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .hero-title-main { font-size: 2.7rem; }
            .hero-wrapper { padding: 110px 0 70px 0; }
            .search-floating-card { margin-top: -35px; padding: 20px; }
            .hero-float-card-1 { left: 0; }
            .hero-float-card-2 { right: 0; }
        }

        @media (max-width: 576px) {
            .hero-title-main { font-size: 2.2rem; }
            .section-title { font-size: 1.85rem; }
            .cta-radiant-banner { padding: 40px 20px; text-align: center; }
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg uno-navbar fixed-top py-3">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center text-decoration-none" href="{{ route('landing') }}">
            <div class="brand-badge mr-2">
                <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
            </div>
            <div>
                <span class="font-weight-bold text-dark font-heading" style="font-size: 1.35rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                <span class="d-block text-muted text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.4px; font-weight: 800;">USE NOT OWN</span>
            </div>
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler border-0 p-2" type="button" data-toggle="collapse" data-target="#navContent">
            <i class="fas fa-bars text-dark" style="font-size: 1.25rem;"></i>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mx-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="{{ route('catalog') }}">
                        <i class="fas fa-th-large mr-1 text-primary"></i> Katalog Sewa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="#categories">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="#featured-rentals">Paling Populer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="#how-it-works">Cara Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="#verified-partners">Mitra Resmi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom" href="#faq">FAQ</a>
                </li>
            </ul>

            <!-- Auth Controls -->
            <div class="d-flex align-items-center">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm font-weight-bold text-white mr-2 px-3 py-2 shadow-sm" style="border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                            <i class="fas fa-user-shield mr-1"></i> Dashboard Admin
                        </a>
                    @endif

                    <div class="dropdown mr-2">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center border px-3 py-1 shadow-sm" type="button" id="userMenuDropdownLanding" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 14px; background: #ffffff;">
                            <img src="{{ Auth::user()->avatar_url }}" 
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0284c7&color=fff';"
                                 class="rounded-circle mr-2" style="width: 30px; height: 30px; object-fit: cover;" alt="{{ Auth::user()->name }}">
                            <div class="text-left mr-1">
                                <div class="font-weight-bold text-dark text-xs" style="line-height: 1.1;">{{ Str::limit(Auth::user()->name, 14) }}</div>
                                <span class="badge {{ Auth::user()->isOwner() ? 'badge-warning text-dark' : 'badge-primary text-white' }}" style="font-size: 0.62rem; padding: 1px 6px;">
                                    {{ Auth::user()->isOwner() ? 'Mitra Owner' : 'Penyewa (Renter)' }}
                                </span>
                            </div>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 mt-2 p-2" aria-labelledby="userMenuDropdownLanding" style="border-radius: 16px; min-width: 230px; z-index: 1060;">
                            <div class="px-3 py-2 border-bottom mb-2 bg-light rounded-lg">
                                <div class="font-weight-bold text-dark text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-muted text-xs text-truncate">{{ Auth::user()->email }}</div>
                                <span class="badge badge-success text-xs mt-1"><i class="fas fa-check-circle mr-1"></i> {{ Auth::user()->role_label }}</span>
                            </div>
                            <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'profile']) }}">
                                <i class="fas fa-user-circle text-primary mr-2"></i> Profil & Akun Saya
                            </a>
                            <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'rentals']) }}">
                                <i class="fas fa-box text-success mr-2"></i> Riwayat Sewa Saya
                            </a>
                            <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'favorites']) }}">
                                <i class="fas fa-heart text-danger mr-2"></i> Wishlist Favorit
                            </a>
                            @if(Auth::user()->isOwner())
                                <div class="dropdown-divider my-2"></div>
                                <h6 class="dropdown-header text-xs text-uppercase font-weight-bold text-muted px-3">Toko Mitra (Owner)</h6>
                                <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'my-items']) }}">
                                    <i class="fas fa-store text-warning mr-2"></i> Unit Rental Saya
                                </a>
                                <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'incoming-bookings']) }}">
                                    <i class="fas fa-bell text-info mr-2"></i> Pesanan Sewa Masuk
                                </a>
                                <a class="dropdown-item py-2 rounded-lg font-weight-medium" href="{{ route('profile.index', ['tab' => 'add-item']) }}">
                                    <i class="fas fa-plus-circle text-success mr-2"></i> Tambah Unit Rental
                                </a>
                            @endif
                            <div class="dropdown-divider my-2"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 rounded-lg font-weight-medium text-danger">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light btn-sm font-weight-bold text-dark mr-2 px-3 py-2 border shadow-sm" style="border-radius: 12px;">
                        <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                    </a>
                    
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-primary btn-sm font-weight-bold text-white px-3 py-2 shadow-sm dropdown-toggle" type="button" id="dropdownRegister" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none;">
                            <i class="fas fa-user-plus mr-1"></i> Daftar
                        </button>
                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 p-2 mt-2" aria-labelledby="dropdownRegister" style="border-radius: 16px; min-width: 240px;">
                            <a class="dropdown-item py-2 px-3 rounded-lg" href="{{ route('register') }}?role=renter">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-lg p-2 mr-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; border-radius: 10px;">
                                        <i class="fas fa-shopping-bag" style="font-size: 0.85rem;"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark text-xs">Daftar Penyewa</div>
                                        <small class="text-muted" style="font-size: 0.72rem;">Sewa barang & peralatan</small>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item py-2 px-3 rounded-lg" href="{{ route('register') }}?role=owner">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning text-dark rounded-lg p-2 mr-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; border-radius: 10px;">
                                        <i class="fas fa-store" style="font-size: 0.85rem;"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark text-xs">Daftar Mitra Owner</div>
                                        <small class="text-muted" style="font-size: 0.72rem;">Sewakan aset & raih cuan</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<header class="hero-wrapper">
    <div class="hero-orb-1"></div>
    <div class="hero-orb-2"></div>
    <div class="hero-grid-pattern"></div>

    <div class="container position-relative" style="z-index: 10;">
        <div class="row align-items-center">
            
            <!-- Left Hero Content -->
            <div class="col-lg-7 pr-lg-5">
                <div class="hero-pill-badge">
                    <span class="hero-pill-pulse"></span>
                    PLATFORM RENTAL P2P & B2C NO. 1 DI INDONESIA
                </div>

                <h1 class="hero-title-main">
                    Sewa Perlengkapan Apapun,<br>
                    <span class="text-gradient-cyan">Hemat & Tanpa Beban Beli</span>
                </h1>

                <p class="hero-description">
                    Nikmati kamera bioskop, drone 4K, tenda camping ultralight, gadget flagship hingga kendaraan idaman. <strong>100% Terverifikasi e-KTP</strong>, jaminan bebas penipuan, dan kalkulator harga instan transparan.
                </p>

                <!-- Hero CTAs -->
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <a href="{{ route('catalog') }}" class="btn-gradient-primary mr-3 mb-2">
                        <i class="fas fa-compass mr-2"></i> Jelajahi Katalog Sewa
                    </a>
                    <a href="#how-it-works" class="btn-glass-secondary mb-2">
                        <i class="fas fa-play-circle mr-2 text-info"></i> Pelajari Cara Kerja
                    </a>
                </div>

                <!-- Trust Metrics -->
                <div class="hero-stats-banner">
                    <div class="hero-stat-item">
                        <div class="hero-stat-value text-gradient-cyan">{{ $totalItemsCount }}+</div>
                        <div class="hero-stat-label">Unit Siap Sewa</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-value text-warning">4.9 <small style="font-size: 0.9rem;">★</small></div>
                        <div class="hero-stat-label">Rating Kepuasan</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-value text-success">100%</div>
                        <div class="hero-stat-label">e-KTP Verified Safe</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-value text-info">&lt; 5 Menit</div>
                        <div class="hero-stat-label">Konfirmasi Booking</div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual Showcase -->
            <div class="col-lg-5 d-none d-lg-block">
                <div class="hero-visual-card">
                    <!-- Main Showcase Image -->
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=800&auto=format&fit=crop&q=80" 
                         alt="Sony Mirrorless Camera Rental" 
                         class="hero-img-main">

                    <!-- Floating Card Top Left: Live Rental Activity -->
                    <div class="hero-float-card-1">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                            <i class="fas fa-check" style="font-size: 0.85rem;"></i>
                        </div>
                        <div>
                            <div class="text-white font-weight-bold text-xs" style="line-height: 1.2;">Baru Saja Disewa!</div>
                            <small class="text-light text-xs" style="opacity: 0.8;">Sony Alpha A7 III • 3 Hari</small>
                        </div>
                    </div>

                    <!-- Floating Card Bottom Right: Verified Guarantee -->
                    <div class="hero-float-card-2">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; flex-shrink: 0;">
                            <i class="fas fa-shield-alt" style="font-size: 0.95rem;"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold text-dark text-xs" style="line-height: 1.2;">U.N.O Safe Escrow</div>
                            <small class="text-muted text-xs">Jaminan Transaksi Aman & Terlindungi</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- Floating Search & Filter Bar -->
<section class="container position-relative mb-5" style="z-index: 30;">
    <div class="search-floating-card">
        <form action="{{ route('catalog') }}" method="GET" class="row align-items-center">
            
            <!-- Input 1: Kata Kunci -->
            <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                <div class="search-input-group">
                    <span class="search-input-label">
                        <i class="fas fa-search mr-1 text-primary"></i> Kata Kunci Barang
                    </span>
                    <input type="text" name="q" class="search-input-field" placeholder="Sony A7, Drone DJI, Tenda Dome..." value="{{ request('q') }}">
                </div>
            </div>

            <!-- Input 2: Kategori Dropdown -->
            <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                <div class="search-input-group">
                    <span class="search-input-label">
                        <i class="fas fa-tags mr-1 text-primary"></i> Kategori Barang
                    </span>
                    <select name="category" class="search-input-field bg-transparent" style="cursor: pointer;">
                        <option value="">Semua Kategori ({{ $categories->sum('items_count') }})</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->items_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Input 3: Lokasi / Kota -->
            <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                <div class="search-input-group">
                    <span class="search-input-label">
                        <i class="fas fa-map-marker-alt mr-1 text-danger"></i> Wilayah / Kota
                    </span>
                    <input type="text" name="location" class="search-input-field" placeholder="Jakarta, Bandung, Bali..." value="{{ request('location') }}">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-lg-2 col-md-6 text-center text-lg-right">
                <button type="submit" class="btn btn-primary btn-block font-weight-bold py-3 shadow-sm" style="border-radius: 14px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; font-size: 1rem;">
                    <i class="fas fa-search mr-1"></i> Cari Sewa
                </button>
            </div>
        </form>

        <!-- Quick Trending Keywords -->
        <div class="d-flex align-items-center flex-wrap mt-3 pt-2 border-top">
            <span class="text-xs font-weight-bold text-muted text-uppercase mr-2">🔥 Tren Pencarian:</span>
            <a href="{{ route('catalog', ['q' => 'Sony']) }}" class="trending-search-pill">Sony Alpha</a>
            <a href="{{ route('catalog', ['q' => 'DJI']) }}" class="trending-search-pill">DJI Mini Drone</a>
            <a href="{{ route('catalog', ['q' => 'Tenda']) }}" class="trending-search-pill">Tenda Dome Eiger</a>
            <a href="{{ route('catalog', ['q' => 'Espresso']) }}" class="trending-search-pill">Mesin Kopi DeLonghi</a>
            <a href="{{ route('catalog', ['q' => 'Bosch']) }}" class="trending-search-pill">Bor Listrik Bosch</a>
        </div>
    </div>
</section>

<!-- Section: Categories Grid -->
<section id="categories" class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag-badge">
                <i class="fas fa-th-large mr-1"></i> KATEGORI PILIHAN
            </span>
            <h2 class="section-title">Temukan Kebutuhanmu Sesuai Kategori</h2>
            <p class="section-subtitle">
                Dari hobi fotografi, petualangan alam liar, proyek kerja kantoran hingga otomotif, semuanya siap kamu sewa kapan saja.
            </p>
        </div>

        <div class="row">
            @php
                $catIcons = [
                    'Camping & Outdoor' => ['icon' => 'fa-campground', 'style' => 'cat-bg-emerald'],
                    'Electronics' => ['icon' => 'fa-camera-retro', 'style' => 'cat-bg-blue'],
                    'Fashion & Accessories' => ['icon' => 'fa-vest-patches', 'style' => 'cat-bg-purple'],
                    'Home & Living' => ['icon' => 'fa-couch', 'style' => 'cat-bg-amber'],
                    'Tools & Equipment' => ['icon' => 'fa-tools', 'style' => 'cat-bg-rose'],
                ];
            @endphp

            @foreach($categories as $category)
                @php
                    $conf = $catIcons[$category->name] ?? ['icon' => 'fa-box', 'style' => 'cat-bg-cyan'];
                @endphp
                <div class="col-lg-2 col-md-4 col-6 mb-4">
                    <a href="{{ route('catalog', ['category' => $category->id]) }}" class="category-card-modern">
                        <div class="category-icon-box {{ $conf['style'] }}">
                            <i class="fas {{ $conf['icon'] }}"></i>
                        </div>
                        <div class="category-card-title text-truncate w-100" title="{{ $category->name }}">
                            {{ $category->name }}
                        </div>
                        <span class="category-unit-count mt-auto">
                            {{ $category->items_count }} Unit Aktif
                        </span>
                    </a>
                </div>
            @endforeach

            <!-- Explore All Category Pill -->
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <a href="{{ route('catalog') }}" class="category-card-modern" style="border-style: dashed; border-color: #cbd5e1; background: #f8fafc;">
                    <div class="category-icon-box cat-bg-blue" style="background: rgba(2, 132, 199, 0.08);">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                    <div class="category-card-title">Semua Katalog</div>
                    <span class="category-unit-count text-primary mt-auto">
                        Lihat {{ $totalItemsCount }} Unit
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Section: Featured & Trending Rental Items -->
<section id="featured-rentals" class="py-5" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);">
    <div class="container py-4">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div>
                <span class="section-tag-badge">
                    <i class="fas fa-fire mr-1 text-danger"></i> PALING DIMINATI MINGGU INI
                </span>
                <h2 class="section-title mb-1">Unit Sewa Terpopuler & Rekomendasi</h2>
                <p class="text-muted mb-0">Peralatan berkualitas dengan rating tertinggi, siap disewa hari ini tanpa deposit besar.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary font-weight-bold px-4 py-2" style="border-radius: 12px;">
                    Lihat Semua Katalog <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Product Grid (8 Featured Items) -->
        <div class="row">
            @forelse($featuredItems as $item)
                @php
                    $condMap = [
                        'new' => 'Baru',
                        'like_new' => 'Like New',
                        'good' => 'Bagus',
                        'fair' => 'Layak Pakai'
                    ];
                @endphp
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="product-rental-card">
                        
                        <!-- Product Image -->
                        <div class="product-img-wrapper">
                            <a href="{{ route('items.show', $item->id) }}" class="d-block w-100 h-100">
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy">
                            </a>
                            <span class="badge-cond-pill">{{ $condMap[$item->condition] ?? 'Normal' }}</span>
                            <span class="badge-cat-pill">{{ $item->category->name }}</span>
                        </div>

                        <!-- Product Content -->
                        <div class="product-card-body">
                            
                            <!-- Location & Rating -->
                            <div class="product-location-store justify-content-between">
                                <span class="text-truncate mr-2">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $item->location }}
                                </span>
                                <span class="text-warning font-weight-bold" style="font-size: 0.8rem;">
                                    <i class="fas fa-star"></i> {{ number_format($item->avg_rating ?? 5.0, 1) }}
                                </span>
                            </div>

                            <!-- Product Title -->
                            <a href="{{ route('items.show', $item->id) }}" class="product-title-link" title="{{ $item->name }}">
                                {{ $item->name }}
                            </a>

                            <!-- Store Owner -->
                            <div class="text-xs text-muted mb-2 d-flex align-items-center">
                                <i class="fas fa-store mr-1 text-primary"></i>
                                <span class="text-truncate">{{ $item->owner->owner_store_name ?? $item->owner->name }}</span>
                                @if($item->owner->is_verified_owner)
                                    <i class="fas fa-check-circle text-success ml-1" title="Mitra Terverifikasi KTP"></i>
                                @endif
                            </div>

                            <!-- Pricing & Instant Rent CTA -->
                            <div class="product-pricing-wrap">
                                <div>
                                    <div class="text-xs text-muted font-weight-bold">TARIF SEWA</div>
                                    <div class="product-price-amount">
                                        Rp {{ number_format($item->price_per_day, 0, ',', '.') }}
                                        <small>/ hari</small>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="btn-rent-instant"
                                        onclick="openRentModal('{{ $item->id }}', '{{ addslashes($item->name) }}', '{{ $item->price_per_day }}', '{{ $item->image_url }}', '{{ addslashes($item->location) }}')">
                                    <i class="fas fa-calendar-plus mr-1"></i> Sewa
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada unit sewa yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('catalog') }}" class="btn-gradient-primary px-5 py-3 shadow" style="font-size: 1.05rem;">
                <i class="fas fa-th-large mr-2"></i> Buka Seluruh Katalog ({{ $totalItemsCount }} Produk)
            </a>
        </div>
    </div>
</section>

<!-- Section: Value Proposition (Kenapa Memilih U.N.O?) -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag-badge">
                <i class="fas fa-award mr-1"></i> KEUNGGULAN U.N.O
            </span>
            <h2 class="section-title">Kenapa Menyewa Jauh Lebih Menguntungkan?</h2>
            <p class="section-subtitle">
                Filosofi <em>Use Not Own</em> memberikan kebebasan menikmati barang premium tanpa terbebani depresiasi harga, biaya perawatan, dan penyimpanan.
            </p>
        </div>

        <div class="row">
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="bento-card">
                    <div class="bento-icon-circle cat-bg-emerald">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Verifikasi e-KTP Ketat</h5>
                    <p class="text-muted text-sm mb-0">
                        Setiap akun mitra dan penyewa diaudit legalitas KTP resmi oleh Tim Keamanan U.N.O untuk memastikan ekosistem 100% bebas penipuan.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="bento-card">
                    <div class="bento-icon-circle cat-bg-blue">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Hemat Hingga 85%</h5>
                    <p class="text-muted text-sm mb-0">
                        Gunakan kamera bioskop puluhan juta atau tenda outdoor mahal hanya dengan membayar puluhan hingga ratusan ribu rupiah per hari.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="bento-card">
                    <div class="bento-icon-circle cat-bg-purple">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Kalkulator Transparan</h5>
                    <p class="text-muted text-sm mb-0">
                        Pilih rentang tanggal sewa fleksibel, biaya total dihitung secara real-time di layar tanpa ada pungutan biaya tak terduga.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="bento-card">
                    <div class="bento-icon-circle cat-bg-amber">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Cuan Dari Aset Pasif</h5>
                    <p class="text-muted text-sm mb-0">
                        Punya drone atau perkakas yang menganggur di lemari? Daftarkan tokumu dan nikmati jutaan rupiah passive income bulanan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section: How It Works -->
<section id="how-it-works" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag-badge">
                <i class="fas fa-route mr-1"></i> ALUR MUDAH & CEPAT
            </span>
            <h2 class="section-title">Bagaimana Cara Kerja U.N.O?</h2>
            <p class="section-subtitle">
                Hanya butuh 4 langkah mudah untuk mulai menikmati barang sewaan berkualitas langsung ke genggamanmu.
            </p>
        </div>

        <div class="row">
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-node-card">
                    <div class="step-badge-number">01</div>
                    <div class="text-primary mb-3" style="font-size: 2rem;">
                        <i class="fas fa-search-location"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Pilih Barang & Lokasi</h5>
                    <p class="text-muted text-sm mb-0">
                        Jelajahi katalog dan cari unit yang berada paling dekat dengan posisimu untuk kemudahan pengambilan.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-node-card">
                    <div class="step-badge-number">02</div>
                    <div class="text-primary mb-3" style="font-size: 2rem;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Tentukan Jadwal Sewa</h5>
                    <p class="text-muted text-sm mb-0">
                        Tentukan tanggal mulai dan selesai. Kalkulator kami akan menghitung total biaya sewa secara otomatis.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-node-card">
                    <div class="step-badge-number">03</div>
                    <div class="text-primary mb-3" style="font-size: 2rem;">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Terima & Gunakan Unit</h5>
                    <p class="text-muted text-sm mb-0">
                        Ambil unit di toko mitra terdekat atau gunakan kurir instan terpercaya. Perlengkapan langsung siap dipakai beraksi!
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-node-card">
                    <div class="step-badge-number">04</div>
                    <div class="text-primary mb-3" style="font-size: 2rem;">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-2">Kembalikan Mudah</h5>
                    <p class="text-muted text-sm mb-0">
                        Selesai masa sewa, kembalikan unit dalam kondisi baik. Berikan rating dan bagikan pengalaman serumu!
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Section: Official Verified Partners (Mitra Rental Resmi) -->
<section id="verified-partners" class="py-5 bg-white">
    <div class="container py-4">
        
        <div class="text-center mb-5">
            <span class="section-tag-badge" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.25); color: #059669;">
                <i class="fas fa-shield-check mr-1"></i> LEGALITAS & IDENTITAS TERVERIFIKASI
            </span>
            <h2 class="section-title">Mitra Rental Toko Resmi & Terverifikasi</h2>
            <p class="section-subtitle">
                Pemilik toko rental profesional yang telah melewati verifikasi e-KTP oleh Tim Keamanan U.N.O Pusat. Transaksi aman, barang terjamin asli, dan bebas penipuan.
            </p>
        </div>

        <div class="row">
            @forelse($verifiedPartners as $partner)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="store-partner-card">
                    
                    <div class="store-avatar-wrap">
                        <img src="{{ $partner->avatar_url }}" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($partner->name) }}&background=0284c7&color=fff';" 
                             class="store-avatar-img" 
                             alt="{{ $partner->owner_store_name }}">
                        <span class="store-verified-pill" title="Terverifikasi e-KTP">
                            <i class="fas fa-check"></i>
                        </span>
                    </div>

                    <h5 class="font-weight-bold text-dark mb-1 text-truncate" title="{{ $partner->owner_store_name }}">
                        {{ $partner->owner_store_name }}
                    </h5>
                    
                    <div class="text-muted text-xs mb-2">
                        <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $partner->store_city ?? 'Indonesia' }}
                    </div>

                    <div class="mb-3">
                        <span class="badge badge-light border text-success font-weight-bold text-xs px-2 py-1">
                            <i class="fas fa-shield-alt mr-1"></i> e-KTP Verified
                        </span>
                    </div>

                    <p class="text-muted text-xs mb-3 text-truncate" style="line-height: 1.5;">
                        {{ Str::limit($partner->store_description ?? 'Penyedia unit rental terpercaya di platform U.N.O.', 65) }}
                    </p>

                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="text-xs font-weight-bold text-muted">
                            <i class="fas fa-box text-primary mr-1"></i> {{ $partner->items_count }} Unit Aktif
                        </span>
                        <a href="{{ route('catalog', ['q' => $partner->owner_store_name]) }}" class="btn btn-outline-primary btn-sm font-weight-bold px-3" style="border-radius: 8px;">
                            Lihat Toko
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">
                Belum ada mitra toko terverifikasi.
            </div>
            @endforelse
        </div>

        <!-- Callout Banner to become a partner -->
        <div class="p-4 mt-4 rounded-xl border bg-light text-center" style="border-radius: 20px;">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="text-md-left mb-3 mb-md-0">
                    <h5 class="font-weight-bold text-dark mb-1">Punya Toko Rental atau Barang Menganggur di Rumah?</h5>
                    <p class="text-muted text-sm mb-0">Daftarkan tokomu sekarang, raih ribuan pelanggan baru dan tingkatkan omset sewa hingga berkali lipat.</p>
                </div>
                <div>
                    <a href="{{ route('profile.become-owner') }}" class="btn btn-warning font-weight-bold text-dark px-4 py-2 shadow-sm" style="border-radius: 12px;">
                        <i class="fas fa-store mr-1"></i> Gabung Jadi Mitra Owner Sekarang
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Section: Testimonials & Reviews -->
<section id="reviews" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag-badge">
                <i class="fas fa-star mr-1 text-warning"></i> ULASAN PELANGGAN NYATA
            </span>
            <h2 class="section-title">Apa Kata Mereka Tentang U.N.O?</h2>
            <p class="section-subtitle">
                Cerita kepuasan ribuan konten kreator, fotografer, pendaki gunung, dan keluarga yang telah menikmati kepraktisan sewa.
            </p>
        </div>

        <div class="row">
            @foreach($testimonials as $testi)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-modern-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $testi->user->profile_photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($testi->user->name) }}" class="rounded-circle mr-3" style="width: 48px; height: 48px; object-fit: cover;" alt="Avatar">
                        <div>
                            <div class="font-weight-bold text-dark">{{ $testi->user->name }}</div>
                            <small class="text-muted">Menyewa: <span class="text-primary font-weight-semibold">{{ Str::limit($testi->item->name, 22) }}</span></small>
                        </div>
                    </div>
                    <div class="text-warning mb-3">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $testi->rating ? '' : 'text-muted' }}"></i>
                        @endfor
                        <span class="text-xs text-muted font-weight-bold ml-1">({{ $testi->rating }}.0)</span>
                    </div>
                    <p class="text-dark text-sm mb-0 font-italic" style="line-height: 1.6;">
                        "{{ $testi->comment }}"
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section: FAQ (Frequently Asked Questions) -->
<section id="faq" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="section-tag-badge">
                <i class="fas fa-question-circle mr-1"></i> PERTANYAAN UMUM
            </span>
            <h2 class="section-title">Ada Pertanyaan? Kami Punya Jawabannya</h2>
            <p class="section-subtitle">
                Semua hal yang perlu kamu ketahui tentang sistem sewa, jaminan keamanan, dan cara menjadi mitra di U.N.O.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <!-- FAQ 1 -->
                <div class="faq-card">
                    <button class="faq-header-btn" type="button" data-toggle="collapse" data-target="#faq1">
                        <span>Apakah saya harus membayar deposit uang besar untuk menyewa?</span>
                        <i class="fas fa-chevron-down text-primary"></i>
                    </button>
                    <div id="faq1" class="collapse show">
                        <div class="faq-body-text">
                            Tidak! Di platform U.N.O, kami menggunakan verifikasi identitas e-KTP resmi sehingga penyewa terverifikasi tidak perlu menitipkan deposit uang puluhan juta rupiah. Cukup ikuti instruksi verifikasi akun dan patuhi syarat penyewaan toko mitra.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="faq-card">
                    <button class="faq-header-btn collapsed" type="button" data-toggle="collapse" data-target="#faq2">
                        <span>Bagaimana cara kerja pembayaran dan konfirmasi sewa?</span>
                        <i class="fas fa-chevron-down text-primary"></i>
                    </button>
                    <div id="faq2" class="collapse">
                        <div class="faq-body-text">
                            Setelah kamu memilih tanggal dan mengajukan booking, sistem akan membuat nomor pesanan (#BK-xxx). Pemilik toko rental akan langsung mengonfirmasi ketersediaan barang dan menghubungi nomor WhatsApp kamu untuk koordinasi pengiriman atau pengambilan unit.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="faq-card">
                    <button class="faq-header-btn collapsed" type="button" data-toggle="collapse" data-target="#faq3">
                        <span>Bagaimana jika unit mengalami kerusakan saat masa sewa?</span>
                        <i class="fas fa-chevron-down text-primary"></i>
                    </button>
                    <div id="faq3" class="collapse">
                        <div class="faq-body-text">
                            Sebelum serah terima barang, penyewa dan mitra owner wajib melakukan cek fisik bersama dan foto kondisi unit. Jika terjadi kerusakan di luar keausan wajar, penyewa bertanggung jawab sesuai dengan kesepakatan klaim perbaikan unit yang transparan.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="faq-card">
                    <button class="faq-header-btn collapsed" type="button" data-toggle="collapse" data-target="#faq4">
                        <span>Bagaimana cara mendaftarkan toko rental saya sebagai Mitra Owner?</span>
                        <i class="fas fa-chevron-down text-primary"></i>
                    </button>
                    <div id="faq4" class="collapse">
                        <div class="faq-body-text">
                            Sangat mudah! Buat akun baru atau masuk ke akun Anda, lalu klik menu "Daftar Jadi Mitra Rental". Lengkapi nama toko, alamat kota, dan unggah foto e-KTP Anda. Tim verifikator kami akan mengaktifkan toko Anda dalam waktu 1x24 jam.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Section: Radiant CTA Banner -->
<section class="container my-5">
    <div class="cta-radiant-banner">
        <div class="row align-items-center position-relative" style="z-index: 5;">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <span class="badge badge-info px-3 py-1 font-weight-bold mb-3" style="font-size: 0.8rem; background: rgba(56, 189, 248, 0.2); color: #7dd3fc; border: 1px solid rgba(56, 189, 248, 0.3);">
                    MULAI SEKARANG JUGA
                </span>
                <h2 class="font-weight-bold mb-3" style="font-size: 2.5rem; letter-spacing: -0.5px; line-height: 1.15;">
                    Siap Memulai Proyek Kreatif & Petualangan Barumu?
                </h2>
                <p class="text-light mb-0" style="font-size: 1.1rem; opacity: 0.9; max-width: 600px;">
                    Dapatkan akses ke ratusan perlengkapan terbaik hari ini atau mulai sewakan barangmu untuk menghasilkan passive income puluhan juta rupiah.
                </p>
            </div>
            <div class="col-lg-4 text-lg-right">
                <a href="{{ route('catalog') }}" class="btn btn-light btn-lg font-weight-bold text-primary px-4 py-3 shadow mb-2 mr-2" style="border-radius: 14px;">
                    <i class="fas fa-search mr-2"></i> Buka Katalog
                </a>
                <a href="{{ route('profile.become-owner') }}" class="btn btn-outline-light btn-lg font-weight-semibold px-4 py-3 mb-2" style="border-radius: 14px;">
                    <i class="fas fa-store mr-2"></i> Jadi Mitra Owner
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modern Ultra Footer -->
<footer class="footer-ultra">
    <div class="container">
        <div class="row mb-5">
            
            <!-- Col 1: Brand Info -->
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="brand-badge mr-2">
                        <img src="{{ asset('images/logo.png') }}" alt="U.N.O Logo" class="brand-logo-img">
                    </div>
                    <div>
                        <span class="font-weight-bold text-white font-heading" style="font-size: 1.3rem; letter-spacing: -0.5px; line-height: 1.1; display: block;">U.N.O</span>
                        <span class="d-block text-white-50 text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.4px; font-weight: 800;">USE NOT OWN</span>
                    </div>
                </div>
                <p class="text-muted text-sm mb-3" style="line-height: 1.6;">
                    Platform persewaan barang modern dengan prinsip <em>Use Not Own</em>. Berbagi pemanfaatan aset lebih hemat, ramah lingkungan, dan mendukung ekonomi sirkular Indonesia.
                </p>
                <div class="d-flex gap-2 mb-2">
                    <span class="badge badge-dark border border-secondary text-xs px-2 py-1 mr-1">
                        <i class="fas fa-lock text-success mr-1"></i> SSL 256-Bit Encrypted
                    </span>
                    <span class="badge badge-dark border border-secondary text-xs px-2 py-1">
                        <i class="fas fa-shield-alt text-info mr-1"></i> Anti-Fraud Protected
                    </span>
                </div>
                <div class="text-xs text-white-50">
                    Host Server IP: <strong class="text-info font-monospace">10.61.4.129</strong> • Port 8000
                </div>
            </div>

            <!-- Col 2: Kategori Populer -->
            <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                <h6 class="footer-heading">Kategori Populer</h6>
                <ul class="list-unstyled text-sm">
                    @foreach($categories->take(5) as $c)
                        <li><a href="{{ route('catalog', ['category' => $c->id]) }}" class="footer-link">{{ $c->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Col 3: Akses Cepat -->
            <div class="col-lg-3 col-6 mb-4 mb-lg-0">
                <h6 class="footer-heading">Akses Cepat</h6>
                <ul class="list-unstyled text-sm">
                    <li><a href="{{ route('catalog') }}" class="footer-link"><i class="fas fa-th-large mr-1"></i> Seluruh Katalog Sewa</a></li>
                    <li><a href="{{ route('register') }}?role=renter" class="footer-link"><i class="fas fa-user-plus mr-1"></i> Daftar Akun Penyewa</a></li>
                    <li><a href="{{ route('register') }}?role=owner" class="footer-link"><i class="fas fa-store mr-1"></i> Buka Toko Mitra Rental</a></li>
                    <li><a href="{{ route('login') }}" class="footer-link"><i class="fas fa-sign-in-alt mr-1"></i> Masuk ke Akun</a></li>
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <li><a href="{{ route('admin.dashboard') }}" class="footer-link text-info"><i class="fas fa-user-shield mr-1"></i> Admin Dashboard</a></li>
                    @endif
                </ul>
            </div>

            <!-- Col 4: Keamanan & Pembayaran -->
            <div class="col-lg-3">
                <h6 class="footer-heading">Layanan & Keamanan</h6>
                <p class="text-muted text-xs mb-3">
                    Transaksi penyewaan terjamin aman dengan audit identitas resmi e-KTP dan dukungan bantuan responsif.
                </p>
                <div class="p-3 rounded-lg border border-secondary mb-3" style="background: rgba(255,255,255,0.02);">
                    <div class="text-xs text-white font-weight-bold mb-1"><i class="fas fa-headset text-info mr-1"></i> Bantuan Pelanggan</div>
                    <div class="text-xs text-muted">Hubungi tim verifikasi & bantuan sewa 24/7 melalui pusat pesan profil.</div>
                </div>
            </div>

        </div>

        <div class="pt-4 border-top border-secondary d-flex flex-column flex-md-row justify-content-between align-items-center text-xs text-muted">
            <div class="mb-2 mb-md-0">
                &copy; {{ date('Y') }} <strong>U.N.O (USE NOT OWN)</strong>. Seluruh Hak Cipta Dilindungi.
            </div>
            <div>
                Dibangun dengan standar performa modern &bull; Laravel 12 &bull; Bootstrap 4.6 &bull; REST API
            </div>
        </div>
    </div>
</footer>

<!-- Modal Rental Calculator & Instant Booking (AJAX) -->
<div class="modal fade" id="modalRentalBooking" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">
            <div class="modal-header modal-rent-header p-4">
                <div>
                    <span class="badge badge-light text-primary font-weight-bold text-xs text-uppercase mb-1">Pemesanan Sewa Cepat</span>
                    <h5 class="modal-title font-weight-bold mb-0 font-heading" id="rentItemName">Nama Barang</h5>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.9;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRentBooking" onsubmit="submitRentalBooking(event)">
                <div class="modal-body p-4">
                    <input type="hidden" id="rentItemId" name="item_id">
                    
                    <!-- Item preview mini bar -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-lg border">
                        <img id="rentItemImg" src="" class="rounded-lg mr-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;" alt="item">
                        <div>
                            <div class="text-xs text-muted" id="rentItemLoc">Lokasi</div>
                            <div class="font-weight-bold text-primary font-heading" style="font-size: 1.2rem;">
                                Rp <span id="rentItemPriceText">0</span> <small class="text-muted">/ hari</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 form-group">
                            <label class="font-weight-semibold text-xs text-muted text-uppercase">Mulai Sewa <span class="text-danger">*</span></label>
                            <input type="date" id="rentStartDate" name="start_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onchange="recalculateRentalPrice()" required style="border-radius: 10px;">
                        </div>
                        <div class="col-6 form-group">
                            <label class="font-weight-semibold text-xs text-muted text-uppercase">Selesai Sewa <span class="text-danger">*</span></label>
                            <input type="date" id="rentEndDate" name="end_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d', strtotime('+2 days')) }}" onchange="recalculateRentalPrice()" required style="border-radius: 10px;">
                        </div>
                    </div>

                    @auth
                    <div class="p-3 mb-3 bg-light rounded-lg border">
                        <div class="d-flex align-items-center mb-1">
                            <img src="{{ Auth::user()->profile_photo ? (str_starts_with(Auth::user()->profile_photo, 'http') ? Auth::user()->profile_photo : asset('storage/'.Auth::user()->profile_photo)) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0284c7&color=fff' }}" 
                                 class="rounded-circle mr-2" style="width: 32px; height: 32px; object-fit: cover;" alt="avatar">
                            <div>
                                <span class="text-xs text-muted">Menyewa sebagai:</span>
                                <div class="font-weight-bold text-dark text-xs">{{ Auth::user()->name }}</div>
                            </div>
                            <span class="badge badge-success ml-auto text-xs"><i class="fas fa-check-circle mr-1"></i> Terverifikasi</span>
                        </div>
                        <input type="hidden" name="renter_name" value="{{ Auth::user()->name }}">
                        @if(Auth::user()->phone)
                            <div class="text-xs text-muted mt-1">
                                <i class="fab fa-whatsapp text-success mr-1"></i> WhatsApp: <span class="font-weight-semibold text-dark">{{ Auth::user()->phone }}</span>
                            </div>
                            <input type="hidden" name="renter_phone" value="{{ Auth::user()->phone }}">
                        @else
                            <div class="form-group mb-0 mt-2">
                                <label class="font-weight-semibold text-xs text-muted text-uppercase">No. WhatsApp Aktif <span class="text-danger">*</span></label>
                                <input type="text" name="renter_phone" class="form-control form-control-sm" placeholder="08123456789" required style="border-radius: 8px;">
                            </div>
                        @endif
                    </div>
                    @else
                    <div class="form-group">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase">Nama Lengkap Anda <span class="text-danger">*</span></label>
                        <input type="text" name="renter_name" class="form-control" placeholder="Nama Anda" required style="border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase">No. WhatsApp Aktif <span class="text-danger">*</span></label>
                        <input type="text" name="renter_phone" class="form-control" placeholder="08123456789" required style="border-radius: 10px;">
                    </div>
                    @endauth

                    <div class="form-group">
                        <label class="font-weight-semibold text-xs text-muted text-uppercase">Catatan / Keperluan Sewa</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Disewa untuk keperluan syuting video di Bandung..." style="border-radius: 10px;"></textarea>
                    </div>

                    <!-- Live Price Calculator Box -->
                    <div class="price-summary-box mb-3">
                        <div class="d-flex justify-content-between mb-1 text-sm">
                            <span class="text-muted">Durasi Sewa:</span>
                            <span class="font-weight-bold text-dark"><span id="calcTotalDays">3</span> Hari</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-sm">
                            <span class="text-muted">Tarif Harian:</span>
                            <span class="font-weight-bold text-dark">Rp <span id="calcDailyRate">0</span></span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold text-dark font-heading">ESTIMASI TOTAL BIAYA:</span>
                            <span class="font-weight-bold text-primary font-heading" style="font-size: 1.35rem;">
                                Rp <span id="calcTotalPrice">0</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer p-3 bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 10px;">Batal</button>
                    <button type="submit" id="btnSubmitRent" class="btn btn-primary font-weight-bold px-4 py-2" style="background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); border: none; border-radius: 10px;">
                        <i class="fas fa-check-circle mr-1"></i> Konfirmasi Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let currentItemPrice = 0;

    function openRentModal(id, name, price, img, loc) {
        currentItemPrice = price;
        document.getElementById('rentItemId').value = id;
        document.getElementById('rentItemName').innerText = name;
        document.getElementById('rentItemPriceText').innerText = Number(price).toLocaleString('id-ID');
        document.getElementById('rentItemImg').src = img;
        document.getElementById('rentItemLoc').innerText = loc;
        document.getElementById('calcDailyRate').innerText = Number(price).toLocaleString('id-ID');
        
        recalculateRentalPrice();
        $('#modalRentalBooking').modal('show');
    }

    function recalculateRentalPrice() {
        let start = new Date(document.getElementById('rentStartDate').value);
        let end = new Date(document.getElementById('rentEndDate').value);
        
        let diffTime = end - start;
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        if (diffDays < 1) diffDays = 1;

        let total = diffDays * currentItemPrice;

        document.getElementById('calcTotalDays').innerText = diffDays;
        document.getElementById('calcTotalPrice').innerText = Number(total).toLocaleString('id-ID');
    }

    function submitRentalBooking(e) {
        e.preventDefault();
        let btn = document.getElementById('btnSubmitRent');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...';

        let form = document.getElementById('formRentBooking');
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('book.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(res) {
                $('#modalRentalBooking').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Booking Berhasil Diajukan!',
                    html: `Pesanan <b>#BK-${res.booking_id}</b> telah kami terima.<br>Total estimasi: <b>Rp ${Number(res.total_price).toLocaleString('id-ID')}</b> (${res.total_days} hari).<br>Tim rental akan segera menghubungi nomor Anda.`,
                    confirmButtonText: 'Mantap!',
                    confirmButtonColor: '#0284c7'
                });
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi Booking';
            },
            error: function(err) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Konfirmasi Booking';
                let msg = 'Gagal mengajukan booking. Periksa kembali form Anda.';
                if (err.responseJSON) {
                    if (err.responseJSON.errors) {
                        let errList = Object.values(err.responseJSON.errors).flat();
                        msg = errList.join('<br>');
                    } else if (err.responseJSON.message) {
                        msg = err.responseJSON.message;
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Mengajukan Booking',
                    html: msg,
                    confirmButtonColor: '#0284c7'
                });
            }
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId.length > 1) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
</script>

</body>
</html>
