# Project Workflow Contract

sequence_id: 15
artifact_folder: List plan/plan15/
source_plan: List plan/plan15/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: mobile_catalog_filtering
    description: A user finds products easily on mobile using a non-intrusive filter system.
    entrypoint: Shop Page (/shop)
    steps:
      - user taps "Filter & Sort" fixed button.
      - system opens a bottom-sheet drawer with category and impact index options.
      - user selects "Regenerative" tier and "Accessories" category.
      - system updates the underlying product grid in real-time or upon "Apply".
      - user closes the drawer.
    success_state: Filtered results are displayed in a clean 2-column grid.
    failure_state: Filter drawer is too long for the screen and lacks internal scrolling.

  - id: evaluate_impact_on_pdp_mobile
    description: A user reviews technical impact data on a small screen before purchasing.
    entrypoint: Product Show (/shop/{slug})
    steps:
      - user lands on PDP; sees the product image occupying the first viewport.
      - user scrolls down to find the "Impact Index" gauge.
      - system renders a responsive gauge that fits the mobile screen width (px-4 padding).
      - user taps "Transparency Data" link.
      - system opens the Methodology Modal (from Plan 11) in a mobile-optimized full-screen view.
    success_state: Technical data is legible and interactive on mobile.

  - id: mobile_purchase_conversion
    description: A user adds an item to their bag without friction.
    entrypoint: Product Show (/shop/{slug})
    steps:
      - user selects a size/color variant using large, easy-to-tap pills.
      - system reveals the sticky "Add to Bag" bar at the bottom of the screen.
      - user taps "Add to Bag".
      - system triggers the Cart Drawer and shows a success confirmation.
    success_state: Conversion path is clear and optimized for mobile-thumb ergonomics.

frontend_first_sequence:
  - slice_1: Mobile Filter Sheet & Grid
    rationale: Catalog discovery is the primary entry point. Hardening the filters and grid ensures users can find what they want.
    user_workflow: mobile_catalog_filtering
    frontend_layout_controls:
      - `FilterDrawer`: mobile-only overlay.
      - `ResponsiveGrid`: 2-column sm: grid.
    image_slots: none

  - slice_2: Mobile PDP Hardening
    rationale: Conversion happens here. Stacked layout and sticky CTAs are mandatory for mobile e-commerce standards.
    user_workflow: evaluate_impact_on_pdp_mobile, mobile_purchase_conversion
    frontend_layout_controls:
      - `MobilePdpGallery`: stacked/swipe layout.
      - `StickyCtaBar`: fixed-bottom component.
    image_slots:
      - Main Product Image.

controls_routing: none

backend_contract: none

database_contract: none

verification_flow:
  - functional_testing:
      - "Verify that 'Add to Bag' is clickable on all mobile resolutions without overlapping other elements."
      - "Ensure 'Sticky CTA' only appears after the initial 'Hero' viewport is scrolled past (optional, but professional)."
      - "Confirm that 2-column grid cards don't break on long product names."
  - automated_tests:
      - Feature: `MobileShopResponsiveTest`.

risks_unknowns:
  - iOS bottom safe-area: ensure sticky CTA doesn't clash with the iOS home indicator.
