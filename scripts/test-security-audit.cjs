const fs = require("fs");
const path = require("path");

const root = path.resolve(__dirname, "..");
const read = (file) => fs.readFileSync(path.join(root, file), "utf8");
const countLineEndings = (file) => {
  const source = fs.readFileSync(path.join(root, file));
  let lf = 0;
  let crlf = 0;
  let crOnly = 0;

  for (let i = 0; i < source.length; i += 1) {
    if (source[i] === 10) {
      lf += 1;
      if (i > 0 && source[i - 1] === 13) {
        crlf += 1;
      }
    } else if (source[i] === 13 && (i + 1 >= source.length || source[i + 1] !== 10)) {
      crOnly += 1;
    }
  }

  return { lf, crlf, crOnly };
};
const assert = (condition, message) => {
  if (!condition) {
    throw new Error(message);
  }
};

const devActivationPath = path.join(root, "test_activation.php");
assert(
  !fs.existsSync(devActivationPath),
  "test_activation.php must not live in the plugin root; keep activation harnesses outside release/source surface.",
);

const competitors = read("includes/class-vonseowp-competitors.php");
assert(
  /wp_safe_remote_get\s*\(/.test(competitors),
  "Competitor scanner must use wp_safe_remote_get().",
);
assert(
  /limit_response_size/.test(competitors),
  "Competitor scanner must cap remote response size.",
);
assert(
  /wp_remote_retrieve_header\s*\(\s*\$response\s*,\s*['"]content-type['"]\s*\)/.test(competitors),
  "Competitor scanner must inspect remote content-type before parsing HTML.",
);
assert(
  /text\\\/html|text\/html|application\\\/xhtml\\\+xml|application\/xhtml\+xml/.test(competitors),
  "Competitor scanner must only parse HTML-like response content.",
);

const columns = read("includes/class-vonseowp-columns.php");
assert(
  !/\bstrip_tags\s*\(/.test(columns),
  "All Posts score normalization must use wp_strip_all_tags(), not native strip_tags().",
);
assert(
  /wp_strip_all_tags\s*\(/.test(columns),
  "All Posts score normalization must use the WordPress text stripping helper.",
);

const columnsLineEndings = countLineEndings("includes/class-vonseowp-columns.php");
assert(
  columnsLineEndings.crlf === 0 && columnsLineEndings.crOnly === 0,
  "All Posts columns file must use LF-only line endings.",
);

const siteAudit = read("includes/class-vonseowp-site-audit.php");
assert(
  /current_user_can\s*\(\s*['"]manage_options['"]\s*\)/.test(siteAudit),
  "Site audit actions must require manage_options.",
);
assert(
  /check_admin_referer\s*\(\s*['"]vonseowp_run_site_audit['"]\s*\)/.test(siteAudit),
  "Site audit actions must verify their nonce.",
);
assert(
  /private const MAX_POSTS\s*=\s*25/.test(siteAudit),
  "Site audit must retain its bounded 25-post scan limit.",
);
assert(
  /absint\s*\(\s*wp_unslash\s*\(\s*\$_POST\[['"]vonseowp_audit_page['"]\]/.test(siteAudit),
  "Site audit batch input must be unslashed and converted to a non-negative integer.",
);
assert(
  /'paged'\s*=>\s*\$page/.test(siteAudit) && /min\s*\(\s*\$page\s*,\s*\$pages\s*\)/.test(siteAudit),
  "Site audit must use a clamped WordPress query page for bounded batch navigation.",
);
assert(
  !/wp_(safe_)?remote_(get|post|request)\s*\(/.test(siteAudit),
  "Site audit must remain local-only and avoid remote requests.",
);

const uninstall = read("uninstall.php");
assert(
  /delete_transient\s*\(\s*['"]vonseowp_site_audit_results['"]\s*\)/.test(uninstall),
  "Uninstall must remove cached site audit results.",
);

console.log("Security audit regression tests passed");
