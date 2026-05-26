# Project Plan Contract

sequence_id: 10
artifact_name: admin_command_center
artifact_folder: List plan/plan10/
artifact_scope: admin_experience_and_ecosystem_monitoring
depends_on: 1, 6, 7, 8, 9
status: completed
mode: interactive_discovery
project_goal: Centralize all administrative functions into a singular "Ecosystem Pulse" dashboard, providing real-time visibility into sustainability impact, system integrity, and community governance.
target_users: brand admins, system auditors, sustainability officers
success_criteria:
  - Root `/admin` route displays a functional dashboard instead of a redirect.
  - 100% of "Trust Alerts" (hash mismatches or pending multi-sig) are visible on the dashboard.
  - Real-time KPI cards for "Community Water Saved" and "Active Governance Quorum".
  - Unified navigation synchronized between the sidebar (Dock) and header.
page_screen_contracts:
  - admin_dashboard_root: High-level overview featuring KPI widgets, a "Trust Alert" feed, and a "Recent Activity" log.
  - admin_system_health: Detailed view of cryptographic integrity stats and background job statuses.
  - admin_navigation_sync: A unified component structure ensuring the header and dock share the same link registry.
section_action_contracts:
  - kpi_widget: Dynamic card showing a metric (e.g., Total CO2 Offset) with a "View Details" link.
  - trust_alert_card: Red/Amber alert for pending multi-sig corrections or detected chain integrity issues.
  - quick_action_bar: A row of buttons for "Create Product", "Start Governance Round", or "Issue Correction".
design_content_strategy:
  - "Command & Control" aesthetic: dark-themed dashboard elements, neon "Success/Warning" indicators, and high-density data tables.
  - visibility focus: use charts (Line/Gauge) to show impact trends over time.
visual_asset_strategy:
  - dynamic gauge SVGs for quorum progress.
  - CSS-based "Live Pulse" animation for the system health indicator.
integration_context:
  related_plan_ids: 6, 7, 8, 9
  shared_entities: SustainabilityMetric, GovernanceProposal, PassportAuditLog, User
  dependencies: SustainabilityImpactService, GovernanceService, PassportService
  handoff_points: This plan unifies the entry points for all previous management modules.
connected_artifacts:
  connected_to: 6, 7, 8, 9
  connected_files: resources/views/components/layouts/admin.blade.php, resources/views/components/layouts/admin-dock.blade.php, routes/web.php
  connection_scope: administrative_cohesion
  connection_reason: Replaces fragmented management pages with a unified central hub.
  read_required_for_implementation: true
primary_user_workflows:
  - monitor_ecosystem_impact_realtime
  - respond_to_trust_integrity_alerts
  - manage_global_nav_and_management_access
workflow_logic_checks:
  - alert_prioritization: Multi-sig corrections and hash mismatches rank highest in the dashboard feed.
  - quorum_calculation_live: Real-time update of the "Voting Progress" widget for active proposals.
  - role_restricted_kpis: Certain financial KPIs only visible to Super Admins.
roles_permissions:
  - admin: access dashboard, view impact stats, respond to alerts.
  - super_admin: access financial reports and finalize high-impact corrections.
core_entities_data:
  - AdminActivityLog: user_id, action, target_entity, timestamp (Audit trail for admin actions).
  - DashboardCache: (Redis) Store pre-calculated impact totals for performance.
integrations:
  - Chart.js or Livewire-Charts: For visual impact data representation.
  - Redis: For caching high-volume impact aggregations.
notifications_reports:
  - daily_impact_summary_email
  - critical_integrity_failure_alert (SMS/Email)
MVP_scope:
  - Root Admin Dashboard with 3 KPI cards.
  - "Trust Alert" feed for pending Plan 9 corrections.
  - Unified Navigation component.
deferred_scope:
  - Advanced time-series impact charts.
  - Automated "System Health" report generation (PDF).
research_notes:
  - Evaluate performance of multi-table aggregations for dashboard KPIs.
  - Check Chart.js compatibility with the current Tailwind/Alpine stack.
assumptions:
  - Current service layers (Sustainability, Governance, Passport) provide raw data for aggregations.
  - Admins prefer a "Dark Mode" aesthetic for the command center.
open_questions:
  - Should the Admin Dashboard be customizable per user? (Decision: Fixed layout for MVP, customizable widgets deferred).
