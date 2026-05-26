# Project Plan Contract

sequence_id: 9
artifact_name: ownership_transfer_and_correction_governance
artifact_folder: List plan/plan9/
artifact_scope: trust_layer_maturity_and_circular_transfer
depends_on: 6, 7
status: completed
mode: interactive_discovery
project_goal: Secure the circular economy loop by implementing a cryptographic ownership transfer mechanism for product passports and a multi-party governance process for history corrections.
target_users: resale buyers, resale sellers, brand admins, auditors
success_criteria:
  - 100% of ownership transfers are recorded as signed events in the immutable audit log.
  - Ownership transfer requires mutual consent (Seller Init -> Buyer Accept) or a verified Resale Hub verification.
  - "Correction" events must be approved by a "Governance Review" if they exceed a certain impact threshold.
  - Users can see a "Chain of Ownership" in the passport timeline without exposing private user PII (use masked IDs).
page_screen_contracts:
  - ownership_transfer_portal: UI for a user to "Release" a passport to a new owner via secure token or QR code.
  - transfer_verification_page: Landing page for the new owner to "Claim" and verify the product's history before accepting.
  - admin_correction_queue: A list of proposed history corrections requiring multi-admin approval or ambassador oversight.
section_action_contracts:
  - transfer_initiate_button: Generates a single-use, time-bound transfer token.
  - claim_passport_form: Validates the transfer token and links the passport to the new `user_id`.
  - correction_approval_workflow: UI for admins to review, comment on, and sign-off on requested data changes.
design_content_strategy:
  - "Verified Hand-off" aesthetic: secure confirmation modals, "Success" animations for successful claims, and clear status indicators for "Transfer in Progress."
  - privacy-first: ensure the timeline shows "Owner 1", "Owner 2" etc., instead of full names to maintain GDPR compliance while preserving provenance.
visual_asset_strategy:
  - custom "Ownership Certificate" generated upon successful transfer.
  - SVG icons for "Transfer" and "Correction" event types.
integration_context:
  related_plan_ids: 6, 7
  shared_entities: ProductPassport, User, PassportAuditLog, GovernanceProposal (Extension)
  dependencies: PassportService, GovernanceService
  handoff_points: ResaleTradeIn completion (Plan 3/5) will now trigger an automated `OwnershipTransfer`.
connected_artifacts:
  connected_to: 6, 7
  connected_files: app/Services/PassportService.php, app/Services/GovernanceService.php, app/Models/ProductPassport.php
  connection_scope: circular_integrity_and_governance
  connection_reason: Connects the Trust Layer (Plan 6) with Governance (Plan 7) to manage sensitive data lifecycle.
  read_required_for_implementation: true
primary_user_workflows:
  - transfer_product_ownership_via_resale
  - claim_purchased_verified_product
  - governance_review_of_history_correction
workflow_logic_checks:
  - transfer_token_expiry: Tokens must expire after 48 hours for security.
  - ownership_lock: Passports cannot have multiple active transfers at once.
  - correction_impact_assessment: If `event_data` change affects "Water/Carbon" metrics, auto-trigger a Governance Review.
  - multi_sig_correction: Critical corrections require 2 admin signatures recorded in the log.
roles_permissions:
  - customer: initiate transfer (seller), claim passport (buyer).
  - admin: propose correction, approve correction (Reviewer 1).
  - super_admin: final approval for high-impact corrections (Reviewer 2).
core_entities_data:
  - PassportTransfer: passport_id, sender_id, recipient_id (Nullable), token, status (Pending/Completed/Expired), expires_at.
  - PassportAuditLog: (Existing) Add `governance_approval_id` to link to the review process.
integrations:
  - Notification Service: Alert buyer of pending transfer and admin of pending correction.
notifications_reports:
  - transfer_initiated_notification
  - claim_successful_celebration
  - correction_review_required_alert
MVP_scope:
  - Peer-to-peer ownership transfer via secure token.
  - "Chain of Ownership" visualization in the timeline.
  - Basic 2-admin approval workflow for log corrections.
deferred_scope:
  - Automated "Resale Hub" transfer (escrow-style).
  - Public blockchain anchoring of ownership changes.
research_notes:
  - Evaluate the use of `signed_urls` for secure transfer tokens.
  - Determine the best way to mask user IDs in the public timeline while keeping them auditable.
assumptions:
  - The `ProductPassport` model is the central point of truth for ownership.
  - Admins have different "Trust Tiers" for the correction workflow.
open_questions:
  - Should the previous owner lose access to the "Verified History" once transferred? (Decision: They retain "View Only" access to the portion they owned).
