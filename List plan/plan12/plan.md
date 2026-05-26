# Project Plan Contract

sequence_id: 12
artifact_name: global_hub_expansion
artifact_folder: List plan/plan12/
artifact_scope: international_circularity_and_geo_logistics
depends_on: 3, 5, 6, 9
status: completed
mode: interactive_discovery
project_goal: Scale the hyper-local fulfillment and circular resale network internationally, enabling cross-border trade-ins, dynamic multi-region inventory routing, and localized impact accounting.
target_users: international customers, global hub managers, logistics admins
success_criteria:
  - Users are automatically routed to the nearest global Hub based on Geo-IP.
  - The "Transit Impact" in the Product Passport dynamically updates based on the distance between the Hub and the international customer.
  - Cross-border trade-ins are supported (e.g., Buy in US, Trade-in at EU Hub).
  - Multi-currency support integrated into the Resale and Store Credit systems.
page_screen_contracts:
  - global_hub_directory: Interactive map UI showing all active hubs worldwide and their specialized capabilities (e.g., "Repair", "Recycle", "Resale").
  - localized_checkout_view: Checkout updated to show dynamically calculated shipping carbon cost (Air vs Ocean) based on the sourcing Hub.
  - hub_manager_dashboard: Admin view tailored for specific regional managers (e.g., "EU-Central Hub").
section_action_contracts:
  - geo_ip_region_selector: Auto-detects user region but allows manual override for gifting/shipping abroad.
  - cross_border_transfer_init: Updates the Passport transfer protocol to handle customs/import states if necessary.
design_content_strategy:
  - "borderless_sustainability" aesthetic: Use interactive globes/maps (e.g., Mapbox/WebGL) to visualize the decentralized network.
  - extreme transparency: Clearly contrast the high carbon cost of global air freight vs the low cost of local Hub fulfillment to nudge user behavior.
visual_asset_strategy:
  - WebGL Interactive Globe for the Hub Directory.
  - Animated transit routes showing the product's journey from Hub to Customer.
integration_context:
  related_plan_ids: 5 (Local Logistics), 9 (Ownership Transfer)
  shared_entities: LocalHub, Order, ProductPassport, User
  dependencies: GeoRoutingService, SustainabilityImpactService
  handoff_points: Extends Plan 5 by elevating "Local Hubs" to "Global Nodes" with distinct geographic zones.
connected_artifacts:
  connected_to: 5, 9
  connected_files: app/Services/GeoRoutingService.php, app/Services/PassportService.php, resources/views/shop/checkout.blade.php
  connection_scope: global_logistics_routing
  connection_reason: Must intercept the existing checkout and transfer flows to inject international distance logic.
  read_required_for_implementation: true
primary_user_workflows:
  - shop_from_optimal_global_hub
  - process_international_trade_in
  - manage_regional_hub_inventory
workflow_logic_checks:
  - dynamic_carbon_penalty: If a user chooses international shipping over a local alternative, calculate and display the exact CO2 penalty.
  - cross_region_resale_lock: Prevent shipping used items across oceans if the carbon cost exceeds the item's production footprint.
roles_permissions:
  - regional_hub_manager: Can only manage inventory and verify trade-ins for their assigned geographic zone.
  - super_admin: Oversees the entire global network.
core_entities_data:
  - LocalHub: Add `region_code`, `country`, `coordinates`, `supported_currencies`.
  - Order: Add `sourcing_hub_id`, `transit_distance_km`, `transit_mode` (Air/Sea/Land).
integrations:
  - MaxMind / IPStack: For Geo-IP resolution.
  - Exchange Rate API: For multi-currency store credit conversion.
notifications_reports:
  - global_network_efficiency_report (Monthly)
MVP_scope:
  - Geo-IP based Hub routing.
  - Dynamic "Transit Impact" calculation on checkout.
  - Regional restrictions on Resale (e.g., "EU-only trade-ins").
deferred_scope:
  - Full multi-currency payment gateway integration (Stripe/Adyen handles this natively, but UI needs work).
  - 3D Interactive WebGL Globe.
research_notes:
  - Investigate the Haversine formula in PHP/SQL to calculate distances between user shipping address and Hub coordinates.
assumptions:
  - The brand has physical partner locations or warehouses in at least 2 distinct global regions (e.g., NA and EU).
open_questions:
  - How do we handle the environmental cost of cross-border resale? (Decision pending).
