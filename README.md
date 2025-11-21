# Teller Portal API

Modern REST API for onboarding requests, teller management, and workflow approvals that powers the Teller Portal admin and teller dashboards. The HTTP layer now mirrors the web UI so you can integrate mobile apps, partner systems, or QA tooling without touching Blade views.

## Stack & Requirements
- PHP 8.2+, Composer, Node 18+ (for UI builds)
- MySQL / MariaDB for the primary data store
- Laravel 12 with Sanctum for token based auth
- Local storage disk for attachments (`storage/app/public`)

## Local Setup
1. `cp .env.example .env` and update DB + OLD_DB_* credentials.
2. `composer install && npm install`
3. `php artisan key:generate`
4. `php artisan migrate` (runs both core and teller specific tables)
5. `php artisan db:seed --class=TellerPortalBranchSeeder` (rebuilds branches + units from the legacy `unit` table)
6. `php artisan storage:link`
7. `npm run dev` (or `build`) and `php artisan serve`

### Docker Workflow
If you prefer running everything inside the provided containers:

1. `cp .env.example .env` and tweak DB credentials if needed (the defaults already line up with `docker-compose.yml`).
2. `docker compose up -d --build` (starts PHP-FPM, Nginx, MySQL, phpMyAdmin).
3. Install PHP dependencies inside the container: `docker compose exec app composer install`.
4. Run migrations/key generation/storage link inside the container:
   - `docker compose exec app php artisan key:generate`
   - `docker compose exec app php artisan migrate`
   - `docker compose exec app php artisan storage:link`
5. Frontend assets still run on the host (Node isn’t baked into the PHP image):
   - `npm install`
   - `npm run dev` (or `npm run build` for production)
6. Browse the app at http://localhost:8081 once the containers finish booting. phpMyAdmin lives at http://localhost:8082 (user `teller_user`, password `teller_pass`).

Admin accounts can be seeded manually or through the UI. Tellers created through the API/web need the `status` field set to `approved` before they can log in.

## API Authentication
All endpoints live under `/api/...` and are guarded by Laravel Sanctum.

| Endpoint | Description |
| --- | --- |
| `POST /api/auth/login` | Accepts `identifier` (teller_id or email) + `password`, returns Bearer token + user payload. |
| `POST /api/auth/logout` | Revokes the current token. |
| `GET /api/auth/me` | Returns the authenticated profile (branch/unit eager loaded). |

Add the `Authorization: Bearer {token}` header to every subsequent request.

## Teller Endpoints

### Branch metadata
`GET /api/meta/branches` (auth required). Returns active branches with nested units so clients can build cascading dropdowns.

### Teller onboarding requests
All routes require a teller (approved) token.

| Method & Path | Purpose |
| --- | --- |
| `GET /api/teller/requests?status=pending&per_page=15` | Paginated list filtered by status (pending, approved, rejected). |
| `POST /api/teller/requests` | Create a request. Accepts JSON/multipart fields such as `store_name`, `branch_id`, optional `attachments[]` (pdf/jpg/png up to 5 MB each). |
| `GET /api/teller/requests/{id}` | View a single request including branch/unit and attachment URLs. |
| `PUT /api/teller/requests/{id}` | Update a request; include `delete_attachments[]` indexes to remove uploaded files. Rejected forms automatically revert to pending on edit. |
| `POST /api/teller/requests/{id}/resubmit` | Resets a rejected form back to `pending`. |

Sample multipart call:

```bash
curl -X POST http://localhost:8000/api/teller/requests \
  -H "Authorization: Bearer $TOKEN" \
  -F store_name="Night Market" \
  -F branch_id=12 \
  -F unit_id=3 \
  -F attachments[]=@/path/site_photo.jpg
```

## Admin Endpoints

### Teller management

| Method & Path | Purpose |
| --- | --- |
| `GET /api/admin/tellers?search=APB&status=approved` | Paginated teller list. |
| `POST /api/admin/tellers` | Create a teller (`teller_id`, `name`, optional contact info, plaintext `password`). |
| `GET /api/admin/tellers/{id}` | Show teller profile. |
| `PUT /api/admin/tellers/{id}` | Update name/email/phone/status/password/branch/unit. |
| `DELETE /api/admin/tellers/{id}` | Remove teller. |
| `PATCH /api/admin/tellers/{id}/status` | Quick status toggle (`pending`, `approved`, `rejected`). |

Every action writes to `user_logs` with IP & user agent details.

### Workflow approvals

| Method & Path | Purpose |
| --- | --- |
| `GET /api/admin/requests?status=pending` | Paginated filterable onboarding queue. |
| `GET /api/admin/requests/{id}` | Detailed view including teller profile + attachments. |
| `POST /api/admin/requests/{id}/approve` | Marks request as approved (optional `admin_remark`). |
| `POST /api/admin/requests/{id}/reject` | Requires `admin_remark`, sets status to rejected. |

### Logs
`GET /api/admin/logs?search=create` lists audit trail entries with actor + target users.

## Automated Testing Guide

API contracts ship with dedicated feature tests so you can guard against regressions:

```bash
# run the focused API suite
php artisan test --filter=Tests\\Feature\\Api

# or execute the entire test matrix
php artisan test
```

Under the hood we fake the public disk for uploads and seed stub branch/unit data so tests stay hermetic. When running the default suite you may still see Breeze scaffolding tests; feel free to tailor or disable them if your app no longer relies on the stock auth views.

## Manual QA / Postman Tutorial
1. Hit `POST /api/auth/login` with a known teller_id/password pair (or create one via `POST /api/admin/tellers` using an admin token).
2. Save the returned Bearer token in an environment variable.
3. Query metadata (`GET /api/meta/branches`) to populate dropdowns in your client.
4. Create onboarding requests with multipart payloads. Verify that attachments come back with signed URLs in `GET /api/teller/requests/{id}`.
5. As an admin, approve/reject using the respective endpoints and confirm that the teller’s notifications (`GET /api/teller/requests`) reflect the new status.
6. Exercise the log endpoint to ensure every CRUD action is tracked.

Repeat these steps whenever you roll out schema or workflow changes—the combination of automated tests plus this manual checklist keeps both portals in sync.
