# Developer Task Checklist: Circular Leasing (Plan 19)

## Execution State
**status:** completed
**verification_notes:** Phase 3 complete. End-to-end checkout and return flows implemented.
**implementation_notes:** Backend logic wired up. Admin dashboard updated.

## Phase 1: Frontend UI & Components (Prioritized)
- [x] **Task 1.1:** Update Product Detail Page (PDP) to support a "Buy vs. Lease" pricing toggle.
- [x] **Task 1.2:** Update User Dashboard (Ambassador Portfolio) to include an "Active Leases" tab and an "Initiate Return" action.
- [x] **Task 1.3:** Update Admin Ecosystem Pulse to add a "Receive Return" scanning and condition assessment UI.

## Phase 2: Database & Models (Data Contract)
- [x] **Task 2.1:** Create `lease_subscriptions` migration (`user_id`, `product_variant_id`, `status`, `start_date`, `next_billing_date`, `hub_id`).
- [x] **Task 2.2:** Update `product_passports` migration to add `condition_log` (JSON) and `is_leased` (boolean).
- [x] **Task 2.3:** Create `LeaseSubscription` model and update `User`, `ProductVariant`, and `ProductPassport` relationships.

## Phase 3: Backend Logic & Routing
- [ ] **Task 3.1:** Integrate Stripe/Cashier recurring billing for the lease checkout process.
- [ ] **Task 3.2:** Implement Carbon Gate Fee math for lease origination and return transit.
- [ ] **Task 3.3:** Implement return logic: pause subscription, route to nearest Local Hub, and handle condition updates via Admin scan.nearest Local Hub, and handle condition updates via Admin scan.