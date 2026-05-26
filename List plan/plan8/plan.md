# Project Plan Contract

sequence_id: 8
artifact_name: unified_brand_experience
artifact_folder: List plan/plan8/
artifact_scope: UI_unification_and_navigation_architecture
depends_on: 1, 2, 3, 4, 5, 6, 7
status: completed
mode: interactive_discovery
project_goal: Weld all existing functional "islands" (Shop, Resale, Governance, Tracking, Fit, Passports) into a single, cohesive brand ecosystem with intuitive navigation and a centralized user command center.
target_users: all customers, ambassadors, brand admins
success_criteria:
  - 100% of functional modules are reachable within 2 clicks from any page.
  - Global Header features categorized dropdowns for "Community" and "Circularity".
  - User Dashboard is refactored into a "Unified Command Center" with tabbed access to all personal data.
  - Footer provides comprehensive site-map level access to transparency and support tools.
page_screen_contracts:
  - global_header_v2: Mega-menu style dropdowns for Circularity (Resale, Recycling, Passports) and Community (Governance, Ambassador Portal, Challenges).
  - unified_command_center: A high-fidelity dashboard layout with vertical or horizontal sub-nav: Overview, My Orders, Impact Tracking, My Resales, Governance Power, Fit Profile.
  - site_wide_footer_v2: 4-column layout including "Radical Transparency" links (Supply Chain, Metrics) and "Customer Care" (Tracking, Returns).
  - admin_quick_access_dock: A secure, visibility-restricted UI element for admins to jump between Admin Products, Hubs, and Governance.
section_action_contracts:
  - navigation_category_toggle: Hover/Click interaction for mega-menus.
  - dashboard_tab_switcher: Real-time Livewire/Alpine tab switching for the command center.
  - dynamic_impact_ticker: Small scrolling or rotating element in header showing collective community water saved.
design_content_strategy:
  - "Ecosystem" aesthetic: unified font scaling, consistent spacing across all "islands," and a singular color palette (Earth Stone & Eco Green).
  - connectivity focus: use breadcrumbs and "Next Step" suggestions (e.g., after buying, suggest setting up Fit Profile).
visual_asset_strategy:
  - custom icon set for different dashboard tabs.
  - micro-animations for dropdown transitions.
integration_context:
  related_plan_ids: 1, 2, 3, 4, 5, 6, 7
  shared_entities: User, Order, ProductPassport, ResaleTradeIn, GovernanceVote
  dependencies: all previous services
  handoff_points: This plan acts as the "Seal" for all previous work.
connected_artifacts:
  connected_to: 1, 2, 3, 4, 5, 6, 7
  connected_files: resources/views/components/layouts/app.blade.php, resources/views/dashboard/index.blade.php
  connection_scope: navigation_and_ux_cohesion
  connection_reason: Unifies disparate features into a single user journey.
  read_required_for_implementation: true
primary_user_workflows:
  - navigate_entire_brand_ecosystem
  - manage_personal_impact_and_assets_centrally
  - admin_access_all_management_modules
workflow_logic_checks:
  - role_based_nav_visibility: Admin links only show for `is_admin` users.
  - mobile_nav_completeness: Mega-menus must collapse into a functional accordion on mobile.
  - active_state_tracking: Highlight the current "island" in the header/nav to prevent user disorientation.
roles_permissions:
  - customer: access all standard nav and user command center.
  - ambassador: extra "Community" tools visible in command center.
  - admin: access admin dock and all management endpoints.
core_entities_data:
  - NavigationSchema: (Virtual) Hierarchical map of all routes.
  - UserPreference: (Existing) Store last visited dashboard tab.
integrations:
  - Internal: Connecting all existing Livewire components into the new layout structure.
notifications_reports:
  - welcome_to_ecosystem_tour: One-time UI hints for first-time users.
MVP_scope:
  - Header & Footer V2 implementation.
  - Refactored Unified User Dashboard (Command Center).
  - Admin Quick-Access Dock.
deferred_scope:
  - Interactive onboarding tour.
  - Personalized "Next Action" AI engine in the dashboard.
research_notes:
  - Evaluate performance of loading multiple Livewire components in a tabbed view (use `wire:lazy`).
  - Check accessibility of mega-menu interactions.
assumptions:
  - All existing routes are functional and named correctly.
  - CSS variables in `app.css` are sufficient for site-wide styling consistency.
open_questions:
  - Should the Admin Dock be a sidebar or a floating action button? (Decision: Sidebar for desktop, FAB for mobile).
  - Do we need a search bar inside the User Dashboard? (Answer: Yes, for Order/Resale history).
