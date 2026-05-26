# Implementation Task List - Plan 8: Unified Brand Experience

plan: List plan/plan8/plan.md
workflow: List plan/plan8/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Global Cohesion
- [x] `task_8_1_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Refactor `layouts.app` header with Mega-Menu dropdowns (Circularity, Community). | files: `resources/views/components/layouts/app.blade.php`, `resources/views/components/nav/mega-menu.blade.php` | functional_check: Dropdowns reveal on hover/click and contain all functional links. | state: completed
- [x] `task_8_1_2` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Implement `ImpactTicker` in header showing collective water saved. | files: `resources/views/components/nav/impact-ticker.blade.php` | functional_check: Ticker displays dynamic data from GlobalImpactService. | state: completed
- [x] `task_8_1_3` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Update `layouts.app` footer with 4-column "Site Map" layout. | files: `resources/views/components/layouts/app.blade.php` | functional_check: Footer contains links to Returns, Tracking, Metrics, and Mission. | state: completed
- [x] `task_8_1_4` | source: `workflow.frontend_first_sequence.slice_2` | rule: `frontend` | scope: Refactor `dashboard.index` into a tabbed "Command Center" layout. | files: `resources/views/dashboard/index.blade.php`, `app/Livewire/Dashboard/CommandCenter.php` | functional_check: Tabs switch content without full page reload. | state: completed
- [x] `task_8_1_5` | source: `workflow.frontend_first_sequence.slice_3` | rule: `frontend` | scope: Create `AdminQuickDock` sidebar for privileged users. | files: `resources/views/components/layouts/admin-dock.blade.php` | functional_check: Dock is visible only to admins and provides links to all admin modules. | state: completed

## Phase 2: Controls & Routing - Deep Linking
- [x] `task_8_2_1` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Update dashboard route to support optional `{tab}` parameter for deep linking. | files: `routes/web.php` | functional_check: `/dashboard/governance` opens the dashboard with the governance tab active. | state: completed
- [x] `task_8_2_2` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Implement `NavigationService` to handle active section highlighting logic. | files: `app/Services/NavigationService.php` | functional_check: Header correctly highlights "Circularity" when visiting resale or passports. | state: completed

## Phase 3: Backend - Integration & Data Aggregation
- [x] `task_8_3_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Update `GlobalImpactService` with `getCollectiveImpact()` method. | files: `app/Services/GlobalImpactService.php` | functional_check: Returns sum of impact metrics across all users. | state: completed
- [x] `task_8_3_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Ensure all existing Livewire components are compatible with `wire:lazy` loading in tabs. | files: `app/Livewire/Governance/Hub.php`, `app/Livewire/Shop/ProductList.php` | functional_check: Dashboard performance remains high with multiple tabs. | state: completed

## Phase 4: Testing & Cohesion Verification
- [ ] `task_8_4_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `GlobalNavigationTest` to verify all menu links are functional. | files: `tests/Feature/GlobalNavigationTest.php` | functional_check: Crawls all header/footer links and asserts 200 OK. | state: unchecked
- [ ] `task_8_4_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `CommandCenterTabTest` to verify tab state persistence. | files: `tests/Feature/CommandCenterTabTest.php` | functional_check: Asserts correct component is loaded based on URL param. | state: unchecked
- [ ] `task_8_4_3` | source: `plan.success_criteria` | rule: `testing` | scope: Manual verification of mobile menu responsiveness and accordion behavior. | files: `resources/views/components/layouts/app.blade.php` | functional_check: All functional links are reachable on mobile screen sizes. | state: unchecked
