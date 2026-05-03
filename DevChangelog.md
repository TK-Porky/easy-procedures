# Developer Changelog - Easy Procedures Upgrade

This document records the significant modifications and architectural upgrades performed on the Easy Procedures project.

## [2026-04-30] - Major Frontend & Backend Overhaul

### Frontend Modernization
- **CSS Framework Migration:** Replaced legacy Bootstrap 4 and "CoolAdmin" theme with **Tailwind CSS 3.4**.
- **Build Pipeline:** Implemented a modern frontend build process using Tailwind CLI and PostCSS. Added `npm run build` and `npm run watch` scripts.
- **UI Redesign:** Implemented a completely new, clean, and responsive design across the entire application.
- **Base Layouts:** Redesigned `default.php` and `auth_layout.php` with a modern sidebar-based architecture.
- **Interactivity:** Integrated **Alpine.js 3.15** for lightweight, framework-less interactivity (sidebar toggles, mobile menus, dropdowns, and modals).
- **CakePHP Helper Customization:** Configured `FormHelper` and `PaginatorHelper` with custom Tailwind CSS templates for consistent styling of all generated HTML controls.
- **View Migration:** Successfully migrated all core view modules:
    - Authentication (Login, Register, Forget Password, Verify).
    - Dashboard (Admin and User versions).
    - User Management (Index, Add/Modal).
    - Request Management (Index, tracking).
    - Procedure Selection (Grid view).
    - Supporting views (Home page, Error 404/500).

### Backend & API Upgrade
- **Hybrid Architecture:** Transitioned the backend to a hybrid **MVC + REST API** architecture.
- **RESTful API:** Introduced versioned API endpoints under the `/api/v1` namespace.
- **Authentication:**
    - Maintained session-based authentication for the web MVC frontend.
    - Implemented stateless **JWT (JSON Web Token)** authentication for the REST API using `firebase/php-jwt`.
- **API Controllers:** Created a dedicated API controller hierarchy:
    - `Api\AppController`: Base controller for all API versions, enforcing JSON responses and JWT auth.
    - `Api\V1\AppController`: Base controller for version 1 of the API.
    - `Api\V1\UsersController`: Handles JWT token generation (login).
    - `Api\V1\ProceduresController`, `Api\V1\RequestsController`, `Api\V1\RequirementsController`: RESTful resource endpoints.
- **Middleware:** Updated `Application.php` to handle dual-mode authentication (JWT vs Session) and conditional CSRF protection for API routes.

### Documentation
- **Swagger Integration:** Integrated **Swagger Bake** for automated OpenAPI documentation generation.
- **Interactive Docs:** Provided a professional, interactive API explorer accessible at the `/swagger` route.
- **Security Definitions:** Configured Swagger UI to support testing of JWT-protected endpoints via Bearer token authorization.
