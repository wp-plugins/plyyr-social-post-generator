<div style="background-color: White; border=5px;" id="plyyr-admin">

<h1 style=""><?php _e('Plyyr Plugin', 'plyyr'); ?></h1>

<h2>Enter your Plyyr Wordpress plugin code and quickly add a social news channel to your wordpress site.<h2>
<h4>The Plyyr plugin uniquely creates your own social channel and posts for you so you do not have to! It's perfect for bloggers and publishers.<h4>
<p>
<h4>Start off by registering and getting your code from plyyr.com. You can get it from <a href="http://plyyr.com/publishers" target="_blank">http://plyyr.com/publishers</a></h4>
<h5>Sites with 1000+ monthly views qualify to start making money from our affiliate program. <a href="mailto:mail@gamecloudnetwork.com">Learn More</a></h5>
<div class="plyyr_pubvalue">
    <div class="wrap">
        <form method="post" action="options.php"> 
            <?php @settings_fields('plyyr-group'); ?>
            <?php @do_settings_fields('plyyr-group'); ?>

            <?php do_settings_sections('plyyr'); ?>

            <?php @submit_button(); ?>
        </form>
    </div>
</div>
</div>
<div class="wrap" id="plyyr-admin">
    <h1><?php _e('Plyyr Plugin Settings Guide', 'plyyr'); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="options-general.php?page=<?php echo $this->get_option_name(); ?>&tab=start"      class="nav-tab <?php echo $active_tab == 'start' ? 'nav-tab-active' : ''; ?>"><?php _e('Getting Started', 'plyyr'); ?></a>
        <a href="options-general.php?page=<?php echo $this->get_option_name(); ?>&tab=embed"      class="nav-tab <?php echo $active_tab == 'embed' ? 'nav-tab-active' : ''; ?>"><?php _e('Site Settings', 'plyyr'); ?></a>
        <a href="options-general.php?page=<?php echo $this->get_option_name(); ?>&tab=shortcodes" class="nav-tab <?php echo $active_tab == 'shortcodes' ? 'nav-tab-active' : ''; ?>"><?php _e('Shortcodes', 'plyyr'); ?></a>
        <a href="options-general.php?page=<?php echo $this->get_option_name(); ?>&tab=feedback"   class="nav-tab <?php echo $active_tab == 'feedback' ? 'nav-tab-active' : ''; ?>"><?php _e('Feedback', 'plyyr'); ?></a>
    </h2>
    <?php if ($active_tab == 'start') { ?>
      <div class="plyyr_start">

              <img src="<?php echo plugins_url('img/admin-register.jpg', __FILE__); ?>" class="location_img">

          <h3><?php _e('Registering', 'plyyr'); ?></h3>

          <ol class="circles-list">
              <li>
                  <p><?php _e('Go to http://plyyr.com and click on the <b>"Publishers"</b> tab', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Enter a name for your site. (This is the tracking code.)', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Enter your blog URL.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Enter tags to filter the type of quizzes you want to add to your site.<i> Entertainment, Moms, Fun, Sports, News, etc.</i>', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Submit', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Copy the "Portal Code" provided at Plyyr.com into the Field above and save.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('You are ready to go. Embed a Short Code on a page.', 'plyyr'); ?></p>
              </li>
          </ol>

      </div>
      <div class="plyyr_start">

           <img src="<?php echo plugins_url('img/admin-embed-customization.jpg', __FILE__); ?>" class="location_img">

          <h3><?php _e('Creating a Plyyr Page On Your Site', 'plyyr'); ?></h3>

          <ol class="circles-list">
              <li>
                  <p><?php _e('A Plyyr page will filter in all the latest content based on the tags you set in the PUBLISHERS section on Plyyr.com', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('When users click on an item Plyrr creates a new post for the item on your site.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Create a page or post on your site.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Paste [plyyr portal="YOUR PLYYR CODE HERE" style="height: 840px; float: left"]', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Adjust the HEIGHT attribute for your site. Default settings will work fine.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Publish and you are done!  Make sure you share your site!', 'plyyr'); ?></p>
              </li>
          </ol>

      </div>
      <div class="plyyr_start">

              <img src="<?php echo plugins_url('img/admin-embed-itempost.jpg', __FILE__); ?>" class="location_img">

          <h3><?php _e('Embed Items from Plyyr', 'plyyr'); ?></h3>

          <ol class="circles-list">
              <li>
                  <p><?php _e('You can embed and individual item from Plyyr.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Click on the EMBED button on any page and copy the SHORT CODE.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Create a new post / page on your site.', 'plyyr'); ?></p>
              </li>
              <li>
                  <p><?php _e('Paste in the SHORT CODE from the Plyyr site.', 'plyyr'); ?></p>
              </li>
              <p><?php _e('Publish and you are done! Make sure you share your post!', 'plyyr'); ?></p>
              </li>
          </ol>

      </div>


      <div class="plyyr_start">

          <h3><?php _e('Default Site Settings', 'plyyr'); ?></h3>

          <ol class="circles-list">
              <li>
                  <p><?php _e('Manage your settings <a target="_blank" href="http://plyyr.com/publishers">here</a>'); ?></p>
              </li>
              <li>
                  <p><?php _e('Optionally set your Publishing group.', 'plyyr'); ?></p>
              </li>
                <li>
                  <p><?php _e('Choose whether to add Comments.', 'plyyr'); ?></p>
              </li>
                <li>
                 <p><?php _e('Choose whether to show Related Content.', 'plyyr'); ?></p>
               </li>
               <li>
                <p><?php _e('Choose whether to show Share Buttons.', 'plyyr'); ?></p>
                 </li>
          </ol>

      </div>

    <?php } elseif ($active_tab == 'embed') { ?>

       <div class="plyyr_embed">

                <h3><?php _e('Plyyr Settings', 'plyyr'); ?></h3>
                <h3>All settings can be modified on the Plyyr site @ <a href="http://plyyr.com/publishers" target="_blank">http://plyyr.com/publishers</a></h3>
                <p><?php printf(__('Choose any Playful Content item from %s and easily embed it in a post.', 'plyyr'), '<a href="https://www.plyyr.com/" target="_blank">plyyr.com</a>'); ?></p>

                <dl>
                    <dt>Name</dt>
                    <dd>
                        <p><?php _e('This is the unique identifier for your site.', 'plyyr'); ?></p>
                        <p><?php _e('Type: Name', 'plyyr'); ?></p>
                    </dd>
                    <dt>Parent Website</dt>
                    <dd>
                         <p><?php _e('This is the URL for your website. http://yourwebsite.com', 'plyyr'); ?></p>
                         <p><?php _e('Type: URL', 'plyyr'); ?></p>
                    </dd>
                    <dt>Tags</dt>
                        <dd>
                         <p><?php _e('Select the categories of content you want automatically filtered into the Plyyr widget embedded on your site. Examples:<i> News, Entertainment, Sports, Movies, Fun.</i>', 'plyyr'); ?></p>
                         <p><?php _e('Type: Comma Separated Text', 'plyyr'); ?></p>
                    </dd>

                    <dt>Display Share <br>Button</dt>
                        <dd>
                         <p><?php _e('Checking this box will add a share button below Plyyr quizzes and polls.', 'plyyr'); ?></p>
                         <p><?php _e('Type: Check Box', 'plyyr'); ?></p>
                    </dd>
                     <dt>Display Facebook <br>Comments</dt>
                        <dd>
                         <p><?php _e('Checking this box will add facebook Comments below Plyyr quizzes and polls.', 'plyyr'); ?></p>
                         <p><?php _e('Type: Check Box', 'plyyr'); ?></p>
                    </dd>
                     <dt>Choose Color <br>Scheme</dt>
                        <dd>
                         <p><?php _e('Select the color palette of your PLyyr widget.', 'plyyr'); ?></p>
                         <p><?php _e('Type: Drop Down', 'plyyr'); ?></p>
                    </dd>
                     <dt>Display More <br>Recommendations</dt>
                        <dd>
                         <p><?php _e('Checking this box will add facebook Comments below Plyyr quizzes and polls.', 'plyyr'); ?></p>
                         <p><?php _e('Type: Check Box', 'plyyr'); ?></p>
                    </dd>
                </dl>



       </div>

    <?php } elseif ($active_tab == 'shortcodes') { ?>

 <div class="plyyr_shortcodes">

          <img src="<?php echo plugins_url('img/admin-embedsection.jpg', __FILE__); ?>" class="location_img">
          <h3><?php _e('Section Shortcode', 'plyyr'); ?></h3>

          <p><?php _e('Use the following shortcode if you want to adjust the settings of your embedded section:', 'plyyr'); ?></p>
          <p><code>[plyyr portal="YOUR PORTAL CODE" style="height=840"]</code></p>
          <p><?php _e('You can tweak the general settings for the section with the following shortcode attributes:', 'plyyr'); ?></p>
          <dl>
           <dt>Portal</dt>
                        <dd>
                            <p><?php _e('Input the tracking string your receiev after registering on the Plyyr site.', 'plyyr'); ?></p>
                            <p><?php _e('Type: String ; Default: All', 'plyyr'); ?></p>
                        </dd>
              <dt>Height</dt>
              <dd>
                  <p><?php _e('Sets the height of the section embed.', 'plyyr'); ?></p>
                  <p><?php _e('Type: String ; Default: All', 'plyyr'); ?></p>
              </dd>
              <dt>Float (optional)</dt>
              <dd>
                  <p><?php _e('Option to float left or right.[plyyr portal="YOUR PORTAL CODE" style="height=840; float=left"] ', 'plyyr'); ?></p>
                  <p><?php _e('Type: String ; Default: true', 'plyyr'); ?></p>
              </dd>

          </dl>

      </div>
      <div class="plyyr_shortcodes">
            <img src="<?php echo plugins_url('img/admin-shortcode.jpg', __FILE__); ?>" class="location_img">
          <h3><?php _e('Item Shortcode', 'plyyr'); ?></h3>
          <p><?php printf(__('Choose any Content item from %s and easily embed it in a post.', 'plyyr'), '<a href="https://www.plyyr.com/" target="_blank">plyyr.com</a>'); ?></p>
          <p><?php _e('For basic use, paste the item URL into your text editor and go to the visual editor on plyyr.com to make sure it loads.', 'plyyr'); ?></p>
          <p><?php _e('For more advance usage, use the following shortcode if you want to adjust the item appearance:', 'plyyr'); ?></p>
          <p><code>[gcn quiz="trivia_quiz_551532e951d96"]</code></p>

          <p><?php _e('Or you can override the default appearance and customize each item with the following shortcode attributes:', 'plyyr'); ?></p>
          <dl>
              <dt>quiz</dt>
              <dd>
                  <p><?php _e('The URL of the item that will be displayed.', 'plyyr'); ?></p>
                  <p><?php _e('Type: URL', 'plyyr'); ?></p>
              </dd>

          </dl>

      </div>



    <?php } elseif ($active_tab == 'feedback') { ?>

      <div class="plyyr_feedback">

          <h3><?php _e('We Are Listening', 'plyyr'); ?></h3>

          <p><?php _e('We’d love to know about your experiences with our WordPress plugin and beyond. Drop us a line using the form below', 'plyyr'); ?></p>
          <p><br><p>

              <?php if ($feedback == 'true') { ?>

            <p><?php
                $to = 'support@plyyr.com';
                $subject = 'WordPress plugin feedback from ' . home_url();
                $message = $_POST['description'];
                $headers[] = 'From: ' . $_POST['name'] . ' <' . $_POST['email'] . '>' . "\r\n";
                $mail_result = wp_mail($to, $subject, $message, $headers);
                if ($mail_result) {
                  _e('Feedback Sent.', 'plyyr');
                } else {
                  _e('Error sending feedback.', 'plyyr');
                }
                ?></p>

          <?php } elseif ($active_tab == 'feedback') { ?>
            <form action="options-general.php?page=plyyr&tab=feedback&mail=true" method="post">
                <p>
                    <label for="name"><?php _e('Your Name', 'plyyr'); ?></label>
                    <input type="text" name="name" class="regular-text">
                </p>
                <p>
                    <label for="email"><?php _e('Email (so we can write you back)', 'plyyr'); ?></label>
                    <input type="text" name="email" class="regular-text" value="<?php echo get_bloginfo('admin_email'); ?>">
                </p>
                <p>
                    <label for="description"><?php _e('Description', 'plyyr'); ?></label>
                    <textarea name="description" rows="5" class="widefat" placeholder="<?php _e('What\'s on your mind?', 'plyyr'); ?>"></textarea>
                </p>
                <?php submit_button(__('Submit', 'plyyr')); ?>
            </form>
          <?php } ?>

      </div>

      <div class="plyyr_feedback">

          <h3><?php _e('Join the Plyyr Publishers Community', 'plyyr'); ?></h3>
          <p>
              <a href="https://www.facebook.com/plyyr" target="_blank" class="plyyr_facebook"></a>
              <a href="https://twitter.com/_plyyr" target="_blank" class="plyyr_twitter"></a>
              <a href="https://plus.google.com/communities/106211615605863996379" target="_blank" class="plyyr_googleplus"></a>

          </p>

      </div>

      <div class="plyyr_feedback">

          <h3><?php _e('Enjoying the plyyr WordPress Plugin?', 'plyyr'); ?></h3>
          <p><?php printf(__('<a href="%s" target="_blank">Rate us</a> on the Wordpress Plugin Directory to help others to discover the engagement value of plyyr embeds!', 'plyyr'), 'https://wordpress.org/support/view/plugin-reviews/plyyr#postform'); ?></p>

      </div>

      <div class="plyyr_feedback">

          <h3><?php _e('Become a Premium Plyyr Publisher', 'plyyr'); ?></h3>
          <p><?php _e('Want to learn how Plyyr can start earning you revenue?', 'plyyr'); ?></p>
          <p><a href="mailto:mail@gamecloudnetwork.com?subject=I want to join the Plyyr Affiliate Network" target="_blank"><?php _e('Lets Talk!', 'plyyr'); ?></a></p>

      </div>
    <?php } ?>
</div>
