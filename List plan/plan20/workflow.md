# User Workflow: Decentralized Permanent Storage

## Actor: Customer

1. **View Product Detail Page (PDP):** User browses a product and clicks to view its Sustainability Dashboard and Product Passport.
2. **Verify Permanence:** Alongside the "Impact Index", the user sees a "Secured on IPFS" badge. 
3. **Inspect Raw Data:** User clicks the badge and is routed to a public IPFS gateway, viewing the raw JSON data of the product's origin, ensuring the brand cannot secretly alter the history.

## Actor: Hub Admin (Lease Return)

4. **Process Return:** Admin scans a leased item and updates its condition (e.g., from 'pristine' to 'good').
5. **Background Sync:** The system updates the central database and immediately queues an IPFS sync job.
6. **Command Center Verification:** Admin views the "Ecosystem Pulse" dashboard. They can see the specific Product Passport's `ipfs_synced_at` timestamp update, confirming the new condition log is permanently recorded on the decentralized web.

## Actor: System (Background Job)

7. **Queue Worker:** The system continually processes `SyncPassportToIpfsJob` tasks.
8. **Pinning Service:** It authenticates with a pinning service (like Pinata), uploads the structured JSON, retrieves the resulting `CID`, and saves it back to the `ProductPassport` record.