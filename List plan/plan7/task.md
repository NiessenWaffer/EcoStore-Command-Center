# Implementation Task List - Plan 7: Community Governance

plan: List plan/plan7/plan.md
workflow: List plan/plan7/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Governance Interface
- [x] `task_7_1_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Create `GovernanceHub` Livewire component shell. | files: `resources/views/livewire/governance/hub.blade.php`, `app/Livewire/Governance/Hub.php` | functional_check: Hub renders with active proposal list. | state: completed
- [x] `task_7_1_2` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Implement `PowerCard` showing user's impact-to-vote conversion. | files: `resources/views/components/governance/power-card.blade.php` | functional_check: Card displays correct vote count based on user impact. | state: completed
- [x] `task_7_1_3` | source: `workflow.frontend_first_sequence.slice_2` | rule: `frontend` | scope: Create `ProposalDetailView` with live distribution chart. | files: `resources/views/livewire/governance/proposal-show.blade.php`, `app/Livewire/Governance/ProposalShow.php` | functional_check: Proposal details and charts render correctly. | state: completed
- [x] `task_7_1_4` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Implement `CharitySelectionGrid` with interactive range sliders for vote splitting. | files: `resources/views/components/governance/charity-selection-grid.blade.php` | functional_check: Sliders correctly update allocation totals. | state: completed
- [x] `task_7_1_5` | source: `workflow.frontend_first_sequence.slice_3` | rule: `frontend` | scope: Create `AdminGovernanceDashboard` and `ProposalCreateForm`. | files: `resources/views/livewire/admin/governance-manager.blade.php`, `app/Livewire/Admin/GovernanceManager.php` | functional_check: Admins can view and fill the proposal creation form. | state: completed

## Phase 2: Controls & Routing - Governance Endpoints
- [x] `task_7_2_1` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Define governance and admin governance routes in `web.php`. | files: `routes/web.php` | functional_check: All governance routes are reachable. | state: completed
- [x] `task_7_2_2` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Create `GovernanceController` to handle public interactions. | files: `app/Http/Controllers/GovernanceController.php` | functional_check: Controller redirects/returns views for hub and proposal details. | state: completed

## Phase 3: Backend - Governance Logic & Fund Management
- [x] `task_7_3_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `calculateUserPower` in `GovernanceService`. | files: `app/Services/GovernanceService.php` | functional_check: Power accurately reflects User impact / 100. | state: completed
- [x] `task_7_3_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `castVote` logic with validation for weight limits and splitting. | files: `app/Services/GovernanceService.php` | functional_check: Users cannot exceed their total power when splitting votes. | state: completed
- [x] `task_7_3_3` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `evaluateAndExecute` to transition Proposals to CommunityChallenges. | files: `app/Services/GovernanceService.php` | functional_check: Winning option correctly updates challenge targets. | state: completed
- [x] `task_7_3_4` | source: `workflow.backend_contract` | rule: `backend` | scope: Create `EvaluateProposals` console command for automated finalization. | files: `app/Console/Commands/EvaluateProposals.php` | functional_check: Command correctly closes expired proposals and executes them. | state: completed

## Phase 4: Database - Governance Schema
- [x] `task_7_4_1` | source: `workflow.database_contract` | rule: `database` | scope: Create migration for `governance_proposals` table. | files: `database/migrations/xxxx_create_governance_proposals_table.php` | functional_check: Table exists with status, quorum, and results fields. | state: completed
- [x] `task_7_4_2` | source: `workflow.database_contract` | rule: `database` | scope: Create migration for `governance_votes` table. | files: `database/migrations/xxxx_create_governance_votes_table.php` | functional_check: Table exists with user/proposal FKs and allocation JSON. | state: completed

## Phase 5: Seeders - Sample Proposals
- [x] `task_7_5_1` | source: `workflow.sample_data_contract` | rule: `seeders` | scope: Create `GovernanceSeeder` with active and past proposals. | files: `database/seeders/GovernanceSeeder.php` | functional_check: Seeder populates the hub with diverse voting scenarios. | state: completed

## Phase 6: Testing & Verification
- [x] `task_7_6_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `GovernancePowerTest` for unit testing weight calculation. | files: `tests/Unit/GovernancePowerTest.php` | functional_check: Tests pass for various impact scenarios. | state: completed
- [x] `task_7_6_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `WeightedVotingApiTest` for feature testing vote submissions. | files: `tests/Feature/WeightedVotingApiTest.php` | functional_check: API rejects over-spending of voting weight. | state: completed
