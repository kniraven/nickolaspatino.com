# NickolasPatino.com CSS Files

Recommended load order:

```html
<link rel="stylesheet" href="/assets/css/structure.css">
<link rel="stylesheet" href="/assets/css/theme.css">
```

Optional page CSS should load after both:

```php
<?php if (!empty($pageCss)): ?>
  <link rel="stylesheet" href="/assets/css/pages/<?= htmlspecialchars($pageCss) ?>.css">
<?php endif; ?>
```

CSS philosophy:

- `structure.css` controls layout, sizing, spacing, normalization, grids, and component structure.
- `theme.css` controls colors, font families/styles, border colors/styles, shadows, and visual skin.
- `pages/*.css` should only contain page-specific rules.
