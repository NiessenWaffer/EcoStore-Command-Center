# Implementation Task Checklist: Plan 5

status: completed
create_structure_owner: planning_mode
execution_update_owner: developer_mode
source_plan: List plan/plan5/plan.md
source_workflow: List plan/plan5/workflow.md
root_rule: plan.md -> workflow.md -> task.md

TASKS:
- [x] task_id: local_hub_geocoding_and_routing
  - source_workflow_section: workflow_logic_checks (distance_impact_optimization)
  - implementation_scope: Implement geocoding for hubs and users; integrate Google Distance Matrix for hub-based routing.
  - files_areas: app/Services/GeoRoutingService.php, app/Models/LocalHub.php
  - [x] functional_check_1: Hub discovery: `GeoRoutingService` correctly finds hubs within a 5km Haversine radius.
  - [x] functional_check_2: Relationship logic: Orders successfully link to the nearest `LocalHub` upon creation.

- [x] task_id: green_delivery_selector_ui
  - source_workflow_section: select_green_delivery_method
  - implementation_scope: Build checkout component for choosing neighborhood bundling windows and local pickup.
  - files_areas: resources/views/livewire/shop/⚡delivery-selector.blade.php, app/Http/Controllers/CheckoutController.php
  - [x] functional_check_1: Checkout UI: `⚡delivery-selector` renders in the checkout flow and persists choice to session.
  - [x] functional_check_2: Impact integration: Selecting "Neighborhood Bundle" or "Hub Pickup" adds +50L to the order impact total.

- [x] task_id: live_bike_courier_tracking
  - source_workflow_section: track_local_bike_delivery
  - implementation_scope: Develop tracking dashboard with real-time status updates and carbon-savings visualization.
  - files_areas: resources/views/tracking/bike.blade.php, app/Models/Order.php
  - [x] functional_check_1: Frontend UI: Bike tracking page renders with animated courier path and live CO2 counter.
  - [x] functional_check_2: Context verification: Tracking page correctly displays the fulfillment hub name and order status.

- [x] task_id: local_hub_refurbish_inventory_sync
  - source_workflow_section: local_hub_refurbishment_loop
  - implementation_scope: Build interface for Hub managers to verify returns and sync them to "Pre-loved" inventory.
  - files_areas: app/Http/Controllers/Admin/HubInventoryController.php, resources/views/admin/hub/manage.blade.php
  - [x] functional_check_1: Hub management: Manager dashboard displays pending local trade-ins.
  - [x] functional_check_2: Verification flow: Clicking "Verify & Credit" successfully triggers the `CreditService` and updates item status.
