# Implementation Task List - Plan 15: Responsive Hardening - Shop & Catalog

plan: List plan/plan15/plan.md
workflow: List plan/plan15/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Responsive Catalog (Product List)
- [x] `task_15_1_1` | source: `workflow.slice_1` | rule: `frontend` | scope: Implement Mobile Filter Drawer (Bottom Sheet) for the shop. | files: `resources/views/livewire/shop/product-list.blade.php` | functional_check: "Filter & Sort" button appears on mobile and toggles a full-screen/bottom-sheet drawer. | state: completed
- [x] `task_15_1_2` | source: `workflow.slice_1` | rule: `frontend` | scope: Harden Product Grid for mobile (2 columns on small screens). | files: `resources/views/livewire/shop/product-list.blade.php` | functional_check: Grid displays 2 items per row on sm: viewports without breaking layout. | state: completed
- [x] `task_15_1_3` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Add "+" Quick Add overlay for mobile product cards. | files: `resources/views/livewire/shop/product-list.blade.php` | functional_check: Small "+" icon is visible and functional on mobile grid items. | state: completed

## Phase 2: Frontend - Responsive PDP (Product Show)
- [x] `task_15_2_1` | source: `workflow.slice_2` | rule: `frontend` | scope: Implement Stacked Mobile Layout for PDP (Gallery -> Title -> Impact). | files: `resources/views/livewire/shop/product-show.blade.php` | functional_check: Content follows vertical flow on mobile with appropriate padding. | state: completed
- [x] `task_15_2_2` | source: `workflow.slice_2` | rule: `frontend` | scope: Create Sticky "Add to Bag" bar for mobile viewports. | files: `resources/views/livewire/shop/product-show.blade.php` | functional_check: CTA bar persists at bottom of screen on mobile during scroll. | state: completed
- [x] `task_15_2_3` | source: `plan.visual_asset_strategy` | rule: `frontend` | scope: Enable touch-optimized "Impact Index" gauge scaling. | files: `resources/views/livewire/shop/product-show.blade.php` | functional_check: Gauge is legible and sized correctly for 375px screens. | state: completed

## Phase 3: Testing & Verification
- [ ] `task_15_3_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `MobileShopResponsiveTest`. | files: `tests/Feature/MobileShopResponsiveTest.php` | functional_check: Test confirms filter drawer accessibility and sticky CTA visibility. | state: pending
