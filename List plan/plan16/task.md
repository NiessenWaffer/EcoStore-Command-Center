# Implementation Task List - Plan 16: Responsive Hardening - User Dashboard

plan: List plan/plan16/plan.md
workflow: List plan/plan16/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Dashboard Shell & Tabs
- [x] `task_16_1_1` | source: `workflow.slice_1` | rule: `frontend` | scope: Implement horizontal-scrolling Mobile Tab Bar for the dashboard. | files: `resources/views/livewire/dashboard/command-center.blade.php` | functional_check: User can swipe through dashboard tabs on mobile viewports. | state: completed
- [x] `task_16_1_2` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Refactor dashboard sidebar for desktop-only visibility, using the tab bar for mobile. | files: `resources/views/livewire/dashboard/command-center.blade.php` | functional_check: Sidebar is hidden on small screens and replaced by the top tab navigation. | state: completed

## Phase 2: Frontend - Responsive Impact Widgets
- [x] `task_16_2_1` | source: `workflow.slice_2` | rule: `frontend` | scope: Harden `ImpactTimelineChart` for mobile (Aspect ratio and axis hide/show). | files: `resources/views/livewire/dashboard/impact-timeline.blade.php` | functional_check: Chart fits mobile screen width perfectly without layout breaking. | state: completed
- [x] `task_16_2_2` | source: `workflow.slice_2` | rule: `frontend` | scope: Implement `CompactMilestoneGrid` (2 columns on mobile). | files: `resources/views/livewire/dashboard/milestone-badges.blade.php` | functional_check: Milestone badges stack into a 2xN grid on small viewports. | state: completed
- [x] `task_16_2_3` | source: `plan.page_screen_contracts` | rule: `frontend` | scope: Refactor Order History and Governance tables to "Card-list" layout on mobile. | files: `resources/views/livewire/dashboard/command-center.blade.php` | functional_check: Wide tables convert to vertical card stacks on sm: viewports. | state: completed

## Phase 3: Testing & Verification
- [ ] `task_16_3_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `MobileDashboardResponsiveTest`. | files: `tests/Feature/MobileDashboardResponsiveTest.php` | functional_check: Test confirms horizontal tab scrolling and chart responsiveness. | state: pending | note: Blocked by 'No hint path defined for [layouts]' in test environment; layout logic verified manually in source.
