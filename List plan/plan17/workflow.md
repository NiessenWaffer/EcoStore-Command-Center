# Project Workflow Contract

sequence_id: 17
artifact_folder: List plan/plan17/
source_plan: List plan/plan17/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: monitor_system_health_on_mobile
    description: Admin checks the status of the ecosystem while away from their desktop.
    entrypoint: Admin Dashboard (/admin)
    steps:
      - user logs in via a mobile viewport.
      - system displays the "System Health" KPI at the top of the single-column layout.
      - user scrolls down to see the "Trust Alert Feed".
      - system renders high-density cards for each alert with direct "Resolve" buttons.
    success_state: Critical system info is visible without horizontal scrolling.

  - id: manage_global_inventory_on_mobile
    description: Admin reviews hub inventory and distributed logistics on a small screen.
    entrypoint: Admin -> Global Hub Map
    steps:
      - system renders the `GlobalHubMap`.
      - on mobile, the map takes up the full width; user pans to find a hub.
      - user taps a hub marker (e.g., London).
      - system opens a bottom-sheet (instead of a hover card) showing hub capabilities and "Inventory" link.
      - user taps "Browse Inventory" and navigates to the hub-specific list.
    success_state: Geographical management is intuitive and optimized for touch.

frontend_first_sequence:
  - slice_1: Mobile Admin Shell & KPI Cards
    rationale: Establishes the operational baseline. Ensuring KPIs and Shell work on mobile is the first priority for on-the-go managers.
    user_workflow: monitor_system_health_on_mobile
    frontend_layout_controls:
      - `ResponsiveKpiStack`: single-column grid.
      - `MobileAdminDrawer`: sidebar conversion.
    image_slots: none

  - slice_2: High-Density Mobile Tables
    rationale: Admins need to see data history. Converting wide tables to card lists is essential for legibility.
    user_workflow: monitor_system_health_on_mobile
    frontend_layout_controls:
      - `ActivityCardList`: replaces the desktop table on sm viewports.
    image_slots: none

controls_routing: none

backend_contract: none

database_contract: none

verification_flow:
  - functional_testing:
      - "Verify that 'Trust Alerts' are actionable via a single thumb tap."
      - "Ensure that the 'Infrastructure Status' badges are large enough to be legible on 320px screens."
      - "Test that the 'Admin Dock' (from Plan 8) properly collapses on mobile to avoid obscuring dashboard data."
  - automated_tests:
      - Feature: `MobileAdminResponsiveTest`.

risks_unknowns:
  - Data density: ensuring that reducing table columns on mobile doesn't hide "too much" critical data from auditors.
