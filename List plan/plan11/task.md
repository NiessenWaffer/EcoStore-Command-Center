# Implementation Task List - Plan 11: User Impact Portfolio & Quadratic Voting

plan: List plan/plan11/plan.md
workflow: List plan/plan11/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Impact Portfolio & QV UI
- [x] `task_11_1_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Create `ImpactTimelineChart` component shell. | files: `resources/views/livewire/dashboard/impact-timeline.blade.php` | functional_check: Component renders with chart placeholder in the "Eco Impact" tab. | state: completed
- [x] `task_11_1_2` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Implement `MilestoneBadgeGrid` with sample SVGs. | files: `resources/views/livewire/dashboard/milestone-badges.blade.php` | functional_check: Grid displays achievement icons with tooltips. | state: completed
- [x] `task_11_1_3` | source: `plan.page_screen_contracts` | rule: `frontend` | scope: Create `VerifiedCertificateView` elegant layout. | files: `resources/views/dashboard/certificate.blade.php` | functional_check: Certificate renders with high-fidelity typography and signature field. | state: completed
- [x] `task_11_1_4` | source: `plan.page_screen_contracts` | rule: `frontend` | scope: Refactor Governance UI for "Linear-to-Quadratic" toggle and slider. | files: `resources/views/livewire/governance/voting-slider.blade.php` | functional_check: UI updates resultant influence in real-time as cost changes. | state: completed

## Phase 2: Controls & Routing - Portfolio Endpoints
- [x] `task_11_2_1` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Register route for public certificate verification. | files: `routes/web.php` | functional_check: `/certificate/verify/{signature}` is reachable. | state: completed
- [x] `task_11_2_2` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Update `CommandCenter` tabs to include the new Impact Portfolio views. | files: `app/Livewire/Dashboard/CommandCenter.php`, `resources/views/livewire/dashboard/command-center.blade.php` | functional_check: "Eco Impact" tab displays the new components instead of static text. | state: completed

## Phase 3: Backend - Quadratic Math & Certificates
- [x] `task_11_3_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `calculateQuadraticInfluence` and `castQuadraticVote` in `GovernanceService`. | files: `app/Services/GovernanceService.php` | functional_check: Service correctly applies the square root formula to vote costs. | state: completed
- [x] `task_11_3_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `getUserImpactHistory` in `SustainabilityImpactService`. | files: `app/Services/SustainabilityImpactService.php` | functional_check: Returns monthly aggregated data from order/resale logs. | state: completed
- [x] `task_11_3_3` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `signImpactSummary` in `PassportService`. | files: `app/Services/PassportService.php` | functional_check: Generates a verifiable HMAC signature for the user's aggregate stats. | state: completed
- [x] `task_11_3_4` | source: `plan.workflow_logic_checks` | rule: `backend` | scope: Implement milestone threshold check and award logic. | files: `app/Services/SustainabilityImpactService.php` | functional_check: Records to `user_milestones` when thresholds are met. | state: completed

## Phase 4: Database - Governance & Milestone Schema
- [x] `task_11_4_1` | source: `workflow.database_contract` | rule: `database` | scope: Add `weighted_cost` and `resultant_influence` to `governance_votes` table. | files: `database/migrations/xxxx_update_governance_votes_table.php` | functional_check: Table supports decimal influence and integer costs. | state: completed
- [x] `task_11_4_2` | source: `workflow.database_contract` | rule: `database` | scope: Create `user_milestones` table. | files: `database/migrations/xxxx_create_user_milestones_table.php` | functional_check: Table exists with user FK and milestone type. | state: completed

## Phase 5: Seeders - Historical Impact
- [x] `task_11_5_1` | source: `workflow.sample_data_contract` | rule: `seeders` | scope: Seed users with historical order items spanning 6 months. | files: `database/seeders/UserActivitySeeder.php` | functional_check: Charts show interesting trend lines upon loading. | state: completed

## Phase 6: Testing & Verification
- [x] `task_11_6_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `QuadraticMathTest` (Unit). | files: `tests/Unit/QuadraticMathTest.php` | functional_check: Confirm QV influence math is 100% accurate. | state: completed
- [ ] `task_11_6_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `ImpactPortfolioVisualizationTest` (Feature). | files: `tests/Feature/ImpactPortfolioTest.php` | functional_check: Verify data correctly reaches the frontend components. | state: pending | note: Blocked by 'No hint path defined for [layouts]' in test environment; backend aggregation logic verified manually via unit-style test.
