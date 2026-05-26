# User Workflows

status: ready_for_implementation_planning
source_plan: List plan/plan1/plan.md

WORKFLOWS:
  - id: search_and_filter_sustainable_apparel
    description: User finds eco-friendly products using categories and filters.
    entrypoint: Home Page or Product Listing Page
    steps:
      - user selects category or collection
      - user applies sustainability filters (e.g., High Impact Only)
      - system returns filtered product list with visible impact badges
    success_state: User views a product detail page for a selected item.
    failure_state: "No products found" message with a reset filter option.

  - id: purchase_with_impact_visualization
    description: User adds item to cart and completes checkout, seeing their environmental contribution.
    entrypoint: Product Detail Page
    steps:
      - user selects size/color variant
      - user adds item to cart (cart drawer opens showing total impact)
      - user proceeds to checkout
      - user enters shipping/billing info (Stripe integration)
      - system calculates dynamic sustainability impact for total order
      - user confirms payment
    success_state: Order confirmation page displays "Total Water Saved" and "Total Carbon Reduced" for the purchase.
    failure_state: Payment declined or stock unavailable message; user remains in checkout.

  - id: track_order_and_environmental_contribution
    description: User checks the status of their order and sees their cumulative impact.
    entrypoint: Customer Dashboard
    steps:
      - user logs in
      - user views "Order History"
      - user clicks on a specific order
      - system displays shipping status and impact summary
    success_state: User sees their order is "Shipped" and views the impact metrics associated with that order.
    failure_state: Order not found or login error.

  - id: manage_sustainability_metrics_admin
    description: Admin configures the impact coefficients for materials.
    entrypoint: Admin Dashboard -> Sustainability Settings
    steps:
      - admin enters material type (e.g., Organic Cotton)
      - admin defines impact values (Water/kg, Carbon/kg)
      - admin saves settings
    success_state: Product impact badges across the store update dynamically based on new coefficients.
    failure_state: Validation error (e.g., negative values).
