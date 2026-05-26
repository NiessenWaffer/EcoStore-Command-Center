# Developer Task Checklist: Multi-Tenant Marketplace (Plan 21)

## Execution State
**status:** in_progress
**verification_notes:** Pending initial frontend implementation.
**implementation_notes:** Starting with Frontend UI changes to support Brand discovery.

## Phase 1: Frontend UI & Components (Prioritized)
- [x] **Task 1.1:** Add "Brand" filter to the Shop sidebar and mobile filter drawer.
- [x] **Task 1.2:** Update Product Cards in the grid to display the Brand name/logo if it's an external partner.
- [x] **Task 1.3:** Create a Partner Landing Page (`/partners`) explaining the onboarding process.
- [x] **Task 1.4:** Update the Admin Command Center to include a "Partner Pulse" tab for managing brand applications.

## Phase 2: Database & Models (Data Contract)
- [x] **Task 2.1:** Create `brands` migration (`name`, `slug`, `api_token`, `commission_rate`, `logo_url`, `is_verified`).
- [x] **Task 2.2:** Add `brand_id` to `products` table and `commission_cents` to `orders` table.
- [x] **Task 2.3:** Implement `Brand` model and define relationships with `Product` and `Order`.

## Phase 3: API & Multi-Tenancy Logic
- [x] **Task 3.1:** Implement Laravel Sanctum/Passport for brand API authentication (implemented custom token middleware for environment compatibility).
- [x] **Task 3.2:** Create API endpoints for product listing and passport minting (`POST /api/v1/passports`).
- [x] **Task 3.3:** Implement scope-based data isolation in the Brand dashboard.
- [x] **Task 3.4:** Update checkout logic to calculate and store commissions for partner sales.

## Execution State
**status:** completed
**verification_notes:** Multi-tenant marketplace architecture is fully operational.
**implementation_notes:** B2B API endpoints are secured via custom token middleware. Partners have a dedicated command center.
