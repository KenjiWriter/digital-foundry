# ROADMAP: Digital Foundry v2.0

**Goal:** Transform the MVP into a "Living Application" with data intelligence and cinematic visuals.

## Phase 5: Intelligence & CRM (The Brain)
*Focus: Capturing data and managing leads within the application.*

-   **Lead Storage:**
    -   [ ] Modify Contact Form flow: Save to DB -> Email Notification -> Frontend Success.
    -   [ ] Build **Admin Leads View**: A table to view, filter, and delete contact requests.
-   **Privacy-First Analytics:**
    -   [ ] Implement a lightweight middleware to track **Unique Visitors** and **Avg. Time on Page**.
    -   [ ] Add an "Analytics Widget" to the Admin Dashboard (replacing the static placeholder).
-   **Refinement:**
    -   [ ] **Global Branding Fix:** Replace all hardcoded "ROI Stack" instances with dynamic `APP_NAME` usage.

## Phase 6: The "Living" UI (The Beauty)
*Focus: High-end interactions using Canvas/Three.js concepts.*

-   **Cinematic Preloader:**
    -   [ ] Create a **3D Wireframe Globe** (CSS 3D or Lightweight Three.js).
    -   [ ] Animation: Globe spins in center -> Page Loads -> Globe moves to background layer.
-   **Hero Dynamics:**
    -   [ ] **Typewriter Effect:** Implement a typing animation for the H1 headline on load.
    -   [ ] **Parallax Core:** The background Globe rotates and moves slightly based on scroll position.
-   **Interactive Grid (The "Dissolve" Effect):**
    -   [ ] Replace static CSS grid with an **HTML5 Canvas** component.
    -   [ ] Physics: Grid lines float gently.
    -   [ ] Interaction: Mouse hover causes lines to "dissolve/separate" and reform (Matrix/Data stream vibe).
