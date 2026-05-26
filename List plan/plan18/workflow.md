# Project Workflow Contract

sequence_id: 18
artifact_folder: List plan/plan18/
source_plan: List plan/plan18/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: view_actual_impact_history_hardened
    description: User views their impact history calculated from real purchase and circularity logs.
    entrypoint: Dashboard -> Eco Impact
    steps:
      - system retrieves `orders` and `order_items` for the current user.
      - system joins `products` and `sustainability_metrics` to calculate per-item water and carbon savings.
      - system retrieves `resale_trade_ins` for the user.
      - system aggregates all savings, grouped by month (last 6 months).
      - system renders the results in the `ImpactTimelineChart`.
    success_state: User sees an accurate, audit-ready timeline of their ecological contribution.
    failure_state: Incomplete order data shows a "Building History..." placeholder instead of random bars.

  - id: calculate_real_transit_penalty_hardened
    description: System calculates international shipping impact using actual geo-coordinates.
    entrypoint: Checkout -> Shipping Address Entry
    steps:
      - system retrieves the sourcing `LocalHub` coordinates (lat/long).
      - system resolves the destination coordinates (using a simple ZIP mapping for MVP).
      - system executes `GeoRoutingService@calculateDistance` using the Haversine formula.
      - system applies the emission factor based on the calculated distance and mode.
      - system displays the real CO2 penalty and mandatory offset fee.
    success_state: Every gram of CO2 is mathematically justified based on actual logistics distance.

  - id: monitor_live_governance_quorum_hardened
    description: Admin monitors the real-time progress of a community vote.
    entrypoint: Admin Dashboard -> Governance Widget
    steps:
      - system retrieves the active `GovernanceProposal`.
      - system queries `GovernanceVote` for the proposal, summing the `resultant_influence` field (Plan 11).
      - system calculates the percentage of the `quorum_threshold` reached.
      - system renders the live progress bar.
    success_state: Admin sees a live, "pulse-ready" visualization of community participation.

frontend_first_sequence:
  - slice_1: Service Integration & Mock Purge
    rationale: The UI already exists; the first step is swapping the data source in the Volt components.
    user_workflow: view_actual_impact_history_hardened, monitor_live_governance_quorum_hardened
    frontend_layout_controls:
      - `ImpactTimelineChart`: Update `mount` to call `getUserImpactHistory`.
      - `MilestoneBadgeGrid`: Update to check `user_milestones` table.
      - `DashboardStats`: Update to call hardened `AdminDashboardService`.
    image_slots: none

controls_routing: none

backend_contract:
  - SustainabilityImpactService:
      - `getUserImpactHistory(User $user)`: (Hardened) Real SQL aggregation from orders/resales.
      - `calculateTransitImpact(LocalHub $hub, string $destinationZip)`: (Hardened) Real Haversine math.
  - AdminDashboardService:
      - `getActiveGovernanceSummary()`: (Hardened) Sums real vote influence.
  - GeoRoutingService:
      - `calculateDistance(float $lat1, float $lng1, float $lat2, float $lng2)`: (Existing) Technical core for distance.

database_contract: none (Uses existing Plan 1-17 schemas).

verification_flow:
  - functional_testing:
      - "Create a new order and verify that the 'Community Water Saved' KPI in the Admin Dashboard increases by the exact calculated amount."
      - "Verify that a user with no history sees an empty timeline (no rand() fallback)."
      - "Ensure that changing a Hub's coordinates affects the CO2 penalty on a test international order."
  - automated_tests:
      - Unit: `ImpactAggregationHardeningTest`.
      - Feature: `LiveDashboardDataTest`.

risks_unknowns:
  - SQL aggregation speed for large datasets: ensure indexes exist on `order_items` and `resale_trade_ins` for user/product/date.
