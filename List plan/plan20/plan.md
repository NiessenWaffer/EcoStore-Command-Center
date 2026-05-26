# Blueprint: Decentralized Permanent Storage (Plan 20)

## 1. Scope & Objective
- **Feature:** IPFS/Arweave Integration for Product Passports.
- **Objective:** Mature the Immutable Verification Trust Layer (Plan 6) by moving cryptographic proof and passport data off the central database and onto decentralized, permanent storage.
- **Boundaries:** Includes syncing Passport JSON data to IPFS via Pinata (or similar gateway), storing the IPFS CID (Content Identifier) in the database, and exposing the public IPFS link on the PDP.

## 2. Data Contract (New & Modified Models)
- `ProductPassport` (Update): 
  - Add `ipfs_cid`: String field to store the decentralized content identifier.
  - Add `ipfs_synced_at`: Timestamp for the last successful sync.

## 3. Business Logic & Constraints
- **Sync Trigger:** Whenever a ProductPassport is created, its ownership transferred, or its `condition_log` updated (via a lease return), an asynchronous background job is dispatched to sync the new state to IPFS.
- **Data Payload:** The JSON payload sent to IPFS must include the `batch_number`, `factory_id`, `transit_impact_carbon`, `manufacturing_date`, `condition_log`, and the `last_audit_hash`.
- **Read Logic:** The Product Detail Page and the Admin Command Center will display a "Verify on IPFS" link using a public gateway (e.g., `https://gateway.pinata.cloud/ipfs/{cid}`).

## 4. Acceptance Criteria
- System includes a background job (e.g., `SyncPassportToIpfsJob`) capable of handling HTTP requests to a decentralized pinning service.
- The `ProductPassport` table successfully stores and retrieves `ipfs_cid`.
- The User UI (PDP and Dashboard) provides a transparent, clickable link out to the raw IPFS JSON data.
- The Admin UI allows triggering a manual re-sync if the IPFS sync fails.