# Implementation Task List - Plan 12: Global Hub Expansion

plan: List plan/plan12/plan.md
workflow: List plan/plan12/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Global Hub UI
- [x] `task_12_1_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Create `GlobalHubMap` component shell with region markers. | files: `resources/views/livewire/hubs/global-map.blade.php` | functional_check: Component renders with markers for sample hubs (US/EU). | state: completed
- [x] `task_12_1_2` | source: `workflow.precise_user_flow.id_2` | rule: `frontend` | scope: Implement "Global Transit Alert" modal for international checkout. | files: `resources/views/components/shop/carbon-gate-modal.blade.php` | functional_check: Modal displays CO2 penalty and offset fee when shipping cross-border. | state: completed
- [x] `task_12_1_3` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Create `RegionSelector` component for manual location override. | files: `resources/views/livewire/geo/region-selector.blade.php` | functional_check: Allows users to switch regions and updates prices/hubs accordingly. | state: completed

## Phase 2: Controls & Routing - Geo Endpoints
- [x] `task_12_2_1` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Register routes for geo-detection and transit impact calculation. | files: `routes/web.php` | functional_check: `POST /api/geo/detect` returns JSON region data. | state: completed
- [x] `task_12_2_2` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Create `GeoRoutingController` to handle IP resolution and distance queries. | files: `app/Http/Controllers/GeoRoutingController.php` | functional_check: Controller correctly calls service layer and returns optimal hub. | state: completed

## Phase 3: Backend - Global Logic & Impact
- [x] `task_12_3_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `GeoRoutingService` with Haversine distance math. | files: `app/Services/GeoRoutingService.php` | functional_check: `getNearestHub` returns the closest hub based on lat/long. | state: completed
- [x] `task_12_3_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement dynamic `calculateTransitImpact` in `SustainabilityImpactService`. | files: `app/Services/SustainabilityImpactService.php` | functional_check: Returns different CO2 values for local land vs global air transit. | state: completed
- [x] `task_12_3_3` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `CurrencyService` for store credit conversion. | files: `app/Services/CurrencyService.php` | functional_check: Converts USD/EUR/JPY credits based on current exchange rates. | state: completed

## Phase 4: Database - Global Schema Updates
- [x] `task_12_4_1` | source: `workflow.database_contract` | rule: `database` | scope: Update `local_hubs` migration with coordinates and region codes. | files: `database/migrations/xxxx_update_local_hubs_for_global.php` | functional_check: Table supports lat/long and region-based querying. | state: completed
- [x] `task_12_4_2` | source: `workflow.database_contract` | rule: `database` | scope: Update `orders` migration with sourcing hub and offset fields. | files: `database/migrations/xxxx_update_orders_for_transit_tracking.php` | functional_check: Orders successfully store their environmental transit cost. | state: completed

## Phase 5: Seeders - Global Nodes
- [x] `task_12_5_1` | source: `plan.assumptions` | rule: `seeders` | scope: Seed international hubs in London, NYC, and Tokyo. | files: `database/seeders/GlobalHubSeeder.php` | functional_check: Database has a distributed network for testing. | state: completed

## Phase 6: Testing & Verification
- [x] `task_11_6_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `GeoDistanceTest` (Unit). | files: `tests/Unit/GeoDistanceTest.php` | functional_check: Confirms Haversine accuracy. | state: completed
- [x] `task_11_6_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `InternationalCheckoutTest` (Feature). | files: `tests/Feature/InternationalCheckoutTest.php` | functional_check: Verify carbon gate triggers and fees are applied. | state: completed
