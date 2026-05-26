# Project Workflow Contract

sequence_id: 11
artifact_folder: List plan/plan11/
source_plan: List plan/plan11/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: visualize_personal_impact_trends
    description: User views their sustainability contributions over time with interactive charts.
    entrypoint: Dashboard -> Eco Impact Tab
    steps:
      - system retrieves user's historical order and resale data.
      - system calculates monthly deltas for `water_saved` and `carbon_reduced`.
      - system renders a line chart showing the trend.
      - system highlights reached milestones (e.g., "1st Ton of CO2 Saved").
    success_state: User gains a data-driven understanding of their ecological influence.
    failure_state: Incomplete data results in "Insufficient History" empty state.

  - id: generate_and_share_impact_certificate
    description: User generates a verifiable, signed certificate of their lifetime contributions.
    entrypoint: Dashboard -> Eco Impact -> Generate Certificate
    steps:
      - user clicks "Generate Certificate".
      - system calculates aggregate lifetime stats.
      - system generates a unique hash based on user ID + stats.
      - system signs the hash using the `PassportService` HMAC key.
      - system renders a high-fidelity certificate UI with the signature ID.
    success_state: User sees a "Verified Impact Certificate" ready for digital sharing.
    failure_state: Signing error or data mismatch.

  - id: participate_in_fair_quadratic_voting
    description: User participates in governance using the quadratic influence model.
    entrypoint: Dashboard -> Governance -> Active Proposal
    steps:
      - user enters the number of votes they wish to cast (Cost).
      - system calculates influence as `sqrt(cost)`.
      - UI updates the "Influence Bar" and "Remaining Power" in real-time.
      - user confirms the vote.
      - system records `weighted_cost` and `resultant_influence` in the audit log.
    success_state: Vote is recorded; influence is distributed fairly across the community.

frontend_first_sequence:
  - slice_1: Impact Portfolio UI & Trend Charts
    rationale: Visualizing impact is the primary motivator for user engagement.
    user_workflow: visualize_personal_impact_trends
    frontend_layout_controls:
      - `ImpactTimelineChart`: Line/Bar chart for sustainability trends.
      - `MilestoneBadgeGrid`: Grid of achieved achievements.
      - `CertificatePreview`: Elegant layout for the verified summary.
    image_slots:
      - SVG icons for Milestones.
      - Chart placeholders.

controls_routing:
  - GET /dashboard/impact: User portfolio view.
  - GET /certificate/verify/{signature}: Public verification route for shared certificates.

backend_contract:
  - GovernanceService:
      - `calculateQuadraticInfluence(int $weight)`: Returns sqrt($weight).
      - `castQuadraticVote(User $user, GovernanceProposal $proposal, int $cost)`: Handles QV recording.
  - SustainabilityImpactService:
      - `getUserImpactHistory(User $user)`: Returns monthly aggregation for charts.
  - PassportService:
      - `signImpactSummary(array $data)`: Generates the cryptographic signature for certificates.

database_contract:
  - table: `governance_votes` (Update)
    fields:
      - weighted_cost (Integer)
      - resultant_influence (Decimal)
  - table: `user_milestones`
    fields:
      - id (UUID)
      - user_id (FK)
      - type (String)
      - threshold (Decimal)
      - achieved_at (DateTime)

verification_flow:
  - functional_testing:
      - "Confirm that influence decreases exponentially as cost increases (Quadratic)."
      - "Verify that a certificate's signature matches the brand's master key when re-calculated."
      - "Ensure milestones trigger only once per user."
  - automated_tests:
      - Unit: `QuadraticMathTest`.
      - Feature: `ImpactPortfolioVisualizationTest`.

risks_unknowns:
  - explaining "Quadratic Voting" to users in a way that doesn't feel like a penalty for high contributors.
  - performance of real-time trend line generation for thousands of users.
