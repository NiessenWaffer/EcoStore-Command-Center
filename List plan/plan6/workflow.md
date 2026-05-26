# Project Workflow Contract

sequence_id: 6
artifact_folder: List plan/plan6/
source_plan: List plan/plan6/plan.md
status: completed

precise_user_flow:
  - id: verify_product_authenticity_and_history
    description: User scans or visits a product passport page and verifies its lifecycle integrity.
    entrypoint: Product Passport Page (/passports/{id})
    steps:
      - user clicks "Verify History" or "View Authenticity Proof"
      - system retrieves all `PassportAuditLog` entries for the passport.
      - system performs a real-time integrity check (re-calculating hashes in the chain).
      - system displays vertical timeline with status "Verified" and cryptographic hash snippet.
    success_state: User sees a "Trust Verified" badge and a full, untampered history of the product.
    failure_state: System displays "Integrity Alert" if any hash in the chain is invalid or missing.

  - id: add_verification_event_admin
    description: Admin adds a manual verification event (e.g., Quality Check) that is immutably recorded and signed.
    entrypoint: Admin Dashboard -> Product Passports -> Audit
    steps:
      - admin selects event type (e.g., "Factory Audit")
      - admin enters event details (auditor name, results, date)
      - admin clicks "Sign & Submit" (triggers private key signature check)
      - system calculates `current_hash` using `previous_hash` + new data.
      - system generates `signature` using admin's private key.
      - system persists the `PassportAuditLog` entry.
    success_state: New event appears in the timeline with a secure hash link and "Signed by [Admin Name]" badge.
    failure_state: Database error, signature failure, or unauthorized attempt.

  - id: issue_data_correction_admin
    description: Admin issues a correction for a previous log entry without modifying the original.
    entrypoint: Admin Dashboard -> Product Passports -> Audit -> [Select Log Entry]
    steps:
      - admin selects "Issue Correction"
      - admin enters corrected data and reason for change.
      - system creates a new `PassportAuditLog` entry of type `Correction`.
      - system links the new entry to the original via `original_log_id`.
      - system calculates new hash chain tail.
    success_state: Timeline displays the original entry with a "Corrected" flag, and a new linked correction entry below it.
    failure_state: Validation error or unauthorized attempt.

frontend_first_sequence:
  - slice_1: Passport Verification UI Components
    rationale: Define the look and feel of the "Trust Layer" before implementing the backend hashing.
    user_workflow: verify_product_authenticity_and_history
    frontend_layout_controls:
      - `VerificationTimeline`: Vertical list of events with status icons.
      - `VerificationBadge`: Small component for "Verified/Tampered" status.
      - `TechnicalDetailsModal`: Monospace display of hashes and raw event data.
    image_slots:
      - Event icons (SVG)
      - Scanning animation (CSS/GIF)
    sample_data_contract:
      - PassportAuditLog: 5 records for one passport (Sourcing, Factory, Hub, Sale, Owner Transfer).

controls_routing:
  - GET /passports/{id}/verify: Endpoint to trigger integrity check and return verified history JSON/View.
  - POST /admin/passports/{id}/events: Endpoint for admins to append a new verified event.

backend_contract:
  - PassportService:
      - `recordEvent(ProductPassport $passport, string $type, array $data)`: Handles hash calculation and log creation.
      - `verifyIntegrity(ProductPassport $passport)`: Loops through history to confirm chain validity.
  - Middleware: `EnsureImmutable`: Prevents DELETE/UPDATE on the `PassportAuditLog` table.

database_contract:
  - table: `passport_audit_logs`
    fields:
      - id (UUID)
      - passport_id (Foreign Key)
      - event_type (String/Enum)
      - event_data (JSON)
      - previous_hash (String, 64 chars)
      - current_hash (String, 64 chars)
      - timestamp (DateTime)
      - performed_by (Foreign Key, User ID)

sample_data_contract:
  - entity: PassportAuditLog
    minimum_records: 10
    required_variants: Sourcing, Manufacturing, Logistics, Sale, Ownership
    relationships: belongsTo(ProductPassport), belongsTo(User)

verification_flow:
  - functional_testing:
      - "Ensure new events correctly link to the previous hash."
      - "Verify that modifying a record in the database manually triggers a verification failure UI."
      - "Test that guest users can view but not create audit events."
  - automated_tests:
      - Unit: `HashChainTest` (calculates and verifies SHA-256 chains).
      - Feature: `PassportVerificationApiTest`.

risks_unknowns:
  - performance impact of deep chain verification on every page load (consider caching the 'last_valid_state').
  - legal standing of "digital signatures" in different jurisdictions.

not_yet_implementing:
  - Public blockchain (Mainnet) anchoring.
  - IPFS storage.
