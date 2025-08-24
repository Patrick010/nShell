# Lessons Learnt Log

**Purpose:**
To capture key takeaways from the nShell project across all phases.

---

## Process & Workflow Lessons

| Lesson | Impact |
|---|---|
| **A "plan-and-approve" workflow is essential.** Submitting a plan for user approval before starting work prevents wasted effort and ensures alignment. | **High** |
| **A "report after submit" workflow is crucial for communication.** Providing a high-level summary after each submission keeps the user informed of progress and accomplishments. | **High** |
| **The `TASK_CHECKLIST.md` is an invaluable quality gate.** Using it for review catches omissions (e.g., missing docblocks, traceability updates) that would otherwise become technical debt. | **High** |
| **"Living documentation" requires extreme diligence.** Logs, execution plans, and design documents must be updated with every single commit, including minor fixes, to remain a reliable source of truth. | **High** |

---

## Technical & Architectural Lessons

| Lesson | Impact |
|---|---|
| **Clarify framework conventions early.** Misunderstanding the standard location for app files (e.g., the `templates/` directory) led to a necessary refactoring. This should be confirmed at the start. | **Medium** |
| **Refactor to a clean structure as soon as the need is identified.** Moving all app code into a self-contained `nShell/` directory significantly improved maintainability and simplified the build process. This should have been done earlier. | **High** |
| **Assume nothing about the execution environment.** The initial assumption that `composer` would be available was incorrect. The environment had no PHP, and even after installing it, `composer install` failed due to file limits. | **High** |
| **Develop and test workarounds for environment constraints.** The manual PSR-4 autoloader was a successful workaround for the lack of Composer. The `.gitkeep` file was a necessary workaround for the environment's auto-pruning of empty directories. | **High** |
| **The `rename` and `mv` commands can be unreliable.** The `run_in_bash_session` tool with `mv` was more reliable for moving directories than the dedicated `rename_file` tool, which failed intermittently. | **Medium** |

---
