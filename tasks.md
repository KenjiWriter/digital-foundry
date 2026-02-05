# Technical Tasks

## Phase 1: The "Value-First" Foundation

- [x] **Project Setup:** Initialize Laravel 12 project with Inertia + Vue 3 stack.
- [ ] **Styling Configuration:** Configure Tailwind CSS with "Corporate/SaaS" color palette (Deep Blues, Clean Grays).
- [x] **Layout:** Create main Layout component with responsive navigation and footer.
- [x] **Hero Section:** Implement Hero component focusing on Client Pain Points (Text + CTA).
- [x] **Trust Component:** Build reusable "Trust Bar" component (logos/stats support).

## Phase 2: The "Proof" Engine (Core Feature)

- [x] **Database:** Create `case_studies` migration with `json` columns for `problem`, `solution`, `roi_metrics`.
- [x] **Model:** Create `CaseStudy` model with strict typing and strict casts for JSON attributes.
- [x] **Backend:** Implement `CaseStudyController` (Index/Show methods) and Resource classes.
- [x] **Routing:** Define routes for Case Studies index and detail pages.
- [x] **Frontend - Index:** Build `CaseStudies/Index.vue` with grid layout and summary cards.
- [x] **Frontend - Detail:** Build `CaseStudies/Show.vue` utilizing the structured data (Problem/Solution/ROI).
- [ ] **Components:** Create `BeforeAfterSlider.vue` component for visual comparison ("The Wow Component").
- [x] **Seeding:** Create a Seeder with dummy Case Study data for development.

## Phase 3: The Conversion Layer

- [x] **ROI Tools:** Develop **ROI Calculator** Vue component (Input: Team size/hours -> Output: Savings).
- [x] **Lead Capture:** Implement "Book a Strategy Call" form (integrated with a simple mail notification).
- [x] **Services:** Defined as "Productized Services" (e.g., "MVP in 4 weeks"), not just a list of languages.

## Phase 4: The Control Room (CMS)

- [ ] **Auth:** Install Laravel Breeze (Vue/Inertia) for secure Admin Login.
- [ ] **Admin Layout:** Create `AdminLayout.vue` with corporate dark theme.
- [ ] **Dashboard:** Build a simple dashboard showing recent Leads.
- [ ] **Case Study Manager:** CRUD interface to manage Case Studies without code.
