# Project Workflow Contract

sequence_id: 9
artifact_folder: List plan/plan9/
source_plan: List plan/plan9/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: transfer_product_ownership_p2p
    description: A current owner initiates a transfer of a product passport to a new buyer.
    entrypoint: My Assets -> [Select Passport] -> Initiate Transfer
    steps:
      - user clicks "Initiate Ownership Transfer"
      - system checks if passport is currently locked/in-transfer.
      - system generates a single-use `PassportTransfer` record with a unique `token`.
      - system displays a QR code and a shareable link (expiring in 48h).
      - system updates passport state to "In Transfer" (locks other actions).
    success_state: Seller sees a "Transfer Initialized" screen with the token; passport is marked as pending.
    failure_state: "Transfer already in progress" error or unauthorized access.

  - id: claim_purchased_product_passport
    description: A buyer claims a product passport using a transfer token.
    entrypoint: Transfer Link or /claim?token={token}
    steps:
      - buyer visits the claim link.
      - system validates token exists, is "Pending", and not expired.
      - system displays product history and verification status to the buyer.
      - buyer clicks "Verify & Accept Ownership".
      - system creates a `PassportAuditLog` entry of type `OwnershipTransfer`.
      - system updates `product_passports.user_id` to the new buyer.
      - system marks `PassportTransfer` as "Completed".
      - system unlocks the passport.
    success_state: Buyer sees a "Congratulations" screen; passport now appears in their "My Assets".
    failure_state: "Invalid or expired token" error.

  - id: multi_admin_correction_review
    description: A sensitive correction to the audit log requires approval from two different admins.
    entrypoint: Admin Dashboard -> Correction Queue
    steps:
      - Admin 1 proposes a correction for a log entry.
      - system creates a `GovernanceProposal` of type `Correction`.
      - system alerts all Admins of a pending review.
      - Admin 2 reviews the proposed data change.
      - Admin 2 clicks "Approve & Sign".
      - system triggers `PassportService.recordEvent()` with type `Correction`.
      - system links the new log to the `GovernanceProposal`.
    success_state: Correction is appended to the immutable chain; original log is flagged as "Corrected".
    failure_state: Approval rejected or proposal expired.

frontend_first_sequence:
  - slice_1: Transfer & Claim UI
    rationale: Early validation of the "Handshake" UX for resale buyers and sellers.
    user_workflow: transfer_product_ownership_p2p, claim_purchased_product_passport
    frontend_layout_controls:
      - `TransferInitializationCard`: Displays token/QR code.
      - `ClaimVerificationView`: Full-page timeline view for the buyer before they accept.
    image_slots:
      - QR Code placeholder.
      - "Success" checkmark animation.

controls_routing:
  - POST /passports/{id}/transfer: Initialize transfer.
  - GET /claim/{token}: Verify and show the claim page.
  - POST /claim/{token}/accept: Finalize ownership change.
  - GET /admin/corrections: List pending correction proposals.
  - POST /admin/corrections/{id}/approve: Approve a proposal.

backend_contract:
  - PassportService:
      - `initiateTransfer(User $sender, ProductPassport $passport)`: Creates transfer record.
      - `completeTransfer(User $recipient, string $token)`: Updates ownership and records audit log.
      - `proposeCorrection(User $proposer, PassportAuditLog $original, array $newData)`: Creates governance proposal.
      - `finalizeCorrection(GovernanceProposal $proposal, User $approver)`: Appends correction to chain.

database_contract:
  - table: `passport_transfers`
    fields:
      - id (UUID)
      - passport_id (FK)
      - sender_id (FK, User)
      - recipient_id (FK, User, Nullable)
      - token (String, unique)
      - status (Enum: Pending, Completed, Expired)
      - expires_at (DateTime)

verification_flow:
  - functional_testing:
      - "Verify that a token cannot be used twice."
      - "Ensure the seller can no longer initiate a second transfer while one is pending."
      - "Confirm that the audit log shows 'Ownership Transfer' with the correct timestamps and actor signatures."
  - automated_tests:
      - Feature: `OwnershipTransferTest`.
      - Unit: `CorrectionGovernanceTest`.

risks_unknowns:
  - handling "Ghost Passports" where a seller initiates but the buyer never claims (need auto-expiry/revert logic).
  - privacy concerns for previous owners in the shared timeline.
