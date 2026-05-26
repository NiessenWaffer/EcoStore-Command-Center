# Project Plan Contract

sequence_id: 7
artifact_name: community_governance_impact_fund
artifact_folder: List plan/plan7/
artifact_scope: decentralized_governance_and_impact_allocation
depends_on: 1, 2, 3, 6
status: completed
mode: interactive_discovery
project_goal: Empower the community to direct brand impact by implementing a decentralized governance system where influence is earned through sustainable actions.
target_users: Ambassadors, eco-conscious consumers, partner charities
success_criteria:
  - 100% of community-funded donations are decided via impact-weighted voting.
  - Users can see their individual "Governance Power" based on their verified sustainability history.
  - Winning proposals are automatically executed as new Community Challenges.
page_screen_contracts:
  - governance_hub: overview of active proposals, user's voting weight, "Governance History" (past wins).
  - proposal_detail_page: deep dive into a specific charity or challenge proposal, real-time voting results, discussion/comment section.
  - impact_fund_tracker: visual display of the "Community Pot" (1% revenue allocation) and total donations to date.
  - admin_governance_dashboard: UI for admins to create proposals, monitor quorum, and execute winning proposals.
section_action_contracts:
  - voting_control: UI allowing users to cast their weighted vote (1 vote = 100L Water Saved).
  - governance_power_card: display user's "Eco-Governance Score" derived from `cumulative_water_saved`.
  - proposal_status_badge: Dynamic badge indicating state (Draft, Active, Quorum Met, Failed, Executed).
  - charity_selection_grid: UI component on the detail page allowing users to split their vote across multiple options (e.g., 50% to Charity A, 50% to Charity B via range sliders).
design_content_strategy:
  - "Democratic & Impactful" aesthetic: inclusive imagery, progress bars for voting, clear "Power of Community" messaging.
  - transparent allocation: show the "Proof of Donation" (links to Plan 6 audit logs) for every fund payout.
visual_asset_strategy:
  - dynamic charts (Pie/Bar) for voting distributions.
  - "Community Champion" badges for users who participated in successful proposals.
integration_context:
  related_plan_ids: 1, 2, 3, 6
  shared_entities: User, CommunityChallenge, GovernanceProposal, GovernanceVote
  dependencies: CreditService, SustainabilityImpactService, PassportService
  handoff_points: `GovernanceProposal` completion triggers `CommunityChallenge` activation.
connected_artifacts:
  connected_to: 2, 6
  connected_files: app/Models/User.php, app/Models/CommunityChallenge.php
  connection_scope: user_agency_and_impact_allocation
  connection_reason: Leverages user sustainability metrics to drive brand governance.
  read_required_for_implementation: true
primary_user_workflows:
  - participate_in_impact_fund_allocation
  - vote_on_next_community_challenge
  - view_governance_transparency_report
workflow_logic_checks:
  - voting_weight_calculation: Weight = Floor(User.cumulative_water_saved / 100).
  - quadratic_voting_check: (Optional) Evaluate if quadratic voting should be used to prevent whales from dominating.
  - proposal_threshold: A minimum participation rate (Quorum) must be met for a proposal to pass.
  - fund_isolation: Ensure the "Impact Fund" is a dedicated balance in `CreditService` and cannot be used for general operations.
roles_permissions:
  - customer: browse proposals, view impact fund.
  - ambassador: vote on proposals (weight > 0).
  - admin: create proposals, finalize results, manage fund deposits.
core_entities_data:
  - GovernanceProposal: title, description, type (Charity/Challenge), options (JSON), status (Draft/Active/Executed), end_at, total_weight_cast, quorum_threshold.
  - GovernanceVote: user_id, proposal_id, allocations (JSON), weight_cast.
  - ImpactFund: (Virtual via CreditService) balance_cents, total_allocated_cents, last_deposit_at.
integrations:
  - Internal Logic: Linking `GovernanceProposal` results to the `CommunityChallenge` engine.
  - Automated Scheduling: Laravel task scheduler for closing expired proposals.
notifications_reports:
  - new_proposal_alert
  - proposal_result_recap
  - quarterly_community_impact_report
MVP_scope:
  - Governance Hub for voting on the next `CommunityChallenge` charity.
  - Impact-weighted voting logic.
  - Basic Impact Fund tracking (Total Pot).
deferred_scope:
  - User-submitted proposals.
  - Delegation of voting power.
  - Quadratic voting implementation.
research_notes:
  - check performance of querying all user impact metrics for real-time weight updates.
  - determine optimal "Governance Quorum" for the community size.
assumptions:
  - Users' `cumulative_water_saved` is the primary source of truth for governance weight.
  - 1% revenue allocation is a fixed business rule.
open_questions:
  - Should users be allowed to split their votes between multiple options? (Answer: Yes, for charity selection).
  - How do we handle "Vote Farming"? (Answer: Verification Layer from Plan 6 ensures only genuine actions count).
