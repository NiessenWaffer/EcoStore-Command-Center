# Project Plan Contract

sequence_id: 6
artifact_name: immutable_verification_trust_layer
artifact_folder: List plan/plan6/
artifact_scope: trust_and_transparency_layer
depends_on: 1, 3
status: completed
mode: interactive_discovery
project_goal: Create an immutable audit trail for Product Passports to eliminate greenwashing and ensure data integrity throughout the product lifecycle.
target_users: eco-conscious consumers, brand auditors, resale buyers
success_criteria:
  - 100% of Product Passport changes are recorded in a cryptographically linked audit log.
  - 100% of admin-initiated events are cryptographically signed by the authorized actor.
  - Users can view a "Verified History" timeline with cryptographic proof of authenticity and actor attribution.
  - Attempted tampering with historical passport data is detectable via hash mismatch.
  - 100% of data corrections are recorded as "Correction" events rather than modifying history.
page_screen_contracts:
  - passport_verification_page: detailed timeline of a product's life (factory -> hub -> owner), verification status badges, "Proof of Authenticity" technical details modal.
  - admin_passport_audit: view-only list of all cryptographic hashes and event logs for a specific passport.
section_action_contracts:
  - passport_timeline: interactive vertical timeline showing material sourcing, manufacturing, logistics, and ownership events.
  - verification_badge: "Verified" icon that expands to show the cryptographic signature and timestamp.
design_content_strategy:
  - "Security & Trust" aesthetic: subtle blueprint patterns, monospace fonts for hash data, green "verified" checkmarks.
  - transparency focus: explain "How we verify" in plain language alongside technical proofs.
visual_asset_strategy:
  - dynamically generated "Proof of Authenticity" certificates (PDF/Image).
  - SVG icons for different verification stages (Raw Material, Factory, Logistics, Sale).
  - CSS-based "Scanning" animation for the verification UI.
integration_context:
  related_plan_ids: 1, 3
  shared_entities: ProductPassport, Product, User, Factory, LocalHub
  dependencies: PassportService, SustainabilityImpactService
  handoff_points: PassportService.recordEvent() will trigger the audit log creation.
connected_artifacts:
  connected_to: 1, 3
  connected_files: app/Models/ProductPassport.php, app/Services/PassportService.php
  connection_scope: data_integrity_and_visualization
  connection_reason: Enhances existing passport models with a secure audit trail.
  read_required_for_implementation: true
primary_user_workflows:
  - verify_product_authenticity_and_history
  - view_immutable_impact_milestones
  - transfer_verified_passport_on_resale
workflow_logic_checks:
  - cryptographic_chain_integrity: New log entry hash = Hash(previous_log_entry_hash + current_data + timestamp).
  - digital_signature_verification: Validate that the `signature` matches the `performed_by` actor's public key for admin events.
  - correction_workflow: Corrections must reference an original log ID; original records are never updated.
  - event_type_validation: Only predefined event types (Sourcing, Manufacturing, Logistics, Ownership, Correction) can be recorded.
  - immutability_enforcement: Prevent deletion or modification of `PassportAuditLog` entries at the database level (Trigger or Application Layer).
roles_permissions:
  - guest/customer: view verified history, verify authenticity, view actor attribution.
  - admin: add verification events, issue corrections, view technical audit logs.
  - system: automatically generate hashes and link logs.
core_entities_data:
  - PassportAuditLog: passport_id, event_type (Enum), event_data (JSON), previous_hash, current_hash, signature (String/Nullable), timestamp, performed_by (User/System), original_log_id (Self-ref/Nullable for corrections).
  - ProductPassport: (Existing) Add `is_verified` boolean and `last_audit_hash`.
integrations:
  - Internal Cryptography: PHP hash_hmac (SHA-256) and OpenSSL/libsodium for digital signatures.
  - (Future) Blockchain: Potential export to L2 for public verifiability.
notifications_reports:
  - verification_success_notification
  - integrity_alert_email (Admin only, if hash mismatch detected)
MVP_scope:
  - Cryptographic audit log for ProductPassports.
  - "Verified History" UI timeline.
  - Admin interface to trigger manual verification events.
  - Hash integrity check command/logic.
deferred_scope:
  - Public blockchain integration (Mainnet).
  - Decentralized storage (IPFS) for passport assets.
  - Multi-party verification (Third-party auditors).
research_notes:
  - evaluate performance of recursive hash checking for deep histories.
  - determine best storage strategy for large JSON `event_data`.
assumptions:
  - ProductPassport model exists and is functional (from Plan 3).
  - SHA-256 is sufficient for initial integrity verification.
open_questions:
  - Should we allow users to see the raw JSON data of the events?
  - How do we handle "corrections" to the history without breaking the chain? (Answer: Append "Correction" event type).
