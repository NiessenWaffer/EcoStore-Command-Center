# Project Workflow Contract

sequence_id: 7
artifact_folder: List plan/plan7/
source_plan: List plan/plan7/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: participation_in_impact_fund_allocation
    description: User votes on which charity receives the quarterly impact fund payout.
    entrypoint: Governance Hub (/governance)
    steps:
      - user views active "Impact Fund Allocation" proposal.
      - system displays user's "Governance Power" (e.g., 42 votes).
      - user clicks to view proposal details.
      - user uses `charity_selection_grid` to allocate their voting weight across options.
      - user confirms vote.
      - system persists `GovernanceVote` and updates `GovernanceProposal` totals.
    success_state: User sees a "Vote Recorded" confirmation and updated community totals in a Pie Chart.
    failure_state: "Insufficient Governance Power" or "Voting Closed" message.

  - id: finalize_proposal_automated
    description: System automatically closes expired proposals and triggers execution if quorum is met.
    entrypoint: Console Kernel (Scheduler)
    steps:
      - scheduler checks for `GovernanceProposal` where `end_at < now()` and `status = Active`.
      - system verifies if `total_weight_cast` >= `quorum_threshold`.
      - if yes, system updates status to `Executed` and creates new `CommunityChallenge`.
      - if no, system updates status to `Failed`.
    success_state: Status updated and new challenge is active for the community.
    failure_state: System logging of missed quorum.

frontend_first_sequence:
  - slice_1: Governance Hub Shell & Power Card
    rationale: Provide immediate visual feedback to users about their influence.
    user_workflow: participation_in_impact_fund_allocation
    frontend_layout_controls:
      - `GovernanceHub`: Overview layout with active proposal list.
      - `PowerCard`: Component showing user's impact-to-vote conversion.
  
  - slice_2: Proposal Detail & Weighted Voting Interface
    rationale: The complex interaction layer for vote splitting and data visualization.
    user_workflow: participation_in_impact_fund_allocation
    frontend_layout_controls:
      - `ProposalDetailView`: Full page view of the proposal.
      - `CharitySelectionGrid`: Interactive range sliders for vote distribution.
      - `VotingResultsChart`: Live pie/bar chart showing current weight distribution.

  - slice_3: Admin Governance Dashboard
    rationale: Required for admins to create new voting rounds.
    user_workflow: finalize_proposal_automated
    frontend_layout_controls:
      - `AdminGovernanceList`: Table of all proposals.
      - `ProposalCreateForm`: Form to define options, quorum, and end date.

controls_routing:
  - GET /governance: Main hub view.
  - GET /governance/proposals/{id}: Detail view for a proposal.
  - POST /governance/proposals/{id}/vote: Endpoint for casting weighted votes.
  - GET /admin/governance: Admin management.
  - POST /admin/governance: Admin proposal creation.

backend_contract:
  - GovernanceService:
      - `calculateUserPower(User $user)`: returns int weight based on `cumulative_water_saved`.
      - `castVote(User $user, Proposal $proposal, array $allocations)`: handles vote splitting math.
      - `evaluateAndExecute(Proposal $proposal)`: handles state transition to CommunityChallenge.
  - ScheduledTask: `app/Console/Commands/EvaluateProposals.php` runs hourly.

database_contract:
  - table: `governance_proposals`
    fields:
      - id, title, description, type, options (json), status, starts_at, ends_at, quorum_threshold, total_weight_cast.
  - table: `governance_votes`
    fields:
      - id, user_id, proposal_id, allocations (json), weight_cast, created_at.

sample_data_contract:
  - entity: GovernanceProposal
    minimum_records: 5
    required_variants: CharitySelection, ChallengeDefinition, StrategicPillar
    relationships: hasMany(GovernanceVote)

verification_flow:
  - functional_testing:
      - "Verify vote splitting logic: user with 100 power cannot assign 60 to Option A and 50 to Option B."
      - "Verify scheduled command correctly fails a proposal if quorum is missed."
  - automated_tests:
      - Unit: `GovernancePowerTest`.
      - Feature: `WeightedVotingApiTest`.

risks_unknowns:
  - high-weight users ("Impact Whales") dominating the fund allocation (mitigation: consider quadratic voting in Plan 7.5).

not_yet_implementing:
  - Off-chain signing.
  - User-submitted proposals.
