# Blueprint: Multi-Tenant Sustainable Marketplace API (Plan 21)

## 1. Scope & Objective
- **Feature:** B2B Multi-Tenant Infrastructure.
- **Objective:** Transform the platform into a marketplace where external sustainable brands can list products, mint passports on our Trust Layer, and utilize our Global Hub network.
- **Boundaries:** Includes Brand onboarding, API token management (Sanctum/Passport), Marketplace API endpoints, and multi-tenant data isolation.

## 2. Data Contract (New & Modified Models)
- `Brand`: New model to represent external sellers.
  - Fields: `name`, `slug`, `api_token` (hashed), `commission_rate`, `logo_url`, `is_verified`.
- `Product` (Update): 
  - Add `brand_id`: Foreign key (null for internal "EcoStore" products).
- `Order` (Update): 
  - Add `commission_cents`: Tracks platform revenue from marketplace sales.
- `HubInventory` (Update): 
  - Track stock levels per brand to ensure correct fulfillment routing.

## 3. Business Logic & Constraints
- **API Access:** Brands must be "Verified" by an Admin before their API keys are active.
- **Passport Minting:** External brands can POST to `/api/v1/passports` to generate a verified passport. The system validates their material composition against our sustainability grade rules (Plan 3).
- **Data Isolation:** Dashboard queries must be scoped to `brand_id` for brand-specific logins.
- **Commission:** The platform takes a "Carbon Platform Fee" (e.g., 5%) on all external brand transactions to fund the Community Impact Fund (Plan 7).

## 4. Acceptance Criteria
- External brand can register and receive an API token via the Command Center (Admin approval required).
- Product listing endpoint successfully creates a product associated with the external brand.
- Marketplace landing page displays products filtered by brand.
- Product Passports minted via API are automatically synced to IPFS (Plan 20) and display the external brand's verification.