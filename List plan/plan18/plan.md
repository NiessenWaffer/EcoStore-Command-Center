# Project Plan Contract

sequence_id: 18
artifact_name: data_hardening_and_service_integration
artifact_folder: List plan/plan18/
artifact_scope: technical_integrity_and_data_truth
depends_on: 11, 12, 17
status: ready_for_workflow
mode: interactive_discovery
project_goal: Eliminate all simulated data (rand() and hardcoded arrays) from the platform, replacing them with live database aggregations and precise mathematical models to ensure 100% auditable transparency.
target_users: ambassadors, brand admins, sustainability auditors
success_criteria:
  - 100% removal of `rand()` calls in the service and component layers.
  - User Impact Portfolio displays trends calculated from actual `OrderItem` and `ResaleTradeIn` history.
  - Global Transit Impact is calculated using real Hub-to-Destination coordinate distances (Haversine).
  - Admin Dashboard KPIs reflect real-time database counts for all system health and governance metrics.
  - All Livewire components fetch state from the hardened service layer instead of local mock arrays.
page_screen_contracts:
  - user_impact_portfolio_hardened: Displays real time-series data based on verified user actions.
  - checkout_impact_verification: Real-time calculation of CO2 based on shipping ZIP and sourcing Hub.
section_action_contracts:
  - live_impact_aggregation: SQL-driven calculation of cumulative water/carbon savings.
  - vote_tally_engine: Real-time weight-based quorum calculation for governance.
design_content_strategy:
  - "Truth as a Feature": Explicitly label data as "Live Aggregation" or "Verified Data" to reinforce brand trust.
visual_asset_strategy: none
integration_context:
  related_plan_ids: 11, 12, 17
  shared_entities: OrderItem, ResaleTradeIn, GovernanceVote, LocalHub
  dependencies: SustainabilityImpactService, GeoRoutingService, AdminDashboardService
  handoff_points: Final technical hardening before production-readiness.
connected_artifacts:
  connected_to: 11, 12, 17
  connected_files: app/Services/SustainabilityImpactService.php, app/Services/AdminDashboardService.php, app/Services/GeoRoutingService.php, resources/views/livewire/dashboard/impact-timeline.blade.php
  connection_scope: data_integrity_and_truth
  connection_reason: Replaces the simulation layer with actual business logic connected to the database.
  read_required_for_implementation: true
primary_user_workflows:
  - view_actual_impact_history
  - calculate_real_transit_penalty
  - monitor_live_governance_quorum
workflow_logic_checks:
  - data_empty_state: Ensure components handle new users with zero history gracefully (without crashing or showing 0 everywhere).
  - query_performance: Use Eloquent aggregations (Sum, Count) instead of loading full collections to maintain dashboard speed.
roles_permissions: none
core_entities_data: none
integrations: none
notifications_reports: none
MVP_scope:
  - Hardened `SustainabilityImpactService` (Order/Resale aggregation).
  - Hardened `GeoRoutingService` (Real coordinate math).
  - Hardened `AdminDashboardService` (Live vote tally).
deferred_scope:
  - Third-party API integration for real-time shipping carrier distance queries.
research_notes:
  - Optimize the `getUserImpactHistory` query to group by month efficiently in SQL.
assumptions:
  - Sufficient order and resale data exists in the seeder to test aggregation logic.
open_questions:
  - Should we cache the aggregations for performance? (Decision: Yes, use Redis tags for easy clearing on new transactions).
