# Developer Changelog - Easy Procedures Upgrade

This document records the significant modifications and architectural upgrades performed on the Easy Procedures project.

## [2026-05-21] - Admin Request Management Implementation

### Core Feature: Request Processing
- **Request Management Module:** Complete implementation of the **Request Management** section within the Admin Portal.
- **Business Workflow:** Established the end-to-end logic for processing user requests, including:
    - **Reviewing** submitted applications.
    - **Verifying** required documents.
    - **Updating** request status (Pending, Approved, Rejected).
- **Admin Interface:** Developed a comprehensive management interface (`/admin/requests/request`) featuring:
    - Sortable and filterable data tables with server-side pagination.
    - Detailed information modals for each request.
    - Status update functionality with email notifications.

### Backend Integration
- **Request Controller:** Created `RequestsController` with CRUD operations and advanced search capabilities.
- **Email Notifications:** Implemented email triggers for:
    - Request submission confirmation to the admin.
    - Request status updates (Approval/Rejection) to the client.

### UI/UX Enhancements
- **Dashboard Integration:** Enhanced the Admin Dashboard with "Pending Requests" statistics and quick access links.
- **Visual Feedback:** Implemented a robust status badge system (`badge-green`, `badge-yellow`, `badge-red`) for clear visual representation of request states.
- **Mobile Optimization:** Ensured the management interface is fully responsive and functional on mobile devices.

### Data & Logic
- **Sample Data:** Expanded seed data to include diverse request scenarios for comprehensive testing.
- **Cross-Reference Mapping:** Correctly mapped procedure-specific requirements to their respective procedures and document types.

## [2026-05-12] - Role-Based Architecture & Security Enforcement

### Architectural Isolation (Prefix Routing)
- **Portal Separation:** Fully implemented prefix routing to isolate `Admin`, `Agent`, and `Client` functionalities.
- **Controller Migration:** Successfully moved and namespaced core management modules to the `Admin` prefix:
    - `RequirementsController`
    - `RequirementproprietiesController`
    - `ProcedurerequirementsController`
- **Template Modernization:** Replaced legacy Bootstrap templates for the migrated modules with modern Tailwind CSS versions.

### Authentication & Authorization
- **Security Enforcement (RBAC):**
    - Restricted logged-in users from accessing the landing page (auto-redirect to respective dashboards).
    - Blocked access to login pages for authenticated users to prevent duplicate sessions.
    - Implemented strict role-based access control (RBAC) in `AppController` for all prefixed routes.
- **Auth Fixes:** Resolved infinite redirection loops on the home page and fixed default redirect paths for unauthenticated users.

### Bug Fixes & Refinement
- **Client Registration:**
    - Fixed field name mismatch (`nom/prenom` vs `surname/name`).
    - Relaxed validation for `phonenumber` and `id_role` during signup.
    - Added database-level constraint handling (default values for non-null fields).
- **Admin Portal:** Added missing "Pending" requests view and fixed sidebar navigation links.
- **Database Schema:** Increased `procedures.description` field length to 255 characters to support richer content.
- **Seeding:** Implemented a robust sample data seeding process for testing the end-to-end procedure flow.

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
