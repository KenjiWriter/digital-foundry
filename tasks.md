# TASKS (Technical Checklist)

## Phase 5: Intelligence & CRM

- [ ] **[Refactor] Dynamic App Name:**
    -   Search `Welcome.vue`, `MainLayout.vue`, `Footer.vue`.
    -   Replace "Digital Foundry" (string) with `usePage().props.appName`.
    -   Ensure `HandleInertiaRequests.php` shares `appName` from `.env`.
- [ ] **[Database] Leads Migration:**
    -   Create `leads` table: `name`, `email`, `website` (nullable), `message`, `ip_address`.
- [ ] **[Backend] Lead Capture:**
    -   Update `ContactController`: Store data in `Lead` model before sending email.
- [ ] **[Admin] Leads Manager:**
    -   Create `Admin/Leads/Index.vue` (Data Table).
    -   Create `Admin/Leads/Show.vue` (Detail view for reading long messages).
- [ ] **[Analytics] Tracker Logic:**
    -   Create `TrackVisits` middleware.
    -   Store daily counts in a simple `site_stats` table (date, visits, total_duration).
    -   Update `Dashboard.vue` to fetch and display a Chart/Graph of last 30 days.

## Phase 6: The "Living" UI (Advanced)

- [ ] **[Component] TypewriterText.vue:**
    -   Reusable component that takes a string and types it out character by character with a blinking cursor.
- [ ] **[Component] DigitalGlobe.vue:**
    -   Implement a wireframe sphere.
    -   **State 1 (Loading):** Centered, opaque, fast spin.
    -   **State 2 (Background):** Fixed position, low opacity, slow spin, scroll-based rotation (Parallax).
- [ ] **[Component] InteractiveGrid.vue (Canvas):**
    -   **Setup:** Full-screen HTML Canvas behind content.
    -   **Logic:** Draw grid lines via JS.
    -   **Animation:** Add "Perlin Noise" or Sine waves to make lines float.
    -   **Interaction:** Calculate distance from mouse. If mouse is close, push points away or reduce opacity (dissolve effect).
