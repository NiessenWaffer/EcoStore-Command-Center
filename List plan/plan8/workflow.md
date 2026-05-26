# Project Workflow Contract

sequence_id: 8
artifact_folder: List plan/plan8/
source_plan: List plan/plan8/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: navigate_entire_brand_ecosystem
    description: User seamlessly jumps from shopping to governance to resale using the new header.
    entrypoint: Any page (Global Header)
    steps:
      - user hovers over "Circularity" in the header.
      - system reveals dropdown with "Resale Portal" and "Traceability (Passports)".
      - user clicks "Resale Portal".
      - user is redirected to `/resale` and the header highlights the "Circularity" section as active.
    success_state: User feels the system is one connected brand rather than separate tools.
    failure_state: Dead links or inconsistent header behavior on specific pages.

  - id: manage_personal_impact_and_assets_centrally
    description: User manages all personal data from a single "Command Center" dashboard.
    entrypoint: /dashboard
    steps:
      - user enters dashboard.
      - user sees sidebar with tabs: "Orders," "Eco-Impact," "My Resales," "Governance," "Fit Profile."
      - user clicks "Governance."
      - system loads the `GovernanceHub` component within the dashboard frame without full page reload.
    success_state: No "page hopping" required for personal management.
    failure_state: Component load failures or slow response during tab switching.

frontend_first_sequence:
  - slice_1: Global Header & Footer V2
    rationale: The primary "Weld" that connects all pages.
    user_workflow: navigate_entire_brand_ecosystem
    frontend_layout_controls:
      - `MegaMenu`: Component for Circularity and Community categories.
      - `ImpactTicker`: Micro-ticker for collective impact data.
      - `ModernFooter`: 4-column layout for site-wide discovery.
    image_slots:
      - Small icons for dropdown categories.
    sample_data_contract:
      - Global Impact: `1,250,000L Water Saved` collective.

  - slice_2: Unified User Command Center (Tabbed Dashboard)
    rationale: Consolidates the fragmented user experience into a central management point.
    user_workflow: manage_personal_impact_and_assets_centrally
    frontend_layout_controls:
      - `CommandCenterSidebar`: Vertical navigation for dashboard tabs.
      - `TabContentLoader`: Dynamic frame for existing Livewire components.
    image_slots:
      - Iconography for each management tab.
    sample_data_contract:
      - User: with linked Resales, Orders, and Governance Weight.

  - slice_3: Admin Quick-Access Dock
    rationale: Improves developer and brand manager efficiency.
    user_workflow: admin_access_all_management_modules
    frontend_layout_controls:
      - `AdminDock`: Sidebar visible only to `is_admin`.
    image_slots:
      - Admin module icons.

controls_routing:
  - GET /dashboard/{tab?}: Route parameter for direct linking to specific dashboard tabs.
  - POST /admin/access-request: Secure check for admin dock visibility.

backend_contract:
  - NavigationService:
      - `getActiveSection(string $route)`: returns the root category (Shop, Circularity, Community) for header highlighting.
  - GlobalImpactService (Updated):
      - `getCollectiveImpact()`: returns sum of impact across all users for the ticker.

database_contract:
  - (No major schema changes required, uses existing model relationships).

sample_data_contract:
  - (Uses existing seeders).

verification_flow:
  - functional_testing:
      - "Verify that all dropdown links point to active, functional routes."
      - "Verify dashboard tab state persists across refreshes (using route params)."
      - "Ensure mobile menu contains 100% of the desktop navigation items."
  - automated_tests:
      - Feature: `GlobalNavigationTest`.
      - Feature: `CommandCenterTabTest`.

risks_unknowns:
  - complexity of megamenu on small screens (use Tailwind hidden/block patterns).
  - hydration issues when multiple complex Livewire components are ready in background tabs.

not_yet_implementing:
  - In-app notification system (Plan 9).
  - Multi-language navigation.
