jQuery(document).ready(function ($) {
  // AI Logic removed per user request (Simplified UI)

  // Tab switching (redundant but safe if inlined script is removed)
  window.openTab = function (evt, tabName) {
    if (evt) evt.preventDefault();
    $(".von-tab-content").hide();
    $(".von-tab-link").removeClass("active");
    $("#" + tabName).show();
    $(evt.currentTarget).addClass("active");
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
  // --- ROBOTS.TXT RESET ---
  $("#von-reset-robots").on("click", function () {
    if (
      !confirm(
        vonseowp_admin_data.confirm_reset_robots || "Are you sure you want to reset robots.txt to recommended Pro rules?",
      )
    )
      return;

    const home_url =
      typeof vonseowp_admin_data !== "undefined"
        ? vonseowp_admin_data.home_url
        : window.location.origin;
    const proRules = [
      "User-agent: *",
      "Disallow: /wp-admin/",
      "Allow: /wp-admin/admin-ajax.php",
      "Disallow: /wp-login.php",
      "Disallow: /wp-register.php",
      "Disallow: /?s=",
      "Disallow: /search/",
      "Disallow: /feed/",
      "Disallow: /comments/feed/",
      "Disallow: /xmlrpc.php",
      "",
      "Sitemap: " + home_url + "/sitemap.xml",
    ].join("\n");

    $("#vonseowp_robots_txt").val(proRules);
  });

  // --- LLM RESET ---
  $("#von-reset-llm").on("click", function () {
    if (
      !confirm(
        vonseowp_admin_data.confirm_reset_llm || "Are you sure you want to reset llms.txt to the recommended AEO template?",
      )
    )
      return;

    const siteName = vonseowp_admin_data.site_name || "My Site";
    const siteDesc = vonseowp_admin_data.site_desc || "A website about something awesome.";
    const homeUrl = vonseowp_admin_data.home_url || window.location.origin;

    const llmTemplate = [
      "# " + siteName,
      "",
      "> " + siteDesc,
      "",
      "## " + vonseowp_admin_data.llm_template.key_resources,
      "",
      "- [" + vonseowp_admin_data.llm_template.home_page + "](" + homeUrl + "/): " + vonseowp_admin_data.llm_template.entry_point,
      "- [" + vonseowp_admin_data.llm_template.xml_sitemap + "](" + homeUrl + "/sitemap.xml): " + vonseowp_admin_data.llm_template.full_index,
      "",
      "## " + vonseowp_admin_data.llm_template.about,
      vonseowp_admin_data.llm_template.aeo_footer,
    ].join("\n");

    $("#vonseowp_llms_txt").val(llmTemplate);
  });
});
