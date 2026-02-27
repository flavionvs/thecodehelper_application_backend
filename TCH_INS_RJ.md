# TCH_INS_RJ — The Code Helper: Project Documentation & Instructions

> **Last Updated:** February 27, 2026  
> **Author:** Ranjan Sharma + GitHub Copilot (Claude Opus 4.6)  
> **Purpose:** Comprehensive reference for anyone (human or AI) working on this project.

---

## Table of Contents

1. [Architecture Overview](#1-architecture-overview)
2. [Repositories & Deployment](#2-repositories--deployment)
3. [Environment & Configuration](#3-environment--configuration)
4. [Authentication & User Roles](#4-authentication--user-roles)
5. [Database & Models](#5-database--models)
6. [API Routes Reference](#6-api-routes-reference)
7. [Payment System (Stripe)](#7-payment-system-stripe)
8. [Email System](#8-email-system)
9. [Notification System](#9-notification-system)
10. [Admin Panel](#10-admin-panel)
11. [Frontend Structure](#11-frontend-structure)
12. [Feature History (All Changes)](#12-feature-history-all-changes)
13. [Known Issues & Gotchas](#13-known-issues--gotchas)
14. [CLI Testing Commands](#14-cli-testing-commands)
15. [Deployment Checklist](#15-deployment-checklist)

---

## 1. Architecture Overview

```
┌─────────────────────────┐        ┌──────────────────────────────┐
│   Frontend (React SPA)  │        │   Backend (Laravel PHP 8.2)  │
│   Vite + React 19       │◄──────►│   Azure App Service          │
│   Azure Static Web Apps │  API   │   MySQL Database              │
│                         │  JWT   │   Stripe SDK                  │
│   thecodehelper.com     │        │   api.thecodehelper.com       │
└─────────────────────────┘        └──────────────────────────────┘
                                            │
                                   ┌────────┴────────┐
                                   │  Stripe Connect  │
                                   │  (Test Mode)     │
                                   └─────────────────┘
```

**Key tech stack:**
- **Frontend:** React 19, Vite 6, React Router 7, Axios, Stripe.js, Pusher (chat), React Toastify
- **Backend:** Laravel (PHP 8.2), JWT Auth (`tymon/jwt-auth`), Stripe PHP SDK, Maatwebsite Excel
- **Database:** Azure MySQL
- **Hosting:** Azure Static Web Apps (frontend), Azure App Service (backend)
- **CI/CD:** GitHub Actions (auto-deploy on push to `main`)

---

## 2. Repositories & Deployment

### Frontend
| Item | Value |
|------|-------|
| **Repo** | `github.com/flavionvs/TheCodeHelperApplication` |
| **Branch** | `main` |
| **Live URL** | `https://thecodehelper.com` |
| **Azure Resource** | Static Web App: `proud-smoke-034460500` |
| **Workflow** | `.github/workflows/azure-static-web-apps-proud-smoke-034460500.yml` |
| **Build** | `npm run build` → output in `dist/` |
| **Deploy trigger** | Push to `main` → GitHub Actions auto-deploys |

### Backend
| Item | Value |
|------|-------|
| **Repo** | `github.com/flavionvs/thecodehelper_application_backend` |
| **Branch** | `main` |
| **Live API URL** | `https://api.thecodehelper.com` (custom domain) |
| **Azure internal URL** | `https://thecodehelper-api.azurewebsites.net` |
| **Azure Resource** | App Service: `thecodehelper-api` |
| **Workflow** | `.github/workflows/main_thecodehelper-api.yml` |
| **PHP Version** | 8.2 |
| **Deploy trigger** | Push to `main` → GitHub Actions auto-deploys |

### Deployment Commands

```bash
# Frontend deploy
cd TheCodeHelperApplication
git add -A && git commit -m "description" && git push origin main
# Wait for GitHub Actions to finish (~2 min)

# Backend deploy
cd thecodehelper_application_backend
git add -A && git commit -m "description" && git push origin main
# Wait for GitHub Actions to finish (~3-5 min)
```

### IMPORTANT: VITE_API_BASE_URL Mismatch
The frontend GitHub Actions workflow sets:
```yaml
env:
  VITE_API_BASE_URL: https://thecodehelper-api.azurewebsites.net
```
This is the Azure **internal** URL. The custom domain is `api.thecodehelper.com`. Both work for API calls, but the **admin panel session domain** must use `api.thecodehelper.com` (see Session/CSRF section below).

---

## 3. Environment & Configuration

### Backend `.env` (key variables)

```env
APP_URL=https://api.thecodehelper.com
SESSION_DOMAIN=api.thecodehelper.com
SANCTUM_STATEFUL_DOMAINS=api.thecodehelper.com

DB_CONNECTION=mysql
DB_HOST=<azure-mysql-host>
DB_DATABASE=<database-name>
DB_USERNAME=<username>
DB_PASSWORD=<password>

STRIPE_SECRET_KEY=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...
STRIPE_CONNECT_RETURN_URL=https://thecodehelper.com/user/account
STRIPE_CONNECT_REFRESH_URL=https://thecodehelper.com/user/account

MAIL_MAILER=smtp
MAIL_HOST=<smtp-host>
MAIL_PORT=587
MAIL_USERNAME=<email>
MAIL_PASSWORD=<password>
MAIL_FROM_ADDRESS=<from-email>
MAIL_FROM_NAME="The Code Helper"

JWT_SECRET=<jwt-secret>
```

### Frontend `.env`
```env
VITE_API_BASE_URL=https://thecodehelper-api.azurewebsites.net
```

### Config files of note
- `config/services.php` — Stripe keys: `config('services.stripe.secret')`, `config('services.stripe.webhook_secret')`
- `config/cors.php` — CORS settings for API
- `config/jwt.php` — JWT token configuration
- `config/constant.php` — Application constants
- `config/session.php` — Session driver and domain (critical for admin panel)

---

## 4. Authentication & User Roles

### API Authentication (JWT)
- Login: `POST /api/login` → returns `{ token, user_id, user, professional }`
- Token sent as: `Authorization: Bearer <token>` header
- Middleware: `jwt.verify` (applied to all protected routes)
- Frontend stores: `localStorage.token`, `localStorage.user_id`, `localStorage.user_{id}`, `localStorage.professional_{id}`

### Admin Panel Authentication (Session-based)
- Login URL: `https://api.thecodehelper.com/admin/login`
- **CRITICAL:** Must access via custom domain `api.thecodehelper.com`, NOT `thecodehelper-api.azurewebsites.net`
  - Session cookie is set for `SESSION_DOMAIN=api.thecodehelper.com`
  - Using the Azure internal URL causes CSRF 419 errors because the session cookie domain doesn't match
- Guards: `admin` (role=Admin), `superadmin` (role=Superadmin)

### Test Accounts

| Role | Email | Password | User ID |
|------|-------|----------|---------|
| Client | `ranjans838@gmail.com` | `123456789` | 39 |
| Freelancer | `testfreelancer@gmail.com` | `12345678` | 26 |
| Superadmin | `super-admin@gmail.com` | `12345678` | — |

---

## 5. Database & Models

### Key Tables

| Table | Model | Purpose |
|-------|-------|---------|
| `users` | `User` | All users (clients, freelancers, admins) |
| `projects` | `Project` | Posted projects |
| `applications` | `Application` | Freelancer applications to projects |
| `application_statuses` | `ApplicationStatus` | Status change history |
| `payments` | `Payment` | Payment records (Stripe) |
| `notifications` | `Notification` | In-app notifications |
| `professionals` | `Professional` | Freelancer professional profiles |
| `categories` | `Category` | Project categories |
| `technologies` | `Technology` | Technology tags |

### Project Status Flow

```
pending → In_progress → Completion Requested → completed
                      → cancellation_requested → cancelled (admin-managed)
```

### Application Status Flow

```
Pending → Approved (payment made) → Completion Requested → Completed
                                  → Cancellation Requested → Cancelled
       → Rejected
```

### Payment Table Fields
- `application_id` — links to application
- `user_id` — payer/payee
- `amount` — positive for received, negative for sent
- `paymentStatus` — `succeeded`, etc.
- `paymentIntentId` — Stripe PaymentIntent ID
- `stripe_transfer_id` — Stripe Transfer ID (for freelancer payout)
- `checkoutSessionId` — Stripe Checkout Session ID

### Important: INVISIBLE column `id`
The `applications` table has an `INVISIBLE` primary key column. Eloquent's `save()` method doesn't handle this well. Use `DB::table('applications')->where('id', $pk)->update(...)` instead of `$application->save()`.

---

## 6. API Routes Reference

### Public Routes (no auth)
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| POST | `/api/login` | `JWTController@login` | User login |
| POST | `/api/register` | `JWTController@register` | User registration |
| POST | `/api/verify-signup-otp` | `JWTController@verifySignupOtp` | Verify email OTP |
| POST | `/api/resend-signup-otp` | `JWTController@resendSignupOtp` | Resend OTP |
| POST | `/api/send-otp` | `ApiUserController@sendOtp` | Forgot password OTP |
| POST | `/api/verify-otp` | `ApiUserController@verifyOtp` | Verify forgot password OTP |
| POST | `/api/change-password` | `ApiUserController@changePassword` | Change password |
| GET | `/api/project/detail/{id}` | `ApiController@projectDetail` | Public project detail |
| POST | `/api/filter` | `ApiController@filter` | Filter projects |
| GET | `/api/category` | `ApiController@category` | List categories |
| POST | `/api/stripe/webhook` | `StripeWebhookController@handle` | Stripe webhooks |

### Protected Routes (JWT required)
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/api/dashboard` | `ApiController@dashboard` | User dashboard |
| GET | `/api/profile/{user_id?}` | `ApiUserController@profile` | User profile |
| POST | `/api/update-profile` | `ApiUserController@updateProfile` | Update profile |
| GET | `/api/projects/{id?}` | `ApiProjectController@projects` | List projects |
| POST | `/api/project/create` | `ApiProjectController@create` | Create project |
| PUT | `/api/project/update/{id}` | `ApiProjectController@update` | Update project |
| GET | `/api/project/delete/{id}` | `ApiProjectController@delete` | Delete project |
| GET | `/api/applications/{project_id}` | `ApiProjectController@application` | Get applications |
| POST | `/api/apply/{project_id}` | `ApiProjectController@apply` | Apply to project |
| POST | `/api/update-application-status` | `ApiProjectController@updateApplicationStatus` | Approve application + payment |
| POST | `/api/project/complete/{id}` | `ApiProjectController@completed` | Request completion |
| POST | `/api/project/accept/complete/{id}` | `ApiProjectController@acceptCompleted` | Accept completion + transfer |
| POST | `/api/application/cancel/{id}` | `ApiProjectController@cancel` | Request cancellation |
| POST | `/api/create-checkout-session` | `ApiController@createCheckoutSession` | Stripe Checkout |
| POST | `/api/verify-checkout-session` | `ApiController@verifyCheckoutSession` | Verify payment |
| GET | `/api/payments` | `ApiController@payments` | Payment history |
| GET | `/api/wallet-balance` | `ApiController@walletBalance` | Wallet balance |
| POST | `/api/create-stripe-account` | `ApiController@createAccount` | Connect to Stripe |
| GET/POST | `/api/notifications*` | `ApiController@*` | Notification CRUD |
| GET/POST | `/api/get-message/*` | `ApiChatController@*` | Chat messaging |

---

## 7. Payment System (Stripe)

### Flow Overview

```
1. Client creates project
2. Freelancer applies (sets amount)
3. Client approves → Stripe Checkout Session created
4. Client pays on Stripe's hosted page
5. Stripe redirects to /payment-success?session_id=cs_xxx
6. Frontend calls verify-checkout-session
7. Webhook (checkout.session.completed) also fires
8. Whichever runs first: marks as paid, sends emails, starts project
9. Freelancer completes work → "Completion Requested"
10. Client accepts → Stripe Transfer to freelancer's connected account
```

### Fee Structure (shown in confirmation modal)
- **Freelancer Amount:** What the freelancer asked for (e.g., $50.00)
- **Admin Commission:** 25% of freelancer amount (e.g., $12.50)
- **Stripe Fee (%):** 2.6% of (freelancer + admin) total (e.g., $1.63 on $62.50 = $1.63, but currently code uses `$1.30` fixed on amount)
- **Stripe Flat Fee:** $0.30 per transaction
- **Total:** Sum of all components

### Stripe Checkout (Redirect-Based)
- **NOT embedded** — uses `stripe.redirectToCheckout()` which takes user to Stripe's hosted page
- Checkout session created by: `ApiController@createCheckoutSession`
- Returns: `{ checkoutSessionId, checkoutUrl }`
- Frontend redirects to `checkoutUrl`
- After payment: Stripe redirects to `{FRONTEND_URL}/payment-success?session_id=cs_xxx`

### Payment Verification (Dual-Path with Dedup)
Two handlers may fire after payment:
1. **Webhook:** `StripeWebhookController@handle` (`checkout.session.completed` event)
2. **Frontend verify:** `ApiController@verifyCheckoutSession` (called by PaymentSuccess page)

**Dedup strategy:** Uses notification-based dedup:
```php
$notifAlreadySent = Notification::where('reference_id', $project->id)
    ->where('type', 'approved')
    ->where('user_id', $application->user_id)
    ->exists();

if (!$notifAlreadySent) {
    // Send emails, create notifications
}
```
Whichever handler runs first creates the notification + sends emails. The second one sees `$notifAlreadySent = true` and skips.

### Stripe Transfer (source_transaction Fix)
**Problem:** After payment capture, Stripe holds funds for ~2 days. `\Stripe\Balance::retrieve()` shows $0 available for recent payments.

**Solution:** Use `source_transaction` parameter in `\Stripe\Transfer::create()`:
```php
$transferData['source_transaction'] = $chargeId; // ch_xxx
```
This tells Stripe to link the transfer to the original charge. Stripe automatically buffers the transfer until the charge's funds settle.

**Implementation:**
- `app/custom.php` → `transfer($stripe_account_id, $amount, $sourceTransaction = null)`
- `acceptCompleted()` looks up: `Payment` → `PaymentIntent::retrieve()` → `latest_charge`
- `processCancellation()` does the same for refund transfers

### Cancellation Flow (Admin-Managed)
1. Freelancer/client requests cancellation → project status = `cancellation_requested`
2. Admin views in admin panel → "Cancelled Projects" tab
3. Admin approves refund or rejects
4. Refund uses `\Stripe\Refund::create()` with original PaymentIntent + Stripe Transfer to freelancer for any earned portion
5. Admin rejects → notifies both parties

---

## 8. Email System

All emails are sent via `App\Services\EmailService` using Blade templates in `resources/views/emails/`.

### Email Matrix

| Event | Trigger | Method | Recipient | Template |
|-------|---------|--------|-----------|----------|
| User Signup | Registration + OTP verified | `sendWelcome()` | New user | `emails.welcome` |
| Signup OTP | Registration | `sendSignupOtp()` | New user | `emails.signup-otp` |
| Forgot Password | Password reset request | `sendForgotPassword()` | User | `emails.forgot-password` |
| Project Created | Client creates project | `sendProjectCreated()` | Client | `emails.project-created` |
| New Application | Freelancer applies | `sendNewApplication()` | Client | `emails.new-application` |
| Application Approved | Payment succeeds | `sendApplicationApproved()` | Freelancer | `emails.application-approved` |
| Payment Successful | Payment succeeds | `sendPaymentSuccessful()` | Client | `emails.payment-successful` |
| Completion Requested | Freelancer marks done | `sendCompletionRequested()` | Client | `emails.completion-requested` |
| Project Completed | Client accepts completion | `sendProjectCompleted()` | Both | `emails.project-completed` |

### Email Sending Points
- **Application approved + Payment:** Sent from whichever handler runs first (webhook or verify-checkout-session), deduped via notifications
- **Completion requested:** Sent from `ApiProjectController@completed`
- **Project completed:** Sent from `ApiProjectController@acceptCompleted`

---

## 9. Notification System

### In-App Notifications
- Stored in `notifications` table
- Fields: `user_id`, `title`, `message`, `type`, `link`, `reference_id`, `read_at`
- Used for dedup (checking if email was already sent for an event)
- Frontend polls via `GET /api/notifications/unread-count`

### Notification Types
| Type | Event |
|------|-------|
| `applied` | Freelancer applied |
| `approved` | Application approved (payment) |
| `completed` | Project completed |
| `cancelled` | Project cancelled |
| `message` | Chat message |

---

## 10. Admin Panel

### Access
- **URL:** `https://api.thecodehelper.com/admin/login`
- **NEVER use:** `https://thecodehelper-api.azurewebsites.net/admin/login` (causes CSRF 419)
- **Credentials:** Superadmin account (see Test Accounts section)

### Admin Routes
- Login: `GET/POST /admin/login`
- Register: `GET/POST /admin/register`
- Dashboard and management are in `routes/admin.php` and `routes/superadmin.php`

### Admin-Managed Features
- **Project cancellation:** Admin reviews cancellation requests and approves refund or rejects
- **Cancelled projects tab:** Shows projects in `cancellation_requested` and `cancelled` states
- **User management, categories, technologies**

---

## 11. Frontend Structure

### Key Pages
```
src/pages/
├── Home.jsx              — Landing page
├── Login.jsx             — Login with JWT
├── Register.jsx          — Registration with OTP
├── ForgotPassword.jsx    — Password reset
├── ChangePassword.jsx    — Change password
├── ProjectListing.jsx    — Browse projects
├── ProjectDetail.jsx     — Single project view
├── ProjectCreate.jsx     — Create new project
├── StripePayment.jsx     — Payment flow (Stripe Checkout redirect)
├── Contact.jsx           — Contact form
├── About.jsx             — About page
├── Freelancer.jsx        — Freelancer listing
├── Client.jsx            — Client listing
└── user/
    ├── Dashboard.jsx     — User dashboard
    ├── Project.jsx       — My projects (client view)
    ├── ProjectList.jsx   — Project listing component
    ├── OngoingProjectList.jsx — Ongoing projects
    ├── Application.jsx   — Applications management
    ├── ApplicationDetails.jsx — Application detail
    ├── Profile.jsx       — Edit profile
    ├── ViewProfile.jsx   — View profile
    ├── Account.jsx       — Account/Stripe connect
    ├── Payments.jsx      — Payment history
    └── Chat.jsx          — Chat interface
```

### Key Utils
- `src/utils/api.js` — Axios API client; reads `VITE_API_BASE_URL`, appends `/api`
- `src/utils/handleValidationErrors.js` — DOM-based error display (`.error-text`, `.input-error` classes)

### Routing
- Uses `react-router-dom` v7
- Routes defined in `src/main.jsx` and `src/App.jsx`
- `useNavigate()` for programmatic navigation

### Duplicate Files Warning
Many files have `* copy.jsx` variants (e.g., `Footer.jsx` and `Footer copy.jsx`). **Always edit the non-copy file.** Don't delete copy files without confirming they're unused.

---

## 12. Feature History (All Changes)

### Phase 1: Email & OTP Integration (Feb 6-10, 2026)
- Implemented email sending for all project lifecycle events
- Added OTP verification for signup
- Created all Blade email templates

### Phase 2: UI Fixes & Stripe Payment Audit (Feb 10-14, 2026)
- Fixed 12 Stripe payment bugs
- Fixed UI alignment issues across pages
- Added Stripe Connect warning for freelancers without accounts

### Phase 3: Stripe Checkout Migration (Feb 14-18, 2026)
- **Migrated from embedded CardElement to Stripe Checkout (hosted page)**
- Implemented redirect-based checkout flow
- Created confirmation modal with fee breakdown (4 components)
- Added `PaymentSuccess` page for post-payment verification
- Tested end-to-end payment flow

### Phase 4: Webhook & Email Improvements (Feb 18-22, 2026)
- Fixed webhook email sending
- Added Stripe description with 4 fee components
- Updated notification/email messaging
- Removed Cancel button from payment flow
- Reverted from embedded back to redirect-based checkout (final)
- Full flow audit and `verify-checkout-session` endpoint

### Phase 5: Admin Cancellation Flow (Feb 22-25, 2026)
- Implemented `cancellation_requested` project status
- Built admin dashboard page for cancelled projects
- Created refund/reject endpoints in `Common/ProjectController`
- Added tab filtering for cancelled projects in admin panel

### Phase 6: Critical Bug Fixes (Feb 25-27, 2026)
- **419 CSRF Login Fix:** Admin panel was using wrong domain (Azure internal URL instead of custom domain). Fixed `SESSION_DOMAIN` to `api.thecodehelper.com`.
- **Email Dedup Fix:** Changed from `$alreadyPaid` flag to notification-based dedup. The `$alreadyPaid` flag had a race condition where webhook could partially fail (email send caught silently) but set `payment_status='paid'`, causing `verify-checkout-session` to skip emails entirely.
- **Stripe Transfer Fix (source_transaction):** Transfer function now accepts optional `$sourceTransaction` charge ID. When provided, Stripe buffers the transfer until the charge's funds settle (~2 days). This eliminates "Insufficient platform balance" errors for recently-captured payments.
- **500 Error Hotfix:** Fixed extra `}` brace and undefined `$alreadyPaid` variable reference in `ApiController@verifyCheckoutSession` after the email dedup refactor.

### Files Modified in Phase 6
| File | Changes |
|------|---------|
| `app/custom.php` | Added `$sourceTransaction` param to `transfer()` |
| `app/Http/Controllers/API/ApiController.php` | Notification-based dedup in `verifyCheckoutSession()`, fixed extra brace + undefined var |
| `app/Http/Controllers/API/ApiProjectController.php` | Notification-based dedup in `updateApplicationStatus()`, source_transaction in `acceptCompleted()` |
| `app/Http/Controllers/API/StripeWebhookController.php` | Notification-based dedup in both webhook handlers |
| `app/Http/Controllers/Common/ProjectController.php` | Source_transaction in `processCancellation()` |

---

## 13. Known Issues & Gotchas

### Critical
1. **INVISIBLE column `id` in `applications`:** Eloquent's `save()` doesn't work properly. Always use `DB::table('applications')->where('id', $pk)->update(...)`.
2. **Session domain mismatch:** Admin panel login must use `api.thecodehelper.com`. Using the Azure internal URL causes CSRF 419 errors.
3. **`VITE_API_BASE_URL` in CI/CD:** The frontend workflow hardcodes the Azure internal URL. API calls work fine, but this URL is NOT the session domain. Don't use it for admin panel access.

### Stripe-Specific
4. **Test mode balance:** Stripe test mode starts with $0 available balance. Transfers without `source_transaction` will fail unless you add test funds using the `4000000000000077` card.
5. **source_transaction requires real charge:** The `source_transaction` parameter needs a real charge ID (`ch_xxx`). It can't be tested with fake PaymentIntent IDs.
6. **Funds availability:** Even with `source_transaction`, Stripe holds funds for ~2 days after capture. The transfer is buffered automatically.

### Code Quality
7. **Duplicate "copy" files:** Many files have `* copy.jsx` variants. Don't confuse them with the real files.
8. **DOM manipulation in validation:** `handleValidationErrors.js` directly manipulates DOM. Don't break `.error-text` / `.input-error` conventions.
9. **No test framework:** No automated tests. Use `npm run dev` and browser devtools to debug.

---

## 14. CLI Testing Commands

### Authentication

```bash
# Login as client
CLIENT_TOKEN=$(curl -s -X POST "https://api.thecodehelper.com/api/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"ranjans838@gmail.com","password":"123456789"}' | python3 -c "import json,sys; print(json.load(sys.stdin)['token'])")

# Login as freelancer
FL_TOKEN=$(curl -s -X POST "https://api.thecodehelper.com/api/login" \
  -H "Content-Type: application/json" \
  -d '{"email":"testfreelancer@gmail.com","password":"12345678"}' | python3 -c "import json,sys; print(json.load(sys.stdin)['token'])")
```

### Project Lifecycle

```bash
# Create project (as client)
curl -s -X POST "https://api.thecodehelper.com/api/project/create" \
  -H "Authorization: Bearer $CLIENT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Test Project",
    "description": "Test description",
    "category_id": 1,
    "budget": 100,
    "experience": "intermediate",
    "type": "fixed",
    "deadline": "2026-04-01"
  }' | python3 -m json.tool

# Apply to project (as freelancer) — replace {project_id}
curl -s -X POST "https://api.thecodehelper.com/api/apply/{project_id}" \
  -H "Authorization: Bearer $FL_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"description":"I can build this","hours":10,"rate":5,"amount":50}' | python3 -m json.tool

# Create Stripe checkout session (as client) — replace {applicationId}
curl -s -X POST "https://api.thecodehelper.com/api/create-checkout-session" \
  -H "Authorization: Bearer $CLIENT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"applicationId": {applicationId}}' | python3 -m json.tool

# Simulate payment (for testing — uses update-application-status) — replace values
curl -s -X POST "https://api.thecodehelper.com/api/update-application-status" \
  -H "Authorization: Bearer $CLIENT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "applicationId": {applicationId},
    "paymentIntentId": "pi_test_xxx",
    "amount": 6410
  }' | python3 -m json.tool

# Request completion (as freelancer) — replace {project_id}
curl -s -X POST "https://api.thecodehelper.com/api/project/complete/{project_id}" \
  -H "Authorization: Bearer $FL_TOKEN" \
  -H "Content-Type: application/json" | python3 -m json.tool

# Accept completion (as client) — replace {project_id}
curl -s -X POST "https://api.thecodehelper.com/api/project/accept/complete/{project_id}" \
  -H "Authorization: Bearer $CLIENT_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"remark":"Great work!"}' | python3 -m json.tool
```

### Inspect Data

```bash
# List applications for a project
curl -s "https://api.thecodehelper.com/api/applications/{project_id}" \
  -H "Authorization: Bearer $CLIENT_TOKEN" | python3 -m json.tool

# Check payment history
curl -s "https://api.thecodehelper.com/api/payments" \
  -H "Authorization: Bearer $CLIENT_TOKEN" | python3 -m json.tool

# Check wallet balance
curl -s "https://api.thecodehelper.com/api/wallet-balance" \
  -H "Authorization: Bearer $CLIENT_TOKEN" | python3 -m json.tool

# Check notifications
curl -s "https://api.thecodehelper.com/api/notifications" \
  -H "Authorization: Bearer $CLIENT_TOKEN" | python3 -m json.tool
```

---

## 15. Deployment Checklist

### Before Deploying Backend Changes

- [ ] **Test locally** if possible (or review code thoroughly)
- [ ] **Check for syntax errors:** Extra braces, undefined variables, missing semicolons
- [ ] **Verify Eloquent vs DB::table usage** for the `applications` table (INVISIBLE id column)
- [ ] **Don't break email dedup:** If modifying payment handlers, ensure the notification-based dedup pattern is preserved
- [ ] **Don't break `transfer()` signature:** `transfer($stripe_account_id, $amount, $sourceTransaction = null)` — the 3rd param is optional

### Deploying

1. `git add -A && git commit -m "descriptive message"`
2. `git push origin main`
3. Monitor GitHub Actions: go to repo → Actions tab → watch build + deploy
4. After deploy completes (~3-5 min for backend), test a basic endpoint:
   ```bash
   curl -s "https://api.thecodehelper.com/api/category" | head -100
   ```
5. If 500 errors appear, check Azure logs:
   - Azure Portal → App Service `thecodehelper-api` → Log stream
   - Or: `storage/logs/laravel.log` (if SSH access available)

### After Deploying

- [ ] Verify `GET /api/category` returns data (basic health check)
- [ ] Verify `POST /api/login` works (JWT auth check)
- [ ] If payment code was changed, test `POST /api/create-checkout-session`
- [ ] If admin code was changed, test admin login at `https://api.thecodehelper.com/admin/login`

### Emergency Rollback
```bash
# Find the previous working commit
git log --oneline -10

# Revert to specific commit
git revert <bad-commit-hash>
git push origin main

# OR force reset (destructive — use only if revert is complex)
git reset --hard <good-commit-hash>
git push origin main --force
```

---

## Appendix: Key File Locations

### Backend
| File | Purpose |
|------|---------|
| `app/custom.php` | `transfer()` function for Stripe payouts |
| `app/Services/EmailService.php` | All 9 email sending methods |
| `app/Http/Controllers/API/ApiController.php` | Main API controller (checkout, verify, payments, categories) |
| `app/Http/Controllers/API/ApiProjectController.php` | Project CRUD, applications, completion flow |
| `app/Http/Controllers/API/StripeWebhookController.php` | Stripe webhook handler |
| `app/Http/Controllers/Common/ProjectController.php` | Admin cancellation processing |
| `app/Http/Controllers/API/JWTController.php` | Login, register, OTP |
| `app/Http/Controllers/API/ApiUserController.php` | User profile, password |
| `app/Http/Controllers/API/ApiChatController.php` | Chat messaging |
| `config/services.php` | Stripe config keys |
| `routes/api.php` | All API routes |
| `routes/admin.php` | Admin panel routes |
| `routes/superadmin.php` | Superadmin routes |

### Frontend
| File | Purpose |
|------|---------|
| `src/utils/api.js` | Axios API client |
| `src/utils/handleValidationErrors.js` | DOM-based error display |
| `src/pages/Login.jsx` | Login page (stores tokens in localStorage) |
| `src/pages/StripePayment.jsx` | Stripe Checkout redirect flow |
| `src/pages/user/Application.jsx` | Application management + payment |
| `src/pages/user/OngoingProjectList.jsx` | Ongoing/completed project tabs |
| `src/main.jsx` | App entry point + routing |
| `src/App.jsx` | Root component |
| `.github/workflows/azure-static-web-apps-proud-smoke-034460500.yml` | CI/CD |

---

> **For AI agents:** Read this document at the start of every session. It contains all the context you need to understand the project and avoid repeating past mistakes (especially the CSRF/session domain issue, the INVISIBLE column gotcha, and the email dedup pattern).
