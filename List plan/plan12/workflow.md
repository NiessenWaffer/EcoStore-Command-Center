# Project Workflow Contract

sequence_id: 12
artifact_folder: List plan/plan12/
source_plan: List plan/plan12/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: global_hub_geo_routing
    description: System automatically detects user location and routes them to the optimal Hub for fulfillment or trade-in.
    entrypoint: Site Landing or Checkout
    steps:
      - system captures user's IP address.
      - system resolves IP to a geographic region (via Geo-IP service).
      - system queries `local_hubs` for the nearest node with available inventory.
      - system displays localized currency and estimated shipping carbon.
    success_state: User is matched with a regional Hub; prices and impact stats are relevant to their location.
    failure_state: Geo-IP failure defaults to the "Global Master Hub" (Primary HQ).

  - id: international_resale_checkout_with_carbon_gate
    description: User purchases a resale item from a different region, triggering a carbon warning and offset requirement.
    entrypoint: Product Detail Page (Resale) -> Checkout
    steps:
      - user selects a resale item located in a different Hub region (e.g., EU item to US user).
      - system calculates the "Transit Gap" (Distance * Emission Factor for Air/Sea).
      - system displays a "Global Transit Alert": "This item is in Berlin. Shipping to you generates X kg of CO2."
      - user must click "Acknowledge & Offset" to proceed.
      - system adds a small "Regeneration Fee" to the order total to cover the offset.
    success_state: User completes the purchase with full awareness of the environmental cost; order is recorded with the sourcing Hub.
    failure_state: User abandons due to high carbon impact (Success from a brand nudging perspective).

  - id: cross_border_trade_in_processing
    description: A user trades in a product purchased in one region to a Hub in another region.
    entrypoint: Resale Portal -> Initiate Trade-In
    steps:
      - user selects a product passport from their assets.
      - system identifies the item's original region (from the Audit Log).
      - user selects a return method (Mail-in to nearest Hub).
      - system calculates the trade-in credit and converts it from the item's base currency to the user's local currency.
      - system generates a cross-border shipping label.
    success_state: Item is accepted at the international Hub; user receives store credit in their local currency.

frontend_first_sequence:
  - slice_1: Global Hub Directory & Map
    rationale: Visualizing the global network builds trust and scale perception.
    user_workflow: global_hub_geo_routing
    frontend_layout_controls:
      - `GlobalHubMap`: Interactive map (SVG or Mapbox placeholder).
      - `RegionSelector`: Manual override for detected location.
    image_slots:
      - Map tiles/Globes.

controls_routing:
  - GET /admin/hubs/map: Visual directory of global nodes.
  - POST /api/geo/detect: Endpoint for IP-based region resolution.
  - GET /checkout/transit-impact: Calculates real-time CO2 based on shipping address.

backend_contract:
  - GeoRoutingService:
      - `detectRegion(string $ip)`: Returns ISO country/region code.
      - `getNearestHub(Coordinates $coords)`: Uses Haversine to find optimal fulfillment node.
  - SustainabilityImpactService:
      - `calculateTransitImpact(LocalHub $source, string $destinationZip)`: Computes CO2 based on distance and mode.
  - CurrencyService:
      - `convertCredit(float $amount, string $from, string $to)`: Handles multi-currency trade-ins.

database_contract:
  - table: `local_hubs` (Update)
    fields:
      - region_code (String)
      - latitude (Decimal)
      - longitude (Decimal)
      - timezone (String)
  - table: `orders` (Update)
    fields:
      - sourcing_hub_id (FK)
      - transit_co2_offset (Decimal)
      - is_international (Boolean)

verification_flow:
  - functional_testing:
      - "Verify that users from EU IPs see prices in EUR and sourcing from EU hubs."
      - "Ensure the 'Carbon Gate' modal appears when shipping across regions."
      - "Confirm that Haversine distance math is accurate to within 5% error margin."
  - automated_tests:
      - Unit: `GeoDistanceTest`.
      - Feature: `InternationalCheckoutTest`.

risks_unknowns:
  - complexity of customs and duties for cross-border resale (Deferred to third-party shipping provider logic).
  - accuracy of free Geo-IP databases.
