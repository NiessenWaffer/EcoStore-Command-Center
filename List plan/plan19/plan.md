# Blueprint: Circular Leasing & Rental Model (Plan 19)

## 1. Scope & Objective
- **Feature:** Product-as-a-Service (PaaS) Leasing Model.
- **Objective:** Enable users to subscribe to sustainable fashion items (leasing), tracking condition upon return, and managing dynamic inventory through Local Hubs.
- **Boundaries:** Includes subscription billing integration, ledger for physical condition, return logistics, and dynamic inventory scoping by Hub.

## 2. Data Contract (New & Modified Models)
- `LeaseSubscription`: Tracks active leases.
  - Fields: `user_id`, `product_variant_id`, `status` (active|returning|completed|overdue), `start_date`, `next_billing_date`, `hub_id`.
- `ProductPassport` (Update): 
  - Add `condition_log`: Array/JSON of condition reports (pristine, good, fair, needs_repair) to maintain physical history.
  - Add `is_leased`: Boolean to lock ownership transfers while leased.
- `ReturnTransitEvent`: Extends transit tracking for leased items routing back to the closest Local Hub for refurbishment/cleaning.

## 3. Business Logic & Constraints
- **Availability:** Only items currently physically present at a Local Hub in 'pristine' or 'good' condition can be leased.
- **Billing:** Monthly recurring billing via Cashier (Stripe integration).
- **End of Lease:** When returned, the Hub Admin records the condition. If 'needs_repair', it triggers a maintenance workflow before returning to the leasable inventory pool.
- **Carbon Gate Fee:** Applied to the outbound lease shipment and return shipment based on Haversine distance, adhering to Plan 5 & Plan 12 rules.

## 4. Acceptance Criteria
- User can view lease options on Product Detail Pages alongside standard purchase options.
- User can start a monthly lease, successfully generating a `LeaseSubscription`.
- User Dashboard displays active leases, billing dates, and return instructions.
- Admin Command Center allows scanning returned items and appending a condition report to the immutable `ProductPassport`.