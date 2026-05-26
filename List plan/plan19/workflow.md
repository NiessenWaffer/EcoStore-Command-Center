# User Workflow: Circular Leasing

## Actor: Customer

1. **Navigate to PDP:** User visits a Product Detail Page (e.g., Organic Cotton Jacket).
2. **Select Lease Option:** User toggles the purchasing method from "Buy ($150)" to "Lease ($15/month)".
3. **Checkout:** User enters their shipping address. The system calculates the mandatory Carbon Gate Fee from the nearest Local Hub to the destination.
4. **Subscribe:** User confirms their payment method for recurring monthly billing.
5. **Dashboard Management:** User visits their Ambassador Dashboard. A new "Active Leases" tab displays the item, the next billing date, and an "Initiate Return" action.
6. **Return Item:** User clicks "Initiate Return". The system pauses the subscription pending transit confirmation and generates routing instructions to the closest Local Hub.

## Actor: Hub Admin

7. **Receive Return:** Admin receives the physical item at the assigned Local Hub.
8. **Condition Assessment:** Admin uses the Ecosystem Pulse dashboard to scan the Product Passport QR code.
9. **Update Ledger:** Admin updates the item's condition (e.g., 'good'). This appends an immutable record to the `ProductPassport`.
10. **Inventory Restocking:** If the condition is acceptable, the item's passport is updated, and it automatically reappears in the dynamically available leasing inventory for that specific Hub.