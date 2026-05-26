# Implementation Task List - Plan 9: Ownership Transfer & Correction Governance

plan: List plan/plan9/plan.md
workflow: List plan/plan9/workflow.md
status: task_generation_complete

## Phase 1: Frontend - Transfer & Claim UI
- [x] `task_9_1_1` | source: `workflow.frontend_first_sequence.slice_1` | rule: `frontend` | scope: Create `TransferInitializationCard` component shell. | files: `resources/views/livewire/passports/transfer-initialization.blade.php` | functional_check: Component renders with "Initiate Transfer" button and token placeholder. | state: completed
- [x] `task_9_1_2` | source: `plan.page_screen_contracts` | rule: `frontend` | scope: Create `ClaimVerificationView` full-page layout. | files: `resources/views/passports/claim.blade.php` | functional_check: Page displays product history timeline for the buyer to review. | state: completed
- [x] `task_9_1_3` | source: `plan.section_action_contracts` | rule: `frontend` | scope: Implement "Claim" form with token validation feedback. | files: `resources/views/livewire/passports/claim-form.blade.php` | functional_check: Form allows entering a token and shows a success animation on "Accept". | state: completed
- [x] `task_9_1_4` | source: `plan.page_screen_contracts` | rule: `frontend` | scope: Create `AdminCorrectionQueue` view. | files: `resources/views/admin/corrections/index.blade.php` | functional_check: List displays pending correction proposals with "Review" buttons. | state: completed

## Phase 2: Controls & Routing - Transfer Endpoints
- [x] `task_9_2_1` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Register routes for transfer initialization, claim landing, and admin corrections. | files: `routes/web.php` | functional_check: `php artisan route:list` shows new endpoints. | state: completed
- [x] `task_9_2_2` | source: `workflow.controls_routing` | rule: `controls_routing` | scope: Create `PassportTransferController` for token-based claim verification. | files: `app/Http/Controllers/PassportTransferController.php` | functional_check: Controller resolves claim tokens and returns the correct view. | state: completed

## Phase 3: Backend - Transfer & Correction Logic
- [x] `task_9_3_1` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `initiateTransfer` in `PassportService`. | files: `app/Services/PassportService.php` | functional_check: Creates `PassportTransfer` record and generates secure token. | state: completed
- [x] `task_9_3_2` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `completeTransfer` in `PassportService`. | files: `app/Services/PassportService.php` | functional_check: Updates passport owner, records audit log, and marks transfer as completed. | state: completed
- [x] `task_9_3_3` | source: `plan.workflow_logic_checks` | rule: `backend` | scope: Implement token expiry and ownership lock checks. | files: `app/Services/PassportService.php` | functional_check: Block transfers if one is already pending or token is >48h old. | state: completed
- [x] `task_9_3_4` | source: `workflow.backend_contract` | rule: `backend` | scope: Implement `proposeCorrection` and `finalizeCorrection` in `PassportService`. | files: `app/Services/PassportService.php` | functional_check: Proposal requires 2 signatures before appending to the audit log. | state: completed
- [x] `task_9_3_5` | source: `plan.core_entities_data` | rule: `backend` | scope: Implement "Chain of Ownership" masking logic for the timeline. | files: `app/Models/PassportAuditLog.php` | functional_check: Timeline displays "Owner X" instead of user names for external viewers. | state: completed

## Phase 4: Database - Transfer Schema
- [x] `task_9_4_1` | source: `workflow.database_contract` | rule: `database` | scope: Create migration for `passport_transfers` table. | files: `database/migrations/xxxx_create_passport_transfers_table.php` | functional_check: Table exists with FKs, token, status, and expiry fields. | state: completed
- [x] `task_9_4_2` | source: `plan.core_entities_data` | rule: `database` | scope: Add `governance_approval_id` to `passport_audit_logs` table. | files: `database/migrations/xxxx_add_governance_link_to_audit_logs.php` | functional_check: Migration runs successfully. | state: completed

## Phase 5: Seeders - Transfer Scenarios
- [x] `task_9_5_1` | source: `workflow.sample_data_contract` | rule: `seeders` | scope: Seed sample pending and completed transfers. | files: `database/seeders/PassportTransferSeeder.php` | functional_check: Database has valid test data for UI development. | state: completed

## Phase 6: Testing & Verification
- [x] `task_9_6_1` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `OwnershipTransferTest` (Feature). | files: `tests/Feature/OwnershipTransferTest.php` | functional_check: Tests pass for P2P transfer handshake. | state: completed
- [x] `task_9_6_2` | source: `workflow.verification_flow` | rule: `testing` | scope: Create `CorrectionGovernanceTest` (Unit). | files: `tests/Unit/CorrectionGovernanceTest.php` | functional_check: Tests pass for multi-admin signature requirements. | state: completed
