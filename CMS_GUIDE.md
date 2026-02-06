# Digital Foundry CMS Guide

Welcome to the **Control Room**. This secure interface allows you to manage your portfolio content effectively without writing code.

## Access
- **URL:** `/login`
- **Dashbaord:** `/dashboard` (Automatically redirects here after login)

## Managing Case Studies
Navigate to `/admin/case-studies` to view your portfolio items.

### 1. Creating a New Case Study
Click the **"New Case Study"** button. You will be taken to the editor.

### 2. The Editor Form
The form is designed for speed and structured data entry.

#### **Core Information**
- **Client / Title:** The display name (e.g., "Global Logistics Co.").
- **Industry:** appears below the title (e.g., "Supply Chain").
- **Challenge/Solution:** key narrative text areas.

#### **Tech Stack (Tags Input)**
Users often struggle with formatted lists. We made it simple:
- **Type** the name of a technology (e.g., "Laravel").
- **Press Enter** or Return. The text will convert into a purple tag.
- **To Remove:** Click the "X" on the tag or press Backspace in an empty input field.

#### **ROI Metrics (Dynamic Repeater)**
Showcase your results with quantitative data.
1. Click **"Add Metric"**.
2. **Label:** The category (e.g., "Fuel Saved").
3. **Value:** The impressive number (e.g., "15%").
4. Add as many as needed; they will appear in the "Key Results" section of the public page.

#### **Cover Image**
- Click the upload zone to select a file.
- **Max Size:** 2MB.
- **Preview:** The image will appear instantly in the box.

### 3. Publishing
- **Draft Mode:** By default, new studies are drafts (hidden from the public).
- **Go Live:** Toggle the **"Published"** switch in the top right corner.
- **Save:** Click **"Launch Study"** (or "Update Results" if editing).

## Security Note
This area is protected by authentication. There is no public registration link. Only users seeded into the database (like you) can access it.
