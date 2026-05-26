# User Workflows: Plan 3 (Circular Economy)

status: ready_for_implementation_planning
source_plan: List plan/plan3/plan.md

WORKFLOWS:
  - id: view_radical_transparency_passport
    description: User scans garment QR code to view its ethical backstory and cost breakdown.
    entrypoint: Product Label QR Code or Order History
    steps:
      - user scans physical QR or clicks "View Passport" in app
      - system displays Factory info, manufacturing date, and raw material batch
      - system shows "True Cost" breakdown (Materials vs. Labor vs. Profit)
    success_state: User views the complete transparent history of their specific garment.
    failure_state: Invalid QR code or missing batch data (Admin alert triggered).

  - id: trade_in_preloved_item
    description: User returns an old item for store credit to support the circular economy.
    entrypoint: Customer Dashboard -> Resale Portal
    steps:
      - user selects an item from their past "Kept" order history
      - user describes current condition and uploads photos
      - system calculates "Circular Credit" value based on original price and condition
      - user drops item at a "Local Hub" (Plan 5)
      - admin/hub verifies condition and releases credit
    success_state: User receives store credit; item is listed in the "Pre-loved" marketplace.
    failure_state: Item not found in history; verification fails.

  - id: access_longevity_maintenance
    description: User accesses care guides to extend product life.
    entrypoint: 6-month Longevity Email
    steps:
      - user clicks link in automated care reminder
      - system displays product-specific repair guides (e.g., "How to fix a loose button on this coat")
      - user can purchase a "Minimalist Repair Kit" directly from the guide
    success_state: User successfully repairs/maintains the item, preventing waste.
    failure_state: Guide not available for specific material type.
