<style>
    /* ===== FOND GLOBAL SOMBRE ===== */
    /* Triple classe pour spécificité maximale + background-color direct */
    .fi-body.fi-body.fi-body,
    html body.fi-body,
    html body.fi-body.fi-panel-admin,
    html body.fi-body.fi-panel-admin .fi-app,
    html body.fi-body.fi-panel-admin .fi-app .fi-main,
    html body.fi-body.fi-panel-admin .fi-app .fi-main-ctn {
        background-color: #0a0a1a !important;
        background-image: none !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* ===== TOPBAR NAV (bg-white est sur le <nav> enfant) ===== */
    .fi-body .fi-topbar nav,
    .fi-body .fi-topbar > nav,
    html body.fi-body .fi-topbar nav {
        background-color: rgba(10, 10, 26, 0.85) !important;
        background-image: none !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: none !important;
        ring-color: transparent !important;
    }

    /* ===== TABLE CONTAINER (fi-ta-ctn = le vrai fond blanc) ===== */
    html body.fi-body .fi-ta-ctn {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(108, 92, 231, 0.03)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
    }

    /* ===== TABLE CONTENT ===== */
    html body.fi-body .fi-ta-content,
    html body.fi-body .fi-ta-content > div {
        background-color: transparent !important;
        background-image: none !important;
    }

    /* Séparateurs entre lignes */
    html body.fi-body .fi-ta-ctn > *,
    html body.fi-body .fi-ta-header-ctn {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* ===== LIGNES TABLE (bg-white hardcodé sur .fi-ta-record) ===== */
    html body.fi-body .fi-ta-record,
    html body.fi-body tr.fi-ta-record {
        background-color: rgba(255, 255, 255, 0.02) !important;
        background-image: none !important;
    }

    html body.fi-body .fi-ta-record:hover,
    html body.fi-body tr.fi-ta-record:hover {
        background-color: rgba(108, 92, 231, 0.08) !important;
        background-image: none !important;
    }

    /* ===== EMPTY STATE (fond blanc quand table vide) ===== */
    html body.fi-body .fi-ta-empty-state,
    html body.fi-body .fi-ta .fi-empty-state {
        background-color: transparent !important;
        background-image: none !important;
        color: rgba(255, 255, 255, 0.6) !important;
    }

    /* ===== WRAPPER SECTION / PAGE ===== */
    html body.fi-body .fi-page,
    html body.fi-body .fi-main > div > div {
        background-color: transparent !important;
        background-image: none !important;
    }

    /* ===== PAGE LOGIN ===== */
    .fi-body.fi-body .fi-simple-layout,
    .fi-body.fi-body .fi-simple-main,
    .fi-body.fi-body .fi-simple-page,
    .fi-body.fi-body .fi-simple-main-ctn {
        background-color: #0a0a1a !important;
        background-image: none !important;
    }

    /* Card login */
    .fi-body.fi-body .fi-simple-main {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.08), rgba(253, 121, 168, 0.05)) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
    }

    /* Titre login */
    .fi-body.fi-body .fi-simple-header-heading {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        color: transparent !important;
    }

    /* ===== SIDEBAR ===== */
    .fi-body.fi-body .fi-sidebar,
    .fi-body.fi-body .fi-main-sidebar,
    .fi-body.fi-body .fi-sidebar-nav {
        background-color: rgba(10, 10, 26, 0.95) !important;
        background-image: none !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Sidebar header gradient */
    .fi-body.fi-body .fi-sidebar-header {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.3), rgba(253, 121, 168, 0.15)) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 12px !important;
        margin: 8px !important;
        margin-bottom: 8px !important;
        padding: 16px !important;
    }

    /* ===== LOGO GRADIENT ===== */
    .fi-body.fi-body .fi-logo {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        color: transparent !important;
        font-weight: 800 !important;
        font-size: 1.25rem !important;
    }

    .fi-body.fi-body .fi-logo img {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4) !important;
        padding: 8px !important;
    }

    /* ===== SIDEBAR ITEMS ===== */
    /* Le fond est sur le <a>.fi-sidebar-item-button, pas sur le <li> */
    html body.fi-body .fi-sidebar-item .fi-sidebar-item-button {
        background-color: transparent !important;
        background-image: none !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
        border: 1px solid transparent !important;
        position: relative !important;
        overflow: hidden !important;
    }

    /* Hover */
    html body.fi-body .fi-sidebar-item .fi-sidebar-item-button:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
        background-color: transparent !important;
        border-color: rgba(108, 92, 231, 0.2) !important;
    }

    /* Active — bg-gray-100 / dark:bg-white/5 est sur .fi-sidebar-item-button */
    html body.fi-body .fi-sidebar-item.fi-active .fi-sidebar-item-button,
    html body.fi-body .fi-sidebar-item.fi-sidebar-item-active .fi-sidebar-item-button {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.3), rgba(253, 121, 168, 0.15)) !important;
        background-color: transparent !important;
        border-color: rgba(108, 92, 231, 0.4) !important;
    }

    /* Barre gauche active */
    html body.fi-body .fi-sidebar-item.fi-active .fi-sidebar-item-button::before,
    html body.fi-body .fi-sidebar-item.fi-sidebar-item-active .fi-sidebar-item-button::before {
        content: '' !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 3px !important;
        height: 100% !important;
        background: linear-gradient(180deg, #6c5ce7, #fd79a8) !important;
        border-radius: 0 3px 3px 0 !important;
    }

    /* Labels et icônes */
    html body.fi-body .fi-sidebar-item .fi-sidebar-item-label {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    html body.fi-body .fi-sidebar-item .fi-sidebar-item-icon {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    html body.fi-body .fi-sidebar-item.fi-active .fi-sidebar-item-label,
    html body.fi-body .fi-sidebar-item.fi-sidebar-item-active .fi-sidebar-item-label,
    html body.fi-body .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    html body.fi-body .fi-sidebar-item.fi-sidebar-item-active .fi-sidebar-item-icon {
        color: #ffffff !important;
    }

    .fi-body.fi-body .fi-sidebar-group-label {
        color: rgba(255, 255, 255, 0.4) !important;
        font-size: 10px !important;
        text-transform: uppercase !important;
        letter-spacing: 1.5px !important;
    }

    /* ===== TOPBAR ===== */
    .fi-body.fi-body .fi-topbar,
    .fi-body.fi-body .fi-topbar-container,
    .fi-body.fi-body .fi-global-search {
        background-color: rgba(10, 10, 26, 0.8) !important;
        background-image: none !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: none !important;
    }

    /* Search input */
    .fi-body.fi-body .fi-input-wrp {
        background-color: rgba(255, 255, 255, 0.06) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-input-wrp:focus-within {
        border-color: rgba(108, 92, 231, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(253, 121, 168, 0.05)) !important;
    }

    .fi-body.fi-body .fi-input {
        background: transparent !important;
        color: #ffffff !important;
    }

    .fi-body.fi-body .fi-input::placeholder {
        color: rgba(255, 255, 255, 0.4) !important;
    }

    /* User avatar */
    .fi-body.fi-body .fi-avatar {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        border-radius: 12px !important;
    }

    /* ===== CARDS / WIDGETS ===== */
    .fi-body.fi-body .fi-wi-widget > div,
    .fi-body.fi-body .fi-wi-widget > section,
    .fi-body.fi-body .fi-section > div,
    .fi-body.fi-body .fi-fo-section > div,
    .fi-body.fi-body .fi-empty-state,
    .fi-body.fi-body .fi-ta-content {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(108, 92, 231, 0.03)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-wi-widget > div:hover,
    .fi-body.fi-body .fi-section > div:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(108, 92, 231, 0.06)) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
    }

    /* ===== TABLE ===== */
    .fi-body.fi-body .fi-ta-header,
    .fi-body.fi-body .fi-ta-header-cell {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(253, 121, 168, 0.05)) !important;
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    }

    .fi-body.fi-body .fi-ta-header th {
        color: rgba(255, 255, 255, 0.7) !important;
        font-weight: 600 !important;
    }

    .fi-body.fi-body .fi-ta-record,
    .fi-body.fi-body .fi-ta-row {
        background-color: rgba(255, 255, 255, 0.02) !important;
        background-image: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-ta-row:hover,
    .fi-body.fi-body .fi-ta-record:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.08), rgba(253, 121, 168, 0.05)) !important;
    }

    .fi-body.fi-body .fi-ta-record td {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* ===== FORM ===== */
    .fi-body.fi-body .fi-fo-field-wrp-label {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        color: transparent !important;
        font-weight: 600 !important;
    }

    .fi-body.fi-body .fi-fo-text-input > div,
    .fi-body.fi-body .fi-fo-select > div,
    .fi-body.fi-body .fi-fo-textarea > div {
        background-color: rgba(255, 255, 255, 0.06) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-fo-text-input > div:focus-within,
    .fi-body.fi-body .fi-fo-select > div:focus-within,
    .fi-body.fi-body .fi-fo-textarea > div:focus-within {
        border-color: rgba(108, 92, 231, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.08), rgba(253, 121, 168, 0.05)) !important;
    }

    .fi-body.fi-body .fi-fo-text-input input,
    .fi-body.fi-body .fi-fo-select select,
    .fi-body.fi-body .fi-fo-textarea textarea {
        background: transparent !important;
        color: #ffffff !important;
    }

    /* ===== BUTTONS SECONDARY ===== */
    .fi-body.fi-body .fi-btn-color-secondary,
    .fi-body.fi-body .fi-btn-color-gray {
        background-color: rgba(255, 255, 255, 0.06) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: rgba(255, 255, 255, 0.7) !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-btn-color-secondary:hover,
    .fi-body.fi-body .fi-btn-color-gray:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
        color: #ffffff !important;
    }

    /* ===== PAGINATION ===== */
    .fi-body.fi-body .fi-pagination-item {
        background-color: rgba(255, 255, 255, 0.06) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-pagination-item:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
    }

    .fi-body.fi-body .fi-pagination-item-active {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        background-color: transparent !important;
        color: #ffffff !important;
        border-color: transparent !important;
    }

    /* ===== DROPDOWNS ===== */
    .fi-body.fi-body .fi-dropdown-panel {
        background-color: rgba(20, 20, 40, 0.98) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(20px) !important;
    }

    .fi-body.fi-body .fi-dropdown-list-item {
        color: rgba(255, 255, 255, 0.7) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-dropdown-list-item:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
        color: #ffffff !important;
    }

    /* ===== TABS ===== */
    .fi-body.fi-body .fi-tabs-item {
        color: rgba(255, 255, 255, 0.7) !important;
        border-bottom: 2px solid transparent !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-tabs-item:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(253, 121, 168, 0.05)) !important;
        color: #ffffff !important;
    }

    .fi-body.fi-body .fi-tabs-item-active {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
        color: #ffffff !important;
        border-bottom: 2px solid #6c5ce7 !important;
    }

    /* ===== BADGES ===== */
    .fi-body.fi-body .fi-badge {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(253, 121, 168, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(108, 92, 231, 0.3) !important;
        color: #a29bfe !important;
        border-radius: 20px !important;
    }

    /* ===== MODALS ===== */
    .fi-body.fi-body .fi-modal-close-overlay {
        background-color: rgba(10, 10, 26, 0.8) !important;
        background-image: none !important;
        backdrop-filter: blur(8px) !important;
    }

    .fi-body.fi-body .fi-modal-window {
        background: linear-gradient(135deg, rgba(20, 20, 40, 0.98), rgba(108, 92, 231, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5) !important;
    }

    /* ===== NOTIFICATIONS ===== */
    .fi-body.fi-body .fi-no.fi-notification-success {
        background: linear-gradient(135deg, rgba(0, 184, 148, 0.2), rgba(0, 206, 201, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(0, 184, 148, 0.3) !important;
    }

    .fi-body.fi-body .fi-no.fi-notification-info {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(253, 121, 168, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(108, 92, 231, 0.3) !important;
    }

    .fi-body.fi-body .fi-no.fi-notification-warning {
        background: linear-gradient(135deg, rgba(243, 156, 18, 0.2), rgba(253, 203, 110, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(243, 156, 18, 0.3) !important;
    }

    /* ===== BREADCRUMBS ===== */
    .fi-body.fi-body .fi-breadcrumbs-item {
        color: rgba(255, 255, 255, 0.7) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-breadcrumbs-item:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(253, 121, 168, 0.05)) !important;
        color: #ffffff !important;
    }

    .fi-body.fi-body .fi-breadcrumbs-item-active {
        color: #a29bfe !important;
    }

    /* ===== SECTION HEADERS ===== */
    .fi-body.fi-body .fi-section-header {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.08), rgba(253, 121, 168, 0.05)) !important;
        background-color: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
    }

    .fi-body.fi-body .fi-section-header-heading,
    .fi-body.fi-body .fi-header-heading {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        color: transparent !important;
    }

    /* ===== FILTER BAR ===== */
    .fi-body.fi-body .fi-ta-filters,
    .fi-body.fi-body .fi-ta-filters-indicators {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.05), rgba(253, 121, 168, 0.03)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
    }

    /* ===== SCROLLBAR ===== */
    .fi-body.fi-body ::-webkit-scrollbar {
        width: 6px !important;
        height: 6px !important;
    }

    .fi-body.fi-body ::-webkit-scrollbar-track {
        background: transparent !important;
    }

    .fi-body.fi-body ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, rgba(108, 92, 231, 0.5), rgba(253, 121, 168, 0.3)) !important;
        border-radius: 3px !important;
    }

    /* ===== ICON BUTTONS ===== */
    .fi-body.fi-body .fi-icon-btn {
        background-color: rgba(255, 255, 255, 0.06) !important;
        background-image: none !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        color: rgba(255, 255, 255, 0.7) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-icon-btn:hover {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.15), rgba(253, 121, 168, 0.08)) !important;
        color: #ffffff !important;
        transform: translateY(-2px) !important;
    }

    /* ===== A — BOUTON PRIMARY ===== */
    .fi-body.fi-body .fi-btn-color-primary {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        background-color: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 20px rgba(108, 92, 231, 0.4) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-btn-color-primary:hover {
        box-shadow: 0 8px 30px rgba(108, 92, 231, 0.6) !important;
        transform: translateY(-2px) !important;
        opacity: 0.95 !important;
    }

    /* ===== B — BOUTON DANGER ===== */
    .fi-body.fi-body .fi-btn-color-danger {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.25), rgba(192, 57, 43, 0.15)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(231, 76, 60, 0.4) !important;
        color: #ff6b6b !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-btn-color-danger:hover {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.4), rgba(192, 57, 43, 0.25)) !important;
        border-color: rgba(231, 76, 60, 0.6) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 20px rgba(231, 76, 60, 0.3) !important;
    }

    /* ===== C — CHART WIDGETS ===== */
    /* Wrapper général chart */
    .fi-body.fi-body .fi-wi-chart,
    .fi-body.fi-body .fi-wi-chart > div,
    .fi-body.fi-body .fi-wi-chart > section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(108, 92, 231, 0.03)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
    }

    /* Header du chart (titre) */
    .fi-body.fi-body .fi-wi-chart-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding-bottom: 12px !important;
    }

    .fi-body.fi-body .fi-wi-chart-heading {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
    }

    /* Canvas chart : fond transparent pour laisser le glassmorphism passer */
    .fi-body.fi-body .fi-wi-chart canvas {
        background: transparent !important;
    }

    /* Stats overview widget — cartes individuelles */
    .fi-body.fi-body .fi-wi-stats-overview {
        background: transparent !important;
    }

    .fi-body.fi-body .fi-wi-stats-overview-stat {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.07), rgba(108, 92, 231, 0.04)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 14px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-wi-stats-overview-stat:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35) !important;
        border-color: rgba(108, 92, 231, 0.3) !important;
    }

    .fi-body.fi-body .fi-wi-stats-overview-stat-label {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
    }

    .fi-body.fi-body .fi-wi-stats-overview-stat-value {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        font-weight: 800 !important;
    }

    .fi-body.fi-body .fi-wi-stats-overview-stat-description {
        color: rgba(255, 255, 255, 0.5) !important;
        font-size: 12px !important;
    }

    /* Barre de couleur latérale des stats overview */
    .fi-body.fi-body .fi-wi-stats-overview-stat-chart {
        opacity: 0.7 !important;
    }

    /* ===== D — CHECKBOX / RADIO / TOGGLE ===== */
    /* Checkbox */
    .fi-body.fi-body .fi-fo-checkbox input[type="checkbox"],
    .fi-body.fi-body input[type="checkbox"] {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        border-radius: 5px !important;
        accent-color: #6c5ce7 !important;
        cursor: pointer !important;
    }

    .fi-body.fi-body .fi-fo-checkbox input[type="checkbox"]:checked,
    .fi-body.fi-body input[type="checkbox"]:checked {
        background-color: #6c5ce7 !important;
        border-color: #6c5ce7 !important;
    }

    /* Radio */
    .fi-body.fi-body input[type="radio"] {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
        accent-color: #6c5ce7 !important;
    }

    /* Toggle (Filament's fi-fo-toggle) */
    .fi-body.fi-body .fi-fo-toggle button[role="switch"] {
        background-color: rgba(255, 255, 255, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-fo-toggle button[role="switch"][aria-checked="true"] {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        border-color: transparent !important;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4) !important;
    }

    /* Label checkbox/radio */
    .fi-body.fi-body .fi-fo-checkbox .fi-fo-checkbox-label,
    .fi-body.fi-body .fi-fo-radio .fi-fo-radio-option-label {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    /* ===== E — DATE / TIME PICKER ===== */
    /* Champ date (input) */
    .fi-body.fi-body .fi-fo-date-time-picker > div,
    .fi-body.fi-body .fi-fo-date-picker > div {
        background-color: rgba(255, 255, 255, 0.06) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-fo-date-time-picker > div:focus-within,
    .fi-body.fi-body .fi-fo-date-picker > div:focus-within {
        border-color: rgba(108, 92, 231, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2) !important;
    }

    .fi-body.fi-body .fi-fo-date-time-picker input,
    .fi-body.fi-body .fi-fo-date-picker input {
        background: transparent !important;
        color: #ffffff !important;
    }

    /* Panneau calendrier déroulant */
    .fi-body.fi-body [data-panel],
    .fi-body.fi-body .fi-date-picker-panel {
        background: rgba(18, 18, 38, 0.98) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 14px !important;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5) !important;
        backdrop-filter: blur(20px) !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Jours du calendrier */
    .fi-body.fi-body .fi-date-picker-day {
        background: transparent !important;
        color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
    }

    .fi-body.fi-body .fi-date-picker-day:hover {
        background: rgba(108, 92, 231, 0.2) !important;
        color: #ffffff !important;
    }

    /* Jour actif / sélectionné */
    .fi-body.fi-body .fi-date-picker-day-selected,
    .fi-body.fi-body .fi-date-picker-day[aria-selected="true"] {
        background: linear-gradient(135deg, #6c5ce7, #fd79a8) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4) !important;
    }

    /* Aujourd'hui */
    .fi-body.fi-body .fi-date-picker-day-today {
        border: 1px solid rgba(108, 92, 231, 0.5) !important;
        color: #a29bfe !important;
    }

    /* ===== F — FILE UPLOAD ===== */
    .fi-body.fi-body .fi-fo-file-upload {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 2px dashed rgba(108, 92, 231, 0.35) !important;
        border-radius: 14px !important;
        color: rgba(255, 255, 255, 0.6) !important;
        transition: all 0.3s ease !important;
    }

    .fi-body.fi-body .fi-fo-file-upload:hover {
        background: rgba(108, 92, 231, 0.08) !important;
        border-color: rgba(108, 92, 231, 0.6) !important;
        color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1) !important;
    }

    .fi-body.fi-body .fi-fo-file-upload-item {
        background: rgba(255, 255, 255, 0.06) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 10px !important;
        color: rgba(255, 255, 255, 0.8) !important;
    }

    /* ===== G — RICH EDITOR TIPTAP ===== */
    /* Toolbar */
    .fi-body.fi-body .tiptap-editor .ProseMirror-toolbar,
    .fi-body.fi-body [class*="tiptap"] .toolbar,
    .fi-body.fi-body .fi-fo-rich-editor [class*="toolbar"] {
        background: rgba(255, 255, 255, 0.05) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 10px 10px 0 0 !important;
    }

    /* Boutons toolbar */
    .fi-body.fi-body .fi-fo-rich-editor button,
    .fi-body.fi-body [class*="tiptap"] button {
        background: transparent !important;
        color: rgba(255, 255, 255, 0.6) !important;
        border: none !important;
        border-radius: 6px !important;
        transition: all 0.2s ease !important;
    }

    .fi-body.fi-body .fi-fo-rich-editor button:hover,
    .fi-body.fi-body [class*="tiptap"] button:hover {
        background: rgba(108, 92, 231, 0.2) !important;
        color: #ffffff !important;
    }

    .fi-body.fi-body .fi-fo-rich-editor button.is-active,
    .fi-body.fi-body [class*="tiptap"] button.is-active {
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.3), rgba(253, 121, 168, 0.2)) !important;
        color: #ffffff !important;
    }

    /* Zone de texte ProseMirror */
    .fi-body.fi-body .fi-fo-rich-editor .ProseMirror,
    .fi-body.fi-body [class*="tiptap"] .ProseMirror {
        background: rgba(255, 255, 255, 0.03) !important;
        color: rgba(255, 255, 255, 0.9) !important;
        border-radius: 0 0 10px 10px !important;
        caret-color: #a29bfe !important;
    }

    /* Wrapper global éditeur */
    .fi-body.fi-body .fi-fo-rich-editor,
    .fi-body.fi-body [class*="tiptap-editor"] {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        transition: border-color 0.3s ease !important;
    }

    .fi-body.fi-body .fi-fo-rich-editor:focus-within,
    .fi-body.fi-body [class*="tiptap-editor"]:focus-within {
        border-color: rgba(108, 92, 231, 0.5) !important;
        box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.15) !important;
    }

    /* ===== H — MODAL HEADER / FOOTER ===== */
    .fi-body.fi-body .fi-modal-header,
    .fi-body.fi-body .fi-modal-window > div:first-child {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 20px 24px !important;
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.08), rgba(253, 121, 168, 0.04)) !important;
        border-radius: 16px 16px 0 0 !important;
    }

    .fi-body.fi-body .fi-modal-heading {
        background: linear-gradient(135deg, #a29bfe, #fd79a8) !important;
        -webkit-background-clip: text !important;
        background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        font-weight: 700 !important;
        font-size: 1.1rem !important;
    }

    .fi-body.fi-body .fi-modal-footer,
    .fi-body.fi-body .fi-modal-window .fi-modal-footer-actions {
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        background: rgba(10, 10, 26, 0.5) !important;
        padding: 16px 24px !important;
        border-radius: 0 0 16px 16px !important;
        display: flex !important;
        gap: 10px !important;
        justify-content: flex-end !important;
    }

    /* Description modale */
    .fi-body.fi-body .fi-modal-description {
        color: rgba(255, 255, 255, 0.6) !important;
        font-size: 14px !important;
    }

    /* Contenu modale */
    .fi-body.fi-body .fi-modal-content {
        padding: 20px 24px !important;
    }

    /* ===== I — LOADING INDICATOR ===== */
    @keyframes motivSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes motivPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* Overlay wire:loading */
    .fi-body.fi-body [wire\:loading]:not([wire\:loading\.remove]) {
        opacity: 0.6 !important;
        transition: opacity 0.2s ease !important;
    }

    /* Spinner Filament */
    .fi-body.fi-body .fi-loading-indicator {
        color: #6c5ce7 !important;
        animation: motivSpin 0.8s linear infinite !important;
    }

    .fi-body.fi-body .fi-loading-indicator svg {
        color: #6c5ce7 !important;
    }

    /* Barre de progression globale (topbar loader) */
    .fi-body.fi-body [x-data*="progress"] .bg-primary-600,
    .fi-body.fi-body .fi-progress-bar {
        background: linear-gradient(90deg, #6c5ce7, #fd79a8) !important;
        box-shadow: 0 0 12px rgba(108, 92, 231, 0.5) !important;
    }

    /* Overlay pleine page livewire */
    .fi-body.fi-body .fi-overlay {
        background: rgba(10, 10, 26, 0.7) !important;
        backdrop-filter: blur(6px) !important;
        -webkit-backdrop-filter: blur(6px) !important;
    }

    /* Spinner bouton (dans les btn pendant loading) */
    .fi-body.fi-body .fi-btn svg.animate-spin {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* ===== J — NOTIFICATION DANGER ===== */
    .fi-body.fi-body .fi-no.fi-notification-danger {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.2), rgba(192, 57, 43, 0.1)) !important;
        background-color: transparent !important;
        border: 1px solid rgba(231, 76, 60, 0.35) !important;
    }

    .fi-body.fi-body .fi-no.fi-notification-danger .fi-no-icon {
        color: #ff6b6b !important;
    }

    .fi-body.fi-body .fi-no.fi-notification-danger .fi-no-title {
        color: #ff8e8e !important;
        font-weight: 700 !important;
    }

    .fi-body.fi-body .fi-no.fi-notification-danger .fi-no-body {
        color: rgba(255, 150, 150, 0.85) !important;
    }

    /* Notification container global */
    .fi-body.fi-body .fi-no {
        border-radius: 14px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4) !important;
    }

    .fi-body.fi-body .fi-no .fi-no-title {
        font-weight: 600 !important;
    }

    .fi-body.fi-body .fi-no .fi-no-body {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 13px !important;
    }
</style>
