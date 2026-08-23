# Contributing to X1

Thanks for helping improve X1 public software.

## Before you change code

For non-trivial work, first confirm the problem, the repository scope and the authority boundary. Do not add a second source of truth for state owned by another X1 system.

Use an issue when the change affects compatibility, security, public behavior, data models or user-visible workflows.

## Contribution rules

- Keep changes focused and reviewable.
- Preserve existing public contracts unless a deliberate compatibility change is documented.
- Do not commit secrets, credentials, private keys, signing material, customer data or production databases.
- Do not include third-party content, artwork, feeds or assets unless redistribution/use rights are compatible with the repository.
- Add or update tests when behavior changes.
- Update documentation when installation, configuration, compatibility or user-visible behavior changes.
- Include screenshots for meaningful UI changes.

## Evidence

State technical confidence accurately:

`PROVEN BY SOURCE` · `PROVEN BY TEST` · `PROVEN BY RUNTIME` · `INFERRED` · `UNKNOWN / UNPROVEN` · `RUNTIME NOT VERIFIED`

Do not convert source presence or a successful build into a runtime or production claim.

## Pull requests

A pull request should explain:

1. what problem is being solved;
2. what changed;
3. what was tested;
4. what remains unverified;
5. whether compatibility, security, data authority or legal/rights boundaries changed.

Keep unrelated cleanup out of the same pull request unless it is required for the change.

## Reporting sensitive issues

Do not publish exploit details or secrets in a public issue. Follow `SECURITY.md` for security reports.
