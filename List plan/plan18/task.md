# Implementation Task List - Plan 18: Data Hardening & Service Integration

plan: List plan/plan18/plan.md
workflow: List plan/plan18/workflow.md
status: completed

## Phase 1: Service Layer Hardening (Truth Engine)
- [x] `task_18_1_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement real SQL aggregation in `SustainabilityImpactService@getUserImpactHistory`. | files: `app/Services/SustainabilityImpactService.php` | functional_check: Returns exact sums from `order_items` and `resale_trade_ins` instead of random numbers. | state: completed
- [x] `task_18_1_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Harden `SustainabilityImpactService@calculateTransitImpact` with real coordinate logic. | files: `app/Services/SustainabilityImpactService.php` | functional_check: Uses `GeoRoutingService` to calculate distance between Hub and Destination. | state: completed
- [x] `task_18_1_3` | source: `workflow.backend_contract` | rule: `backend` | scope: Harden `AdminDashboardService` KPIs (Water, Carbon, Quorum). | files: `app/Services/AdminDashboardService.php` | functional_check: KPIs reflect real-time database counts across the whole ecosystem. | state: completed

## Phase 2: Frontend Integration (Mock Purge)
- [x] `task_18_2_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Update `ImpactTimelineChart` to use hardened service data. | files: `resources/views/livewire/dashboard/impact-timeline.blade.php` | functional_check: Chart bars match the user's actual order history. | state: completed
- [x] `task_18_2_2` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Update `MilestoneBadgeGrid` to check `user_milestones` table. | files: `resources/views/livewire/dashboard/milestone-badges.blade.php` | functional_check: Only achieved milestones (recorded in DB) are highlighted. | state: completed
- [x] `task_18_2_3` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Update Admin `DashboardStats` to use hardened service data. | files: `resources/views/livewire/admin/dashboard-stats.blade.php` | functional_check: Dashboard KPIs update instantly after database changes. | state: completed

## Phase 3: Performance & Caching
- [x] `task_18_3_1` | source: `plan.open_questions` | rule: `backend` | scope: Implement Redis tagging for impact aggregations. | files: `app/Services/SustainabilityImpactService.php`, `app/Services/AdminDashboardService.php` | functional_check: Cache is cleared automatically when new orders or resales are recorded. | state: completed

## Phase 4: Testing & Verification
- [x] `task_18_4_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `ImpactAggregationHardeningTest`. | files: `tests/Unit/ImpactAggregationHardeningTest.php` | functional_check: Unit test confirms math accuracy for mixed order/resale datasets. | state: completed
- [x] `task_18_4_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `LiveDashboardDataTest`. | files: `tests/Feature/LiveDashboardDataTest.php` | functional_check: Feature test verifies end-to-end data flow from DB to UI. | state: completed
