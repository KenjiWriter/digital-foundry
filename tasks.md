# Technical Tasks

## Phase 1: The "Value-First" Foundation

- [x] **Project Setup:** Initialize Laravel 12 project with Inertia + Vue 3 stack.
- [ ] **Styling Configuration:** Configure Tailwind CSS with "Corporate/SaaS" color palette (Deep Blues, Clean Grays).
- [x] **Layout:** Create main Layout component with responsive navigation and footer.
- [ ] **Hero Section:** Implement Hero component focusing on Client Pain Points (Text + CTA).
- [ ] **Trust Component:** Build reusable "Trust Bar" component (logos/stats support).

## Phase 2: The "Proof" Engine (Core Feature)

- [ ] **Database:** Create `case_studies` migration with `json` columns for `problem`, `solution`, `roi_metrics`.
- [ ] **Model:** Create `CaseStudy` model with strict typing and strict casts for JSON attributes.
- [ ] **Backend:** Implement `CaseStudyController` (Index/Show methods) and Resource classes.
- [ ] **Routing:** Define routes for Case Studies index and detail pages.
- [ ] **Frontend - Index:** Build `CaseStudies/Index.vue` with grid layout and summary cards.
- [ ] **Frontend - Detail:** Build `CaseStudies/Show.vue` utilizing the structured data (Problem/Solution/ROI).
- [ ] **Components:** Create `BeforeAfterSlider.vue` component for visual comparison ("The Wow Component").
- [ ] **Seeding:** Create a Seeder with dummy Case Study data for development.
