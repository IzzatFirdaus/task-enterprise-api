---
paths:
  - 'app/**'
---

# App

## Admin RBAC boundary
Keep admin authorization and user-facing task flows separated by role checks and dedicated routes. Admin actions must be logged to audit_logs and protected behind admin or super_admin middleware.
