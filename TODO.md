# TODO: Image Gallery Upload and Slideshow Improvements

## Completed Tasks

### 1. Updated Image Gallery Upload (Multiple to Individual Inputs)
- **Files Modified:**
  - `views/dashboard/newcampaign.php`: Changed gallery upload from single multiple-file input to 6 individual file inputs.
  - `views/dashboard/editcampaign.php`: Same changes as newcampaign.php.
  - `public/js/dashboard/newcampaign.js`: Updated JavaScript to handle 6 individual inputs with preview.
  - `public/js/dashboard/editcampaign.js`: Added loop for handling 6 inputs in edit mode.
  - `public/css/dashboard/newcampaign.css`: Added styles for `.galery-inputs` and `.galery-item`.

### 2. Added Automatic Slideshow in Campaign View
- **Files Modified:**
  - `public/js/pages/single.js`: Added automatic slideshow that changes images every 10 seconds. Stops on manual navigation and restarts.

### 3. Fixed Gallery Image Display in Edit Mode
- **Files Modified:**
  - `views/dashboard/editcampaign.php`: Added inline script to load existing gallery images into the preview divs.
  - `public/js/dashboard/editcampaign.js`: Removed duplicate code, now handled by inline script.

## Summary
- Gallery upload now allows selecting up to 6 images individually, improving user experience.
- Campaign single page now has an automatic slideshow alternating between main image and gallery images every 10 seconds.
- Edit campaign page now displays existing gallery images for editing.
