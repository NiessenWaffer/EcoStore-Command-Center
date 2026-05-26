# Implementation Task Checklist: Plan 2

status: completed
create_structure_owner: planning_mode
execution_update_owner: developer_mode
source_plan: List plan/plan2/plan.md
source_workflow: List plan/plan2/workflow.md
root_rule: plan.md -> workflow.md -> task.md

TASKS:
- [x] task_id: secure_registration_token_system
  - source_workflow_section: guest_to_customer_onboarding_via_impact
  - implementation_scope: Develop a token generation and validation service for merging guest session data into new accounts.
  - files_areas: app/Services/RegistrationTokenService.php, app/Http/Controllers/Auth/RegisterController.php
  - [x] functional_check_1: Backend logic: Token is generated and stored with expiration.
  - [x] functional_check_2: Merge logic: Registering with a token correctly attributes guest orders to the new User.

- [x] task_id: dynamic_svg_email_engine
  - source_workflow_section: impact_recap_email
  - implementation_scope: Build a service to generate dynamic SVG infographics (e.g., water filling pool) for personalized impact emails.
  - files_areas: app/Services/EmailGraphicService.php, resources/views/emails/impact_recap.blade.php
  - [x] functional_check_1: SVG rendering: Service returns valid SVG strings for both Water and Carbon metrics.
  - [x] functional_check_2: Email UI: The impact recap email correctly embeds and displays the SVG graphics.

- [x] task_id: referral_engine_and_qr_generation
  - source_workflow_section: refer_a_friend_mission_cycle
  - implementation_scope: Implement referral code generation, QR code service, and "Mission Landing Page" with friend's name/impact.
  - files_areas: app/Http/Controllers/ReferralController.php, resources/views/referral/mission_page.blade.php
  - [x] functional_check_1: Referral logic: Unique referral codes are generated for new users.
  - [x] functional_check_2: QR Service: QR code URL correctly encodes the referral link.
  - [x] functional_check_3: Mission Page: Landing page displays the referrer's name and their cumulative impact.

- [x] task_id: referral_fraud_prevention_logic
  - source_workflow_section: manage_referral_integrity_admin
  - implementation_scope: Integrate device fingerprinting and IP validation to flag potential self-referrals.
  - files_areas: app/Services/FraudDetectionService.php, app/Http/Middleware/DetectFraud.php
  - [x] functional_check_1: Middleware: `device_fingerprint` cookie is set upon first visit.
  - [x] functional_check_2: Fraud logic: Service correctly identifies if referrer and referee share the same IP/fingerprint.

- [x] task_id: community_challenge_aggregation
  - source_workflow_section: participate_in_community_impact_challenge
  - implementation_scope: Develop the backend logic for global impact aggregation and individual contribution tracking.
  - files_areas: app/Models/CommunityChallenge.php, app/Services/GlobalImpactService.php
  - [x] functional_check_1: Aggregation: New orders automatically increment active challenge progress.
  - [x] functional_check_2: User tracking: System accurately calculates a user's individual % contribution to a challenge.

- [x] task_id: ambassador_dashboard_ui
  - source_workflow_section: referral_dashboard
  - implementation_scope: Build the "Share the Mission" portal with social sharing buttons, impact bonus logic, and network metrics.
  - files_areas: resources/views/dashboard/ambassador.blade.php
  - [x] functional_check_1: Frontend UI: Ambassador portal displays referral link, QR code, and network impact stats.
  - [x] functional_check_2: Community visibility: Active challenges and progress bars are visible and accurate.

- [x] task_id: scheduled_impact_recap_task
  - source_workflow_section: business_rules (Impact Recap Timing)
  - implementation_scope: Configure a Laravel scheduled task to send the Impact Recap Email 24 hours after a guest purchase.
  - files_areas: app/Console/Commands/SendImpactRecap.php, routes/console.php
  - [x] functional_check_1: Command logic: `app:send-impact-recap` correctly identifies guest orders due for a recap.
  - [x] functional_check_2: Scheduling: Command is registered and scheduled to run hourly.
