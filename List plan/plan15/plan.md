# Project Plan Contract

sequence_id: 15
artifact_name: responsive_hardening_shop_and_catalog
artifact_folder: List plan/plan15/
artifact_scope: mobile_first_catalog_and_pdp_experience
depends_on: 1, 14
status: ready_for_workflow
mode: interactive_discovery
project_goal: Create a world-class mobile shopping experience by hardening the Shop Catalog and Product Detail Pages (PDP) for responsive perfection, focusing on filter accessibility, gesture-based galleries, and high-conversion mobile CTAs.
target_users: mobile shoppers, high-intent buyers
success_criteria:
  - Shop Filters are accessible via a mobile "Filter & Sort" bottom sheet or drawer.
  - Product listing grid scales elegantly to 2 columns on mobile devices.
  - Product Detail Page (PDP) features a mobile-optimized layout with sticky CTAs.
  - Interactive "Impact Gauge" is perfectly scaled for touch viewports.
  - Product images support swipe gestures for secondary views on mobile.
page_screen_contracts:
  - mobile_filter_drawer: Full-screen overlay for category, price, and Impact Index filtering.
  - responsive_product_grid: Dynamic column adjustments (2 on Mobile, 3 on Tablet, 4+ on Desktop).
  - mobile_pdp_optimized: Stacked gallery -> title -> impact -> description -> sticky buy button.
section_action_contracts:
  - open_filter_trigger: Fixed or prominent button at the top of the product list.
  - mobile_swipe_gallery: Gesture-aware product image viewing.
  - sticky_mobile_cta: Floating "Add to Bag" bar that persists as the user scrolls the PDP.
design_content_strategy:
  - "Visual Hierarchy" focus: Prioritize product imagery and the "Impact Index" seal on mobile cards.
  - High Information Density: Use compact typography for secondary product meta-data (e.g., price, category) to maximize vertical space.
visual_asset_strategy:
  - Lazy Loading: Ensure all catalog images use responsive sizes (`srcset`) to reduce mobile bandwidth.
  - Tap-to-Zoom: Enable full-screen image viewing on mobile tap.
integration_context:
  related_plan_ids: 1, 14
  shared_entities: Product, Category, SustainabilityMetric
  dependencies: none
  handoff_points: Leverages the Navigation Baseline from Plan 14.
connected_artifacts:
  connected_to: 1, 14
  connected_files: resources/views/livewire/shop/product-list.blade.php, resources/views/livewire/shop/product-show.blade.php
  connection_scope: commerce_responsiveness
  connection_reason: PDP and Catalog are the primary conversion drivers; mobile failure here is critical.
  read_required_for_implementation: true
primary_user_workflows:
  - filter_catalog_on_mobile
  - evaluate_product_impact_on_mobile
  - execute_mobile_purchase
workflow_logic_checks:
  - filter_state_persistence: Ensure filters remain active when the drawer is closed.
  - cta_visibility: The "Add to Bag" button must never be obscured by the Cart Drawer or Chat Bot.
  - image_aspect_ratio: Prevent layout shifts when the mobile gallery initializes.
roles_permissions:
  - guest/user: browses the shop on mobile.
core_entities_data: none
integrations: none
notifications_reports: none
MVP_scope:
  - Mobile Filter Drawer for Shop.
  - 2-Column Responsive Grid.
  - Basic Responsive PDP (Stacked layout).
deferred_scope:
  - Advanced swipe gallery with touch-tracking.
  - "Recent Views" horizontal carousel on mobile.
research_notes:
  - Check Alpine.js `x-teleport` for moving the filter sidebar into a modal on mobile.
assumptions:
  - Current product images are high enough resolution for full-width mobile display.
open_questions:
  - Should we show the "Quick Add" button on mobile grid cards, or is it too cluttered? (Decision: Use a small "+" icon overlay instead of full text button).
