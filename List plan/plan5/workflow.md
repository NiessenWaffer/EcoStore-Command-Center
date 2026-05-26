# User Workflows: Plan 5 (Hyper-Local Logistics)

status: ready_for_implementation_planning
source_plan: List plan/plan5/plan.md

WORKFLOWS:
  - id: select_green_delivery_method
    description: User opts for the lowest-carbon shipping option.
    entrypoint: Checkout Page -> Shipping Selection
    steps:
      - user views shipping options
      - system highlights "Neighborhood Bundle: Save 50L Water" (shares delivery with neighbor)
      - user selects "Local Zero-Waste Pickup" at a micro-hub
      - system confirms "Naked Shipping" (no cardboard waste)
    success_state: Order is routed to a local bike courier or hub pickup.
    failure_state: No local hub in user's zip code (Falls back to carbon-neutral van).

  - id: track_local_bike_delivery
    description: User sees their delivery mission in real-time.
    entrypoint: Order Tracking Page
    steps:
      - user views active delivery
      - system displays bike courier GPS path and "Live CO2 Saved" counter
      - user receives geofenced notification when courier is 500m away
    success_state: User receives item via bike; impact is finalized in dashboard.
    failure_state: Courier delay; ETA is updated automatically.

  - id: local_hub_refurbishment_loop
    description: Returned items are processed locally to minimize transit.
    entrypoint: Local Hub (Boutique Partner) Dashboard
    steps:
      - user drops off return at local hub
      - hub staff inspects and refurbishes item (Plan 3 integration)
      - system lists item in "Pre-loved" marketplace assigned to that Hub's inventory
    success_state: Item is resold locally; zero transit carbon for the return/resale loop.
    failure_state: Item damaged beyond repair; routed to textile recycling (P3 bonus).
