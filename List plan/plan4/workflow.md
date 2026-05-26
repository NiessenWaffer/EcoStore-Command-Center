# User Workflows: Plan 4 (AI Personalization)

status: ready_for_implementation_planning
source_plan: List plan/plan4/plan.md

WORKFLOWS:
  - id: create_ai_fit_profile
    description: User creates a body profile for precision size recommendations.
    entrypoint: Fit Profile Wizard (Onboarding or Product Page)
    steps:
      - user enters height, weight, and fit preference (e.g., "Loose")
      - system analyzes past "Kept" vs. "Returned" sizes for this user
      - system generates a "Perfect Fit" confidence score for the current product
    success_state: User sees "95% Confidence: Size M" on all product pages.
    failure_state: Insufficient data for confidence score; system falls back to standard size chart.

  - id: chat_with_sustainability_concierge
    description: AI helps user build a sustainable wardrobe.
    entrypoint: AI Stylist Chat Widget
    steps:
      - user asks: "I need a minimalist outfit for a summer wedding"
      - AI analyzes catalog, prioritizing Grade A items and user's fit profile
      - AI provides 3 coordinated suggestions with "Why this is sustainable" reasoning
      - user adds whole outfit to cart
    success_state: User purchases mission-aligned products that fit perfectly.
    failure_state: AI suggests out-of-stock items (Handled by P4 Wait Impact forecast).

  - id: manage_return_with_impact_warning
    description: User is deterred from frivolous returns via impact data.
    entrypoint: Returns Flow
    steps:
      - user selects "Return Item"
      - system displays: "Returning this item adds 5.2kg of CO2. Are you sure? Our AI suggests a size L would fit you better next time."
      - system offers "1-Click Exchange" for a different size to avoid double-shipping
    success_state: User chooses exchange or decides to keep the item; return carbon is avoided.
    failure_state: User proceeds with return (Carbon cost is recorded in P4 analytics).
