# Implementation Task Checklist: Plan 4

status: completed
create_structure_owner: planning_mode
execution_update_owner: developer_mode
source_plan: List plan/plan4/plan.md
source_workflow: List plan/plan4/workflow.md
root_rule: plan.md -> workflow.md -> task.md

TASKS:
- [x] task_id: fit_profile_wizard
  - source_workflow_section: create_ai_fit_profile
  - implementation_scope: Build body-profile entry form and "Shadow Profile" logic based on past order outcomes.
  - files_areas: app/Http/Controllers/FitProfileController.php, resources/views/fit/wizard.blade.php
  - [x] functional_check_1: Form validation: User measurements (Height/Weight) are captured and persisted.
  - [x] functional_check_2: UX verification: "Style Profile" initializes correctly and redirects to shop with success message.

- [x] task_id: ai_stylist_llm_integration
  - source_workflow_section: chat_with_sustainability_concierge
  - implementation_scope: Integrate OpenAI API with specialized system prompts for "Eco-Styling" and catalog RAG.
  - files_areas: app/Services/AIShstylistService.php, resources/views/livewire/shop/⚡ai-stylist.blade.php
  - [x] functional_check_1: RAG context: AI Concierge prepends user fit profile and product catalog to the system prompt.
  - [x] functional_check_2: Real-time chat: Chat widget correctly sends/receives messages using Livewire and GPT-4o.
  - [x] functional_check_3: Fallback logic: System provides mission-aligned mock responses if API key is missing.

- [x] task_id: return_impact_deterrent_ui
  - source_workflow_section: manage_return_with_impact_warning
  - implementation_scope: Build a high-friction return warning UI showing carbon/financial costs of the return.
  - files_areas: resources/views/returns/deterrent.blade.php, app/Services/CarbonCalculator.php
  - [x] functional_check_1: Calculation logic: `CarbonCalculator` provides weight-based CO2 estimates for returns.
  - [x] functional_check_2: High-friction UI: Deterrent page displays real-world equivalencies (e.g., smartphone charges) to discourage return.

- [x] task_id: zero_return_reward_engine
  - source_workflow_section: workflow_logic_checks (zero_return_reward_trigger)
  - implementation_scope: Implement scheduled job to reward users with a 5% discount after 3 consecutive 0-return orders.
  - files_areas: app/Console/Commands/RewardZeroReturns.php, app/Models/User.php
  - [x] functional_check_1: Audit logic: Command correctly identifies users with 3 consecutive 'completed' orders.
  - [x] functional_check_2: Fraud prevention: Reward logic prevents multiple rewards within the same month.
  - [x] functional_check_3: Notification: Reward generation is logged and `last_rewarded_at` timestamp is updated.
