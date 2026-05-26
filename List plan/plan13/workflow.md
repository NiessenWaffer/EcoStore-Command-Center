# Project Workflow Contract

sequence_id: 13
artifact_folder: List plan/plan13/
source_plan: List plan/plan13/plan.md
status: ready_for_developer_tasking

precise_user_flow:
  - id: view_creator_attribution_public
    description: A guest or customer views the project creator signature in the footer.
    entrypoint: Any Public Page
    steps:
      - system renders the main layout footer.
      - system displays a subtle "Created by Ronie R. Pactol" text in the lower-right baseline.
      - system ensures opacity is low (e.g., 30-40%) to maintain professional watermark feel.
    success_state: Creator name is visible but non-distracting.

  - id: view_creator_attribution_admin
    description: An admin views the formal signature in the Command Center.
    entrypoint: Admin Dashboard (/admin)
    steps:
      - system renders the Admin Command Center dashboard.
      - system displays a professional signature/seal in the "Infrastructure Status" sidebar or dashboard footer.
    success_state: Admin interface formally acknowledges the lead developer.

  - id: verify_code_metadata
    description: A developer or technical auditor checks the source code for attribution.
    entrypoint: Browser "View Source" or IDE
    steps:
      - system includes `<meta name="author" content="Ronie R. Pactol">` in root layouts.
      - system includes a styled HTML comment at the top of the `<body>` or `<head>`.
    success_state: Project provenance is preserved at the source level.

frontend_first_sequence:
  - slice_1: Global Footer Attribution
    rationale: Provides immediate visibility across all pages with minimal layout impact.
    user_workflow: view_creator_attribution_public
    frontend_layout_controls:
      - `AppFooter`: Updated text node.
      - `AdminFooter`: Updated text node.
    image_slots: none

controls_routing: none

backend_contract: none

database_contract: none

verification_flow:
  - functional_testing:
      - "Verify that the signature persists when navigating between Shop, Mission, and Dashboard."
      - "Ensure the watermark does not overlap the Livewire Cart or Admin Dock."
  - automated_tests:
      - Feature: `AttributionVisibilityTest`.

risks_unknowns:
  - overlapping UI: ensure fixed-position watermarks don't block mobile tap targets.
