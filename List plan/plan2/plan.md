# Project Plan Contract

sequence_id: 2
artifact_name: guest_to_ambassador_conversion
artifact_folder: List plan/plan2/
artifact_scope: re-engagement_and_loyalty_flow
depends_on: 1
status: ready_for_implementation
mode: planning
project_goal: Convert one-time guest shoppers into loyal brand advocates through personalized sustainability impact reporting and referrals.
target_users: Post-purchase guest users, Registered customers
page_screen_contracts:
  - impact_recap_email: personalized summary of environmental savings with dynamic SVG infographics (e.g., filling pool visuals)
  - registration_landing_page: focused CTA to save history and join the community; "Save Your Impact" widget as primary hook
  - referral_mission_landing_page: personalized onboarding for invited friends; "Claim your invite discount" sticky banner
  - referral_dashboard: "Share the Mission" portal showing "Friends Joined," "Direct Rewards," and "Network Impact"
  - community_challenge_dashboard: global mission status, real-time counter, and individual contribution %
design_content_strategy:
  - educational and celebratory tone
  - "User-centric mission" focus
  - real-world impact equivalencies integrated into dashboard and emails
visual_asset_strategy:
  - personalized impact infographics for emails (dynamic filling pools/trees)
  - community "Global Impact" live counter visuals
  - personalized referral cards for the mission landing page
  - dynamic QR code generation: Impact Cards include a unique QR code leading to the user's public impact profile or the mission landing page
integration_context: Laravel 13, Email Service, Social Sharing APIs
connected_artifacts:
  connected_to: 1
  connected_files: List plan/plan1/plan.md
  connection_scope: shared_user_journey
  connection_reason: builds upon the guest checkout flow in plan1
  read_required_for_revision: true
primary_user_workflows:
  - guest_to_customer_onboarding_via_impact: session-to-account merge using secure token
  - refer_a_friend_for_sustainability_credits: hybrid rewards (financial for referee, mission for referrer)
  - invited_friend_onboarding_via_mission_page: trust-building story before shopping
  - participate_in_community_impact_challenges: collective goals with public donations upon success
workflow_logic_checks:
  - impact_history_merging: Transfer session/cookie impact data to new DB user record via secure session-linked token
  - referral_reward_validation: Rewards marked as "Pending" until referee's 30-day return window expires
  - referral_attribution_logic: Correctly attribute new registrations and purchases to the referrer
  - referral_fraud_prevention: Device fingerprinting and IP-based logic to detect/block self-referral
  - qr_code_redirection_logic: Ensure QR codes correctly map to the referrer's mission page or public profile
  - collective_impact_aggregation: Real-time calculation of community-wide progress against time-bound goals
  - social_sharing_bonus_trigger: Grant one-time impact bonus (+50L) on first social share of Impact Card
  - polymorphic_contribution_history: Impact data linked to either User or GuestSession for seamless merging/anonymization
roles_permissions:
  - guest (post-purchase): view ephemeral impact, register
  - customer: manage referral links, track referral/network impact, contribute to community challenges, view public profiles (opt-in)
  - admin: manage community challenges, set global goals, moderate leaderboard, manage referral fraud reports
core_entities_data:
  - Referral: referrer_id, referee_email, status (pending/confirmed), reward_granted
  - User: (extend from plan1) referral_code, lifetime_community_impact, network_impact, leaderboard_opt_in (Boolean)
  - CommunityChallenge: title, goal_metric, target_value, current_value, start_date, end_date, donation_target
  - Milestone: benchmark_name, threshold_value (exponential tiers: 500L, 2500L, 10000L), reward_details
business_rules:
  - Registration Incentive: Lead with the "Lifetime Sustainability Dashboard" (Mission-Driven) as the primary hook for guest conversion.
  - Hybrid Referral Rewards: Referrer receives mission-aligned rewards; Referee receives a financial incentive (10% discount).
  - Referral Entry: Invited friends land on a Personalized Mission Landing Page to build trust and context.
  - Impact Recap Timing: Sent 24 hours post-purchase to maximize re-engagement.
  - Actionable Social Proof: Impact Cards must include a dynamic QR code.
  - Community Challenges: Time-bound collective goals with public donations to related causes upon success.
  - Referral Integrity: Protection against self-referral via fingerprinting; 30-day payout delay.
  - Success Celebration: "Challenge Hero" badges for participants upon goal completion.
  - Social Bonus: Incentivize the first share with a one-time impact credit.
  - Database Integrity: Use composite indexes on impact metrics for high-speed leaderboard rendering.
integrations:
  - Social Meta Tag Generation (for referral link preview)
  - URL Shortener/Unique Link Service
  - QR Code Generation API/Service
  - Email Service (Postmark/Mailgun) with support for dynamic SVG/Infographics
notifications_reports:
  - registration_welcome_impact_email
  - referral_success_notification
  - community_challenge_cadence: Kick-off, Mid-month Progress, Final 72 Hours emails
  - impact_milestone_celebration_email
MVP_scope:
  - Post-purchase registration flow with zero-data-loss merge
  - Basic referral link generation with fraud protection
  - Active Community Challenge dashboard with global donation link
  - 24h Impact Recap automated email
deferred_scope:
  - tiered referral rewards
  - influencer/affiliate dashboard
research_notes:
  - best practices for mission-driven referral conversion
assumptions:
  - users are motivated by seeing their environmental contribution grow and being part of a collective goal
open_questions:
  - none
success_criteria:
  - > 20% of guest users convert to registered accounts within 7 days of purchase
  - Referrals account for > 10% of total MVP traffic
  - > 30% of active users engage with the Community Challenge dashboard monthly
  - < 2% referral fraud rate through technical enforcement
