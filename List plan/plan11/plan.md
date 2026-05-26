# Project Plan Contract

sequence_id: 11
artifact_name: user_impact_portfolio_and_quadratic_voting
artifact_folder: List plan/plan11/
artifact_scope: user_empowerment_and_fair_governance
depends_on: 1, 7, 9, 10
status: completed
mode: interactive_discovery
project_goal: Elevate the user's emotional and social connection to the ecosystem by visualizing their verified impact and implementing a fairer, more democratic community fund allocation via Quadratic Voting.
target_users: active customers, community ambassadors, governance participants
success_criteria:
  - User Dashboard features a "Personal Impact Timeline" with monthly trends.
  - Users can download a "Verified Impact Certificate" signed by the brand.
  - Governance voting power is calculated using the square root of the user's impact-weighted votes (Quadratic).
  - 100% of governance calculations are auditable via the Trust Layer.
page_screen_contracts:
  - user_impact_portfolio: A dedicated section in the CommandCenter featuring trend charts and "Achievement Milestones."
  - verified_certificate_view: A high-fidelity, printable/shareable view of the user's cumulative sustainability stats.
  - quadratic_voting_ui: Updated governance interface showing "Voting Cost" vs. "Impact Influence."
section_action_contracts:
  - impact_trend_chart: Visual representation of Water/Carbon savings over time (monthly/yearly).
  - download_impact_certificate: Generates a signed PDF or PNG of the user's impact summary.
  - cast_quadratic_vote: UI slider or input that calculates and displays the quadratic cost of additional votes.
design_content_strategy:
  - "verified_pride" aesthetic: Elegant, certificate-style typography, gold/emerald accents for milestones, and high-quality charts.
  - transparency focus: Show the math behind the Quadratic Vote to educate the community on fairness.
visual_asset_strategy:
  - Milestone Badge SVGs (e.g., "Water Guardian", "Carbon Neutral Pioneer").
  - Dynamic sparkline SVGs for the dashboard.
integration_context:
  related_plan_ids: 7, 9, 10
  shared_entities: User, GovernanceProposal, GovernanceVote, SustainabilityMetric
  dependencies: GovernanceService, SustainabilityImpactService, PassportService (for signing)
  handoff_points: This plan completes the "Ambassador" journey by providing tangible proof of their ecological influence.
connected_artifacts:
  connected_to: 7, 10
  connected_files: app/Services/GovernanceService.php, app/Livewire/Dashboard/CommandCenter.php, resources/views/livewire/dashboard/command-center.blade.php
  connection_scope: fair_influence_and_impact_proof
  connection_reason: Hardens the governance math and elevates the user's sense of contribution.
  read_required_for_implementation: true
primary_user_workflows:
  - visualize_personal_impact_trends
  - generate_and_share_impact_certificate
  - participate_in_fair_quadratic_voting
workflow_logic_checks:
  - quadratic_cost_calc: $influence = \sqrt{cost}$. The UI must update influence in real-time as users adjust their vote weight.
  - certificate_integrity: The certificate's unique ID must be verifiable against the `PassportAuditLog`.
  - milestone_triggers: Auto-award badges when specific cumulative thresholds (e.g., 10,000L water) are met.
roles_permissions:
  - user: view portfolio, download certificate, cast quadratic votes.
  - admin: configure milestone thresholds, oversee quadratic distributions.
core_entities_data:
  - User: (Existing) `eco_tier` and `cumulative_*` stats used for visualizations.
  - GovernanceVote: Add `weighted_cost` and `resultant_influence` fields to store QV results.
integrations:
  - DomPDF or Browsershot: For certificate generation.
  - Chart.js (via Livewire components): For the impact timeline.
notifications_reports:
  - milestone_achieved_notification
  - governance_round_fairness_report
MVP_scope:
  - Time-series "Impact Pulse" widget for users.
  - Web-based "Impact Certificate" view (Download deferred).
  - Quadratic Voting logic in `GovernanceService`.
deferred_scope:
  - PDF/PNG export for certificates.
  - Social media "Share to Instagram" API integration.
research_notes:
  - Investigate the most efficient way to perform square-root weighted aggregations in SQL.
  - Determine if `PassportService` HMAC logic can be used for the certificate "Signature."
assumptions:
  - Users have enough historical data to generate interesting trend lines.
  - The community understands/accepts the Quadratic Voting model for fairness.
open_questions:
  - Should the "Impact Certificate" show the dollar value of the store credit earned? (Decision: Focus on sustainability metrics first to maintain the "Ecosystem over Ego" vibe).
