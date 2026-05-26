# Project Plan Contract

sequence_id: 16
artifact_name: responsive_hardening_user_dashboard
artifact_folder: List plan/plan16/
artifact_scope: mobile_first_ambassador_portfolio_ux
depends_on: 2, 11, 14
status: completed
mode: interactive_discovery
project_goal: Harden the User Command Center for mobile-first excellence, ensuring that the high-fidelity "Impact Portfolio," "Achievement Milestones," and "Ambassador Tools" are as intuitive on a smartphone as they are on desktop.
target_users: eco-ambassadors, active circularity participants
success_criteria:
  - Dashboard Tab navigation is optimized for touch (swipeable bar or compact select).
  - "Impact Pulse" charts scale perfectly without losing axis legibility.
  - "Milestone Badge Grid" adjusts to 2 columns with clear tap states for achievement details.
  - "Digital Impact Certificate" features a responsive preview that fits standard smartphone screens.
  - Zero layout breaking in the "Order History" or "Active Proposals" tables on mobile.
page_screen_contracts:
  - responsive_dashboard_tabs: A persistent, touch-friendly tab system.
  - mobile_impact_pulse: Reconfigured charts with vertical legends and optimized point-radius for touch.
  - digital_wallet_certificate: A "Card-first" view of the verified impact certificate.
section_action_contracts:
  - switch_dashboard_tab: Triggered via horizontal swipe or top-bar tap.
  - view_milestone_detail: Mobile-optimized modal for badge explanations.
  - share_certificate_mobile: Dedicated mobile share sheet trigger.
design_content_strategy:
  - "Dashboard-as-App" aesthetic: Use high-contrast dividers, large iconography, and clear "Empty States" for mobile users.
  - Gesture Focus: Implement "Swipe to Refresh" or "Swipe between Tabs" using Alpine.js logic.
visual_asset_strategy:
  - Dynamic SVGs: Ensure charts use responsive viewBox settings to prevent pixelation on high-DPI mobile screens.
  - Icon-Centric UI: Prioritize icons over text labels in the tab bar if space is critical (with text backup).
integration_context:
  related_plan_ids: 11, 14
  shared_entities: User, Milestone, GovernanceVote
  dependencies: none
  handoff_points: Finalizes the "Ambassador Journey" for mobile-first growth.
connected_artifacts:
  connected_to: 11, 14
  connected_files: app/Livewire/Dashboard/CommandCenter.php, resources/views/livewire/dashboard/command-center.blade.php, resources/views/livewire/dashboard/impact-timeline.blade.php
  connection_scope: dashboard_responsiveness
  connection_reason: The dashboard contains the highest data density; mobile hardening is essential for user retention.
  read_required_for_implementation: true
primary_user_workflows:
  - track_impact_on_mobile
  - claim_achievements_via_phone
  - share_impact_to_socials_from_mobile
workflow_logic_checks:
  - chart_aspect_ratio: Maintain 4:3 or 1:1 ratios on mobile to preserve vertical space.
  - mobile_table_overflow: Ensure tables use "Card-list" layout or horizontal scroll indicators.
roles_permissions:
  - user: manages their portfolio on mobile.
core_entities_data: none
integrations: none
notifications_reports: none
MVP_scope:
  - Responsive Dashboard Shell (Tabs).
  - Mobile-optimized Impact Charts.
  - 2-Column Milestone Grid.
deferred_scope:
  - Full PWA (Progressive Web App) manifest for "Home Screen" installation.
  - Native iOS/Android share-sheet deep linking.
research_notes:
  - Test `chart.js` responsive options specifically for mobile viewports.
assumptions:
  - Users will primarily consume impact data in "Portrait" mode.
open_questions:
  - Should the "Resale History" table be converted to a "Card List" for mobile? (Decision: Yes, tables > 3 columns are converted to vertical cards on mobile).
