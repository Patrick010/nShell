# Traceability Matrix – nShell

**Status:** Live Document as of 2025-08-23

This matrix provides traceability between project requirements, design artifacts, and implementation tasks.

## Legend
- ✅ Implemented
- 🟡 Partial / In Progress
- ❌ Not Started

| Requirement ID | Description | Source Document(s) | Design Artifact(s) | Implementation Task(s) | Status |
|---|---|---|---|---|---|
| **Core Principles** | | | | | |
| REQ-01 | Zero-Config Principle | `PID.md` | `HLD.md`, `LLD.md` | `NS-FEAT-005` | ❌ Not Started |
| REQ-02 | Secure by Default | `PID.md`, `SECURITY.md` | `HLD.md`, `LLD.md` | `NS-FEAT-002`, `NS-FEAT-005` | 🟡 Partial |
| REQ-03 | Full Configurability | `PID.md` | `HLD.md`, `LLD.md` | `NS-FEAT-003`, `NS-FEAT-004` | 🟡 Partial |
| REQ-04 | Session Isolation | `PID.md`, `SECURITY.md` | `HLD.md`, `LLD.md` | `NS-FEAT-001` | 🟡 Partial |
| **Features** | | | | | |
| REQ-05 | Shell Management | `PID.md` | `LLD.md` | `NS-FEAT-001` | 🟡 Partial |
| REQ-06 | Session Management | `PID.md` | `LLD.md` | `NS-FEAT-001` | 🟡 Partial |
| REQ-07 | SSH Restrictions | `PID.md`, `SECURITY.md` | `LLD.md` | `NS-FEAT-002` | 🟡 Partial |
| REQ-08 | Environment & Appearance | `PID.md` | `LLD.md` | `NS-FEAT-003`, `NS-FEAT-004` | 🟡 Partial |
| REQ-09 | UI: Admin Panel | `PID.md` | `LLD.md` | `NS-FEAT-003`, `NS-FEAT-004` | 🟡 Partial |
| REQ-10 | UI: User Terminal | `PID.md` | `LLD.md` | `NS-FEAT-003`, `NS-FEAT-004` | 🟡 Partial |
| REQ-11 | Logging & Auditing | `PID.md` | `LLD.md` | `NS-FEAT-001` | 🟡 Partial |
| **Use Cases** | | | | | |
| UC-01 | Admin: Initial Secure Setup | `USECASES.md` | `HLD.md`, `LLD.md` | `NS-FEAT-005` | ❌ Not Started |
| UC-02 | Admin: Loosen Restrictions | `USECASES.md` | `LLD.md` | `NS-FEAT-002`, `NS-FEAT-004` | 🟡 Partial |
| UC-03 | Admin: Audit User Activity | `USECASES.md` | `LLD.md` | `NS-FEAT-001` | 🟡 Partial |
| UC-04 | User: Basic Server Management | `USECASES.md` | `LLD.md` | `NS-FEAT-004` | ❌ Not Started |
| UC-05 | User: Custom Environment | `USECASES.md` | `LLD.md` | `NS-FEAT-001`, `NS-FEAT-004` | 🟡 Partial |
| UC-06 | Admin: Customize Look and Feel | `USECASES.md` | `LLD.md` | `NS-FEAT-003`, `NS-FEAT-004` | 🟡 Partial |
| **Infrastructure** | | | | | |
| REQ-12 | App Registrability | `EXECUTION_PLAN.md` | `appinfo/` | `NS-INFRA-001` | ✅ Implemented |
