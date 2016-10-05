<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>

  <div class="container">
  <?php print $messages; ?>
  </div>
  <div id="page-wrapper"><div><div>
    <div class="clear"></div>
    <div role="banner" id="header"><div class="blue-right"></div><!-- decoration div --><div class="container"><div>
      <?php print render($page['header']); ?>
      <div class="btn-menu">
        <a role="presentation" href="#"><span class="sr-only">Open menu</span></a>
      </div>
      <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
        </a>
      <?php endif; ?>
      <div class="clear"></div>
    </div></div></div> <!-- /#header -->
    <div id="navigation"><div class="container"><div>
      <nav role="navigation" aria-label="Primary">
        <?php print render($page['navigation']); ?>
        <div class="clear"></div>
      </nav>
    </div></div></div>
    <div class="clear"></div>

    <div role="complementary" id="masthead"><div><div>
      <?php print render($page['masthead']); ?>
    </div></div></div> <!-- /#masthead -->
    <div class="clear"></div>
    <div id="main-wrapper"><div><div>

      <div role="main" id="content"><div class="container"><div>
        <a id="main-content"></a>
        <?php print render($title_prefix); ?>
        <?php if ($title): ?>
          <div id="page-title">
            <?php print '<h1'. ($tabs ? ' class="title"' : '') .'>'. $title .'</h1>'; ?> 
          </div>
        <?php endif; ?>
        <?php if(arg(0)=='user' && $user->uid != 0 )
        {
          print l(t('edit profile'), "user/{$GLOBALS['user']->uid}/edit");
        } ?>
        <?php print render($title_suffix); ?>
        <?php if ($tabs): ?><div class="tabs"><?php //print render($tabs); ?></div><?php endif; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
        <div class="clear"></div>
      </div></div></div> <!-- /#content -->
      <?php if ($page['sidebar']): ?>
        <div id="sidebar"><div><div>
          <?php print render($page['sidebar']); ?>
        </div></div></div> <!-- /#sidebar -->
      <?php endif; ?>
      <div class="clear"></div>

    </div></div></div> <!-- /#main, /#main-wrapper -->
    <div class="clear"></div>
    <div role="complementary" aria-label="Widgets" id="widgets"><div>
      <div id="widgets-left">
        <?php print render($page['widgets-left']); ?>
      </div>
      <div id="widgets-right">
        <?php print render($page['widgets-right']); ?>
      </div>
    </div></div> <!-- #widgets -->
    <div class="clear"></div>
    <div role="contentinfo" aria-label="Footer" id="footer"><div class="container"><div>
      <div id="footerinfo">
          <span>&copy; LABE <?php print date('Y'); ?></span>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<span>Site by <a href="http://ccistudios.com" target="_blank">CCI Studios</a></span>
      </div>
      <?php print render($page['footer']); ?>
      <div class="clear"></div>
    <div class="blue-right"></div><!-- decoration div -->
    </div></div></div> <!-- /#footer -->


  </div></div></div> <!-- /#page-wrapper -->