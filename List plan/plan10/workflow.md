# Project Workflow Contract

sequence_id: 10
artifact_folder: List plan/plan10/
source_plan: List plan/plan10/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: monitor_ecosystem_impact_realtime
    description: Admin visits the root dashboard and views real-time sustainability and governance KPIs.
    entrypoint: /admin (Root Dashboard)
    steps:
      - user visits the admin URL.
      - system aggregates `cumulative_water_saved` and `cumulative_carbon_reduced` from all users.
      - system retrieves the most recent active `GovernanceProposal` and calculates quorum progress.
      - system displays KPI cards with sparkline or trend indicators.
    success_state: Admin sees a high-fidelity summary of the brand's total environmental impact.
    failure_state: Database timeout or empty state visualization if no data exists.

  - id: respond_to_trust_integrity_alerts
    description: Admin identifies and responds to critical system alerts regarding audit log integrity.
    entrypoint: Admin Dashboard -> Trust Alert Feed
    steps:
      - system identifies `PassportAuditLog` entries flagged for "Multi-Sig Correction" (Plan 9).
      - system identifies any `ProductPassport` where `is_verified` is false (hash mismatch).
      - Admin clicks "Resolve" on an alert.
      - system navigates to the relevant Correction Review or Audit Log detail page.
    success_state: Admin can jump directly from a high-level alert to the resolution screen.
    failure_state: Alert disappears or lacks actionable context.

  - id: manage_unified_navigation
    description: Admin accesses all management modules through a synchronized navigation system.
    entrypoint: Any Admin Page (/admin/*)
    steps:
      - system displays a consistent Header Nav and Sidebar Dock.
      - sidebar provides quick jumping between Inventory, Hubs, Governance, and Corrections.
      - header provides breadcrumbs and global settings access.
    success_state: Navigating between modules takes < 2 clicks and feels like a single application.

frontend_first_sequence:
  - slice_1: Admin Dashboard Shell & KPI Widgets
    rationale: Establish the "Single Pane of Glass" before implementing complex backend aggregations.
    user_workflow: monitor_ecosystem_impact_realtime
    frontend_layout_controls:
      - `KpiCard`: Reusable component for impact and governance stats.
      - `TrustAlertFeed`: List component for critical system notifications.
      - `AdminSidebar`: Refactored Dock with synchronized links.
    image_slots:
      - Gauge SVGs for Quorum.
      - Icon set for KPIs (Water, Carbon, Community).

controls_routing:
  - GET /admin: Map to `AdminDashboardController@index`.
  - GET /admin/api/kpis: Real-time JSON endpoint for KPI refreshes.

backend_contract:
  - AdminDashboardService:
      - `getGlobalImpactStats()`: Aggregates sustainability data across all users/orders.
      - `getSystemIntegrityStats()`: Scans for hash mismatches and pending corrections.
      - `getActiveGovernanceSummary()`: Returns data for the quorum widget.
  - Model: `AdminActivityLog`: Records every admin action (Audit trail).

database_contract:
  - table: `admin_activity_logs`
    fields:
      - id (UUID)
      - user_id (FK, Admin)
      - action (String)
      - description (Text)
      - target_type (String)
      - target_id (String/UUID)
      - timestamp (DateTime)

verification_flow:
  - functional_testing:
      - "Ensure that changing a sustainability metric reflects in the global KPI card (post-aggregation)."
      - "Verify that the 'Trust Alert' feed updates when a new correction is proposed."
      - "Test that sidebar links accurately highlight the active module."
  - automated_tests:
      - Feature: `AdminDashboardAccessibilityTest`.
      - Unit: `ImpactAggregationTest`.

risks_unknowns:
  - performance of aggregating millions of records for real-time dashboard display (consider scheduled jobs + cache table).
