# SEO Audit Report for Iewa Website

## ✅ Current SEO Implementation (Good)

1. **Basic Meta Tags**: Present in `app.blade.php`
   - Title tag (using Inertia)
   - Meta description
   - Canonical URLs
   - Open Graph tags (basic)
   - Twitter Card tags (basic)

2. **Sitemap**: Basic sitemap.xml exists at `/sitemap.xml`

3. **Robots.txt**: Present at `/robots.txt` (allows all)

4. **Landing Pages**: Some landing pages have SEO (iewa, iewato, ایوا, ایواتو)

5. **HTML Language**: Set to `lang="fa" dir="rtl"`

6. **Some Alt Text**: Images in components have some alt attributes

## ❌ Critical SEO Issues

### 1. Missing Page-Specific Meta Tags
- **Home Page**: No specific title/description
- **Menu Page**: No SEO meta tags
- **About Us Page**: No SEO meta tags
- **Contact Page**: No SEO meta tags

### 2. Missing Open Graph Images
- No `og:image` meta tags
- No Twitter card images

### 3. Missing Schema Markup
- No structured data (JSON-LD)
- No Organization schema
- No LocalBusiness schema
- No Product schema for meals
- No BreadcrumbList schema

### 4. Incomplete Meta Tags
- Missing `og:locale`
- Missing `og:image:width` and `og:image:height`
- Missing `article:author` (if needed)
- No keywords meta tag (optional but useful)

### 5. Image SEO Issues
- Some images missing descriptive alt text
- Navbar logo alt text is too generic ("اوا")
- Some meal images use generic alt text

### 6. Sitemap Limitations
- No `lastmod` dates
- No `changefreq` priorities
- No `priority` values
- Static URLs only (no dynamic meal pages)

### 7. Missing Technical SEO
- No viewport meta tag explicitly set (may be in CSS)
- No author meta tag
- Missing favicon links in head
- No DNS prefetch/preconnect for external resources

### 8. Content Structure
- Missing breadcrumbs navigation
- No semantic HTML5 elements in some pages
- Could use more descriptive headings hierarchy

### 9. URL Structure
- URLs are clean and readable ✅
- But no slug-based URLs for meals (e.g., `/meals/salad-healthy`)

### 10. Performance & Mobile
- Lazy loading present on some images ✅
- But could be improved

## 📋 Recommended Improvements

### Priority 1 (Critical)
1. Add page-specific meta tags to all pages
2. Add Open Graph images
3. Implement Schema markup (Organization, LocalBusiness)
4. Improve image alt texts

### Priority 2 (Important)
5. Enhance sitemap with dates and priorities
6. Add breadcrumbs
7. Implement Product schema for meals
8. Add structured data for navigation

### Priority 3 (Nice to Have)
9. Create dynamic sitemap with meal URLs
10. Add article schema for blog (if applicable)
11. Implement FAQ schema (if applicable)
12. Add reviews/ratings schema (if applicable)

