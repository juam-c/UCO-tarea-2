# AGENTS.md

## Project shape

- `index.php` is the only application source file. Despite the `.php` extension it is a standalone static HTML document (blank scaffold), not a PHP application or framework entrypoint.
- This project keeps its OpenCode instructions in `.opencode/AGENTS.md`; there is no `opencode.json` or other configuration.

## Build, test, lint

- None configured. There is no package manager, framework, build step, test runner, or linter — do not introduce or assume one.
- Verify changes by opening `index.php` in a browser (or inspecting its HTML directly).

## Conventions

- Keep all page markup in `index.php`.
- Preserve document-level metadata: `lang="en"`, UTF-8 charset, and the responsive viewport meta.
- Keep the `lang` attribute consistent with the page content if that content changes.
