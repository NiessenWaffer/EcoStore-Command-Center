# Project Workflow Contract

sequence_id: 16
artifact_folder: List plan/plan16/
source_plan: List plan/plan16/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: navigate_dashboard_tabs_on_mobile
    description: User switches between impact, governance, and orders using a mobile-first navigation bar.
    entrypoint: Dashboard (/dashboard)
    steps:
      - user lands on the dashboard.
      - system displays a horizontal-scrolling tab bar at the top (Impact, Orders, Governance, Referrals).
      - user swipes left to reveal more tabs or taps a visible tab.
      - system updates the `activeTab` state and renders the new content without a full page reload.
    success_state: Switching views is fast and responsive to touch.

  - id: view_impact_trends_on_mobile
    description: User analyzes their sustainability contributions via optimized mobile charts.
    entrypoint: Dashboard -> Impact Tab
    steps:
      - system renders the `ImpactTimelineChart`.
      - on mobile viewports, system hides complex secondary axes and centers the primary trend bars.
      - user taps a bar to see specific values (Tooltips optimized for touch).
      - system displays achieved milestones in a compact 2-column grid below the chart.
    success_state: Data visualization is clear and fits the screen width perfectly.

  - id: share_milestone_on_mobile
    description: User shares a circularity achievement to their social network.
    entrypoint: Dashboard -> Impact -> Milestone Grid
    steps:
      - user taps an achieved milestone badge (e.g., "Water Guardian").
      - system opens a mobile-optimized modal with a "Share to Socials" button.
      - user taps "Share".
      - system triggers the device's native share sheet (via Web Share API where supported).
    success_state: Social growth is enabled via seamless mobile-first sharing.

frontend_first_sequence:
  - slice_1: Mobile Dashboard Shell
    rationale: The container and navigation logic must be hardened before the individual widgets can be optimized.
    user_workflow: navigate_dashboard_tabs_on_mobile
    frontend_layout_controls:
      - `MobileTabBar`: scrolling component.
      - `ActiveTabHighlight`: visual indicator.
    image_slots: none

  - slice_2: Responsive Impact Widgets
    rationale: High-value data must be legible. Hardening the charts and milestones completes the dashboard's core mission.
    user_workflow: view_impact_trends_on_mobile
    frontend_layout_controls:
      - `ResponsiveChartContainer`: ensures aspect-ratio maintenance.
      - `CompactMilestoneGrid`: 2-column flex layout.
    image_slots:
      - Milestone SVGs.

controls_routing: none

backend_contract: none

database_contract: none

verification_flow:
  - functional_testing:
      - "Verify that horizontal scrolling in the tab bar works smoothly on touch devices."
      - "Ensure chart tooltips are triggerable by a single tap and don't flicker."
      - "Confirm that 'Empty State' illustrations (e.g., 'No Orders Yet') scale correctly for small screens."
  - automated_tests:
      - Feature: `MobileDashboardResponsiveTest`.

risks_unknowns:
  - Canvas scaling in Charts: ensure `Chart.js` doesn't over-render and cause performance lag on older mobile devices.
