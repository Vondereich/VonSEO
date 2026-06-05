const assert = require('assert');
const fs = require('fs');
const path = require('path');

const frontendPath = path.join(__dirname, '..', 'includes', 'class-vonseowp-frontend.php');
const source = fs.readFileSync(frontendPath, 'utf8');

assert.ok(
  !source.includes('Premium SEO'),
  'frontend meta output should not expose the old Premium SEO comment',
);

assert.ok(
  !source.includes('meta name="generator"'),
  'frontend meta output should not expose a generator/version tag',
);

assert.ok(
  source.includes('get_site_icon_url(512)'),
  'frontend meta output should fall back to the WordPress site icon for social image tags',
);

console.log('Frontend meta tests passed');
