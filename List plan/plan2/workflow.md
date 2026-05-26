# User Workflows: Plan 2

status: ready_for_implementation_planning
source_plan: List plan/plan2/plan.md

WORKFLOWS:
  - id: guest_to_customer_onboarding_via_impact
    description: Guest converts to a registered user without losing their purchase impact history.
    entrypoint: Order Success Page or 24h Impact Email
    steps:
      - user clicks "Save Your Impact"
      - system generates a secure, time-limited token linked to the guest session/order
      - user completes registration form
      - system validates token and migrates "Impact History" (Water/Carbon) from guest session to the new user record
    success_state: User sees their full lifetime impact dashboard immediately after login.
    failure_state: Token expired or invalid; user registers but must manually link order (Edge case).

  - id: refer_a_friend_mission_cycle
    description: Registered user refers a friend and earns mission achievements.
    entrypoint: Referral Dashboard
    steps:
      - user generates a unique referral link/QR code
      - user shares link to social media (earns one-time +50L bonus)
      - friend clicks link and lands on the "Personalized Mission Landing Page"
      - friend completes purchase (Referee discount applied)
      - system marks Referrer reward as "Pending" (visible in dashboard)
      - after 30 days (no return), Referrer is credited with "Mission Achievement" / Tree Planting
    success_state: Referrer sees "Network Impact" grow and receives a success notification.
    failure_state: Self-referral detected via fingerprinting; reward blocked.

  - id: participate_in_community_impact_challenge
    description: Users contribute collectively to a global environmental goal.
    entrypoint: Community Challenge Dashboard
    steps:
      - system activates a new challenge (e.g., "Save 1M Liters in June")
      - user makes a purchase or refers a friend during the challenge period
      - system aggregates this impact into the global "Current Value" counter
      - user views their individual "Contribution %" to the goal
    success_state: Goal met; brand makes public donation; user receives "Challenge Hero" badge.
    failure_state: Goal not met; challenge expires with a "Close, let's try again" recap.

  - id: manage_referral_integrity_admin
    description: Admin monitors and resolves referral fraud.
    entrypoint: Admin Dashboard -> Referral Management
    steps:
      - admin views list of "Flagged" referrals (detected by fingerprinting/IP)
      - admin reviews user history
      - admin manually approves or rejects the reward
    success_state: Fraudulent rewards are blocked, maintaining platform integrity.
    failure_state: None.
