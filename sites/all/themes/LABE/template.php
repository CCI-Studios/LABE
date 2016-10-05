<?php

/**
 * Preprocess function for Date pager template.
 */
function LABE_preprocess_date_views_pager(&$vars) {
  ctools_add_css('date_views', 'date_views');

  $plugin = $vars['plugin'];
  $input = $vars['input'];
  $view = $plugin->view;

  $vars['nav_title'] = '';
  $vars['next_url'] = '';
  $vars['prev_url'] = '';

  if (empty($view->date_info) || empty($view->date_info->min_date)) {
    return;
  }
  $date_info = $view->date_info;
  // Make sure we have some sort of granularity.
  $granularity = !empty($date_info->granularity) ? $date_info->granularity : 'month';
  $pos = $date_info->date_arg_pos;
  if (!empty($input)) {
    $id = $plugin->options['date_id'];
    if (array_key_exists($id, $input) && !empty($input[$id])) {
      $view->args[$pos] = $input[$id];
    }
  }

  $next_args = $view->args;
  $prev_args = $view->args;
  $min_date = $date_info->min_date;
  $max_date = $date_info->max_date;

  // Set up the pager link format. Setting the block identifier
  // will force pager style links.
  if ((isset($date_info->date_pager_format) && $date_info->date_pager_format != 'clean') || !empty($date_info->mini)) {
    if (empty($date_info->block_identifier)) {
      $date_info->block_identifier = $date_info->pager_id;
    }
  }

  if (empty($date_info->hide_nav)) {
    $prev_date = clone($min_date);
    date_modify($prev_date, '-1 ' . $granularity);
    $next_date = clone($min_date);
    date_modify($next_date, '+1 ' . $granularity);
    $format = array('year' => 'Y', 'month' => 'Y-m', 'day' => 'Y-m-d');
    switch ($granularity) {
      case 'week':
        $next_week = date_week(date_format($next_date, 'Y-m-d'));
        $prev_week = date_week(date_format($prev_date, 'Y-m-d'));
        $next_arg = date_format($next_date, 'Y-\W') . date_pad($next_week);
        $prev_arg = date_format($prev_date, 'Y-\W') . date_pad($prev_week);
        break;
      default:
        $next_arg = date_format($next_date, $format[$granularity]);
        $prev_arg = date_format($prev_date, $format[$granularity]);
    }
    $next_path = str_replace($date_info->date_arg, $next_arg, $date_info->url);
    $prev_path = str_replace($date_info->date_arg, $prev_arg, $date_info->url);
    $next_args[$pos] = $next_arg;
    $prev_args[$pos] = $prev_arg;
    $vars['next_url'] = date_pager_url($view, NULL, $next_arg);
    $vars['prev_url'] = date_pager_url($view, NULL, $prev_arg);
    $vars['next_options'] = $vars['prev_options'] = array();
  }
  else {
    $next_path = '';
    $prev_path = '';
    $vars['next_url'] = '';
    $vars['prev_url'] = '';
    $vars['next_options'] = $vars['prev_options'] = array();
  }

  // Check whether navigation links would point to
  // a date outside the allowed range.
  if (!empty($next_date) && !empty($vars['next_url']) && date_format($next_date, 'Y') > $date_info->limit[1]) {
    $vars['next_url'] = '';
  }
  if (!empty($prev_date) && !empty($vars['prev_url']) && date_format($prev_date, 'Y') < $date_info->limit[0]) {
    $vars['prev_url'] = '';
  }
  $vars['prev_options'] += array('attributes' => array());
  $vars['next_options'] += array('attributes' => array());
  $prev_title = '';
  $next_title = '';

  // Build next/prev link titles.
  switch ($granularity) {
    case 'year':
      $prev_title = t('Navigate to previous year');
      $next_title = t('Navigate to next year');
      break;
    case 'month':
      $prev_title = t('Navigate to previous month');
      $next_title = t('Navigate to next month');
      break;
    case 'week':
      $prev_title = t('Navigate to previous week');
      $next_title = t('Navigate to next week');
      break;
    case 'day':
      $prev_title = t('Navigate to previous day');
      $next_title = t('Navigate to next day');
      break;
  }
  $vars['prev_options']['attributes'] += array('title' => $prev_title);
  $vars['next_options']['attributes'] += array('title' => $next_title);

  // Add nofollow for next/prev links.
  $vars['prev_options']['attributes'] += array('rel' => 'nofollow');
  $vars['next_options']['attributes'] += array('rel' => 'nofollow');

  // Need this so we can use '&laquo;' or images in the links.
  $vars['prev_options'] += array('html' => TRUE);
  $vars['next_options'] += array('html' => TRUE);

  $link = FALSE;
  // Month navigation titles are used as links in the block view.
  if (!empty($date_info->mini) && $granularity == 'month') {
    $link = TRUE;
  }
  $params = array(
    'granularity' => $granularity,
    'view' => $view,
    'link' => $link,
  );
  $nav_title = theme('date_nav_title', $params);
  $vars['nav_title'] = $nav_title;
  $vars['mini'] = !empty($date_info->mini);
  
  // Get the date information from the view.
  $date_info = $view->date_info;

  // Choose the dislpay format of the month name.
  $format = 'F';

  // Get the previous month.
  $dateString = $date_info->min_date;
  $prev_month = new DateTime($dateString);
  $prev_month->modify('-1 month');
  $prev_pager_title = format_date($prev_month->getTimestamp(), 'custom', $format);
  $vars['prev_title'] = $prev_pager_title;

  // Get the next month.
  $next_month = new DateTime($dateString);
  $next_month->modify('+1 month');
  $next_pager_title = format_date($next_month->getTimestamp(), 'custom', $format);
  $vars['next_title'] = $next_pager_title;
}

function LABE_form_alter(&$form, &$form_state, $form_id)
{
    if ($form_id == 'user_login_block')
    {
        unset($form['name']['#description']);
        $form['name']['#attributes']['required'] = 'TRUE';
        $form['name']['#attributes']['placeholder'] = t('Username / Email');
        $form['name']['#title'] = t('Username / Email');
        $form['name']['#weight'] = '1';
        unset($form['pass']['#description']);
        $form['pass']['#attributes']['required'] = 'TRUE';
        $form['pass']['#attributes']['placeholder'] = t('Password');
        $form['pass']['#weight'] = '2';
        $form['actions']['submit']['#value'] = t('Sign In');
        $form['actions']['#weight'] = '3';
        $form['lost_password']['#markup'] = '<div class="login-forgot"><a href="/user/password">Forgot Password?</a></div>';
        $form['lost_password']['#weight'] = '10';
        
        $form['heading'] = array(
            '#markup' => '<h2 class="sr-only">Sign in</h2>',
            '#weight' => '-10'
        );    
        $form['create'] = array(
            '#markup' => '<div class="sign-up"><a href="/signup">Sign Up</a></div><div class="clear"></div>',
            '#weight' => '4'
        );
    }
    else if ($form_id == 'user_register_form')
    {
        unset($form['account']['name']['#description']);
        $form['account']['name']['#attributes']['required'] = 'TRUE';
        unset($form['account']['mail']['#description']);
        $form['account']['mail']['#attributes']['required'] = 'TRUE';
        $form['account']['mail']['#title'] = t('Email');
        $form['profile_silver']['#weight'] = 25;
        $form['profile_gold']['#weight'] = 25;
        $form['regcode_simple']['#weight']=27;
      
        $form['account']['mail']['#weight'] = '0';
        $form['actions']['submit']['#value'] = t('Process Subscription');
        $form['actions']['submit']['#attributes'] = array('class' => array('btn btn-blue'));
      
        $form['heading2'] = array(
            '#markup' => '<h2>Membership Information</h2>',
            '#weight' => '-10'
        );

        $form['heading3'] = array(
            '#markup' => '<h2>Detailed Information</h2>',
            '#weight' => '3'
        );

        $form['heading4'] = array(
            '#markup' => '<h2>Contact Details</h2>',
            '#weight' => '12'
        );

        $form['heading5'] = array(
            '#markup' => '<h2>Payment Information</h2>',
            '#weight' => '24'
        );        
   

        $form['field_payment_method']['#weight'] = '28' ;
         

    }
    else if ($form_id=='views_exposed_form') 
    {
       unset($form['field_business_category_tid']['#title']);
       unset($form['items_per_page']['#title']);
       $form['items_per_page']['#options']['15'] = t('- Show 15 per page-'); 
       $form['items_per_page']['#options']['30'] = t('- Show 30 per page-'); 
       $form['items_per_page']['#options']['45'] = t('- Show 45 per page-'); 
       $form['field_business_category_tid']['#options']['All'] = t('- Choose Category -'); 
    }
 
}

?>