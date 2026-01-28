# Copilot / AI Agent Instructions

**Purpose:** Guidance for AI coding agents working productively in this educational repository.

## Project Overview

- **Type:** Educational repository for 2BAT course — JavaScript and Python learning exercises
- **Structure:** Static HTML/JS files (no build system, no tests, no CI)
- **Content locations:**
  - Exercises: `Exercices/JS/` (Spanish-named files: `Ejercicio N.html`)
  - Tutorials/examples: `how-to-code/JS/`
  - Knowledge base: `KNOWLEDGE.md` (comprehensive JS fundamentals reference)

## File Organization & Conventions

- **Exercise naming:** `Ejercicio <N>.html` (e.g., `Ejercicio 1.html`, `Ejercicio 2.html`) placed in `Exercices/JS/`
- **File structure:** Minimal single-file HTML with inline `<script>` and explanatory comment
- **Minimal template:**
  ```html
  <!doctype html>
  <html>
  <head><meta charset="utf-8"><title>Ejercicio N</title></head>
  <body>
  <!-- Ejercicio N: short description -->
  <script>
  // Code here
  </script>
  </body>
  </html>
  ```
- **Language:** All comments, variables, functions, and user-facing strings must be in **Spanish** (e.g., `const suma = 0;` not `const sum = 0;`)
- **Output:** Render results into page (e.g., `<div id="resultado">`) AND log to Console

## Developer Workflows

- **Running exercises:** Open HTML file in browser or use VS Code Live Server extension (`File > Open with Live Server`)
- **Debugging:** Use browser DevTools (Console, Elements)
- **No special build/test setup:** Files are static; no npm scripts, no test runners

## Submission Checklist for New Exercises

1. Create `Exercicio <N>.html` in `Exercices/JS/`
2. Add one-line comment at top: `<!-- Ejercicio N: short description -->`
3. Use minimal inline HTML/JS template (see above)
4. Write comments and code in Spanish
5. Output to both page element and Console
6. Update `README.md` under `## Javascript` section with link and short description
7. Commit with focused message: `Add: Ejercicio N — short description`

## Key Learning Resources

- `KNOWLEDGE.md`: Complete JS fundamentals (variables, conditionals, loops, forms, arrays) — reference for understanding exercise requirements
- `README.md`: Exercise index and project structure

## Scope & Knowledge Constraints

**⚠️ CRITICAL:** Only use JavaScript concepts documented in `KNOWLEDGE.md`. Do NOT introduce advanced features or concepts outside this scope.

Allowed concepts:
- Variables (`var`), data types (números, cadenas, booleanos)
- Operators (arithmetic, logical: `&&`, `||`, `!`, `^`)
- Conditionals (`if/else`, `switch`)
- Loops (`for`, `while`)
- Functions and arrays
- Form handling and DOM manipulation

**Forbidden:** ES6+ features, classes, async/await, destructuring, arrow functions, modules, external libraries

## Critical Notes

- **Avoid:** Build tools, linters, test frameworks, external dependencies — keep everything self-contained
- **Preserve:** Single-file, standalone nature of each exercise
- **Patterns:** Mirror existing exercise structure for consistency and ease of review
