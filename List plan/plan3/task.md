# Implementation Task Checklist: Plan 3

status: completed
create_structure_owner: planning_mode
execution_update_owner: developer_mode
source_plan: List plan/plan3/plan.md
source_workflow: List plan/plan3/workflow.md
root_rule: plan.md -> workflow.md -> task.md

TASKS:
- [x] task_id: product_passport_qr_system
  - source_workflow_section: view_radical_transparency_passport
  - implementation_scope: Develop unique QR generation for garments; link to factory/batch data model.
  - files_areas: app/Services/PassportService.php, resources/views/passports/show.blade.php
  - [x] functional_check_1: Backend logic: `PassportService` generates unique tokens and correctly links Product/Factory.
  - [x] functional_check_2: Frontend UI: Passport detail page displays factory ethical score and audit summary.
  - [x] functional_check_3: Asset verification: Manufacturing date and batch number match the database record.

- [x] task_id: true_cost_dynamic_ui
  - source_workflow_section: design_content_strategy
  - implementation_scope: Build a dynamic pricing component for product pages showing the Materials/Labor/Profit split.
  - files_areas: resources/views/components/true-cost.blade.php, app/Models/Product.php
  - [x] functional_check_1: Component rendering: `true-cost` component displays proportional bars for cost segments.
  - [x] functional_check_2: Data accuracy: Total breakdown sum matches the retail price of the product.

- [x] task_id: trade_in_verification_portal
  - source_workflow_section: trade_in_preloved_item
  - implementation_scope: Implement the resale submission flow; validate original order ownership.
  - files_areas: app/Http/Controllers/ResaleController.php, resources/views/resale/submit.blade.php
  - [x] functional_check_1: Order validation: User can only select products from their completed order history.
  - [x] functional_check_2: Form submission: Trade-in request is created with "pending" status and estimated credit.

- [x] task_id: circular_credit_logic
  - source_workflow_section: trade_in_preloved_item
  - implementation_scope: Develop logic for releasing store credit and the +200L recycling impact bonus.
  - files_areas: app/Services/CreditService.php, app/Models/User.php
  - [x] functional_check_1: Credit release: Verifying a trade-in correctly increments user `store_credit_cents`.
  - [x] functional_check_2: Impact bonus: User receives exactly +200L water saved upon verification.
  - [x] functional_check_3: Status update: Trade-in status changes to "credited" and verified timestamp is set.
