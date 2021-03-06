<div id="bot-container" class="group">
    <div id="about-us" class="group">
        <div id='about-us-main-title-container'>
            <?php /* <span id="about-us-close-button"><img src="http://cdn4.iconfinder.com/data/icons/iconic/raster/32/x.png" style="width: 10px;" /></span> */ ?>
            <div id='about-us-main-title'><?php __(strtoupper(l('about_us'))) ?></div>
        </div>
        <div style='padding: 30px 22px 40px 16px;'>
            <div><?php echo $about_us['main']['text']; ?></div>
            <div class="about-us-inner-box" style="margin-left: 0px;">
                <div class="about-us-main-title-container about-us-inner-button">
                    <div class='about-us-title'><?php __(strtoupper(l('about_us_open_information'))) ?></div>
                </div>
                <div class="inner-text-box"><?php echo $about_us['open_information']['text']; ?></div>
            </div>
            <div class="about-us-inner-box">
                <div class="about-us-main-title-container about-us-inner-button">
                    <div class='about-us-title'><?php __(strtoupper(l('about_us_participation'))) ?></div>
                </div>
                <div class="inner-text-box"><?php echo $about_us['participation']['text']; ?></div>
            </div>
            <div class="about-us-inner-box">
                <div class="about-us-main-title-container about-us-inner-button">
                    <div class='about-us-title'><?php __(strtoupper(l('about_us_innovation'))) ?></div>
                </div>
                <div class="inner-text-box"><?php echo $about_us['innovation']['text']; ?></div>
            </div>
        </div>
    </div>
    <div id="contact-us" class="group">
        <div class="about-us-main-title-container" id="contact-us-main-title-container" style="border: 0px; position: relative;">
            <?php /* <span id="contact-us-close-button">×</span> */ ?>
            <div class='about-us-title' style='display: inline-block'><?php echo strtoupper(l('contact_us')) ?></div>
        </div>
        <!--<iframe src="http://mapspot.ge/embed/embedmap.php?lt=41.697067732318&lg=44.790275215241&z=16&m=1&mlg=44.796767813687&mlt=41.697999849411" width="930" height="318" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>-->
        <div id='contact-us-form-container' class='group'>
            <div id='contact-us-circle'>
                <?php $margin = (LANG == 'ka') ? 20 : 7; ?>
                <div style='margin-top: 40px'><?php __(strtoupper(l('contact_us_inner_contact'))) ?></div>
                <div style='margin-top: <?php echo $margin ?>px'><?php __(l('contact_us_address')) ?></div>
                <div style='margin-top: <?php echo $margin ?>px'>
                    <span style=''><?php __(l('contact_us_mail')) ?>:</span>
                    <a href="mailto:info@opentaps.ge"><span style='color: #a11d21'>info@opentaps.ge</span></a>
                </div>
                <div style='margin-top: <?php echo $margin ?>px;'><?php __(l('contact_us_tel')) ?>: +995 32 214 29 26</div>
                <?php if (LANG != 'ka'): ?><div style='color: #000; margin-top: 27px;'><?php __(l('contact_us_text')) ?></div><?php endif; ?>
            </div>
            <?php /* <div id='contact-us-form'>
              <form action='' method=''>
              <input type='text' name='' value='name:' class='contact-us-input' onfocus='contact_us_input_focus(this, "name:")' onblur='contact_us_input_blur(this, "name:")' />
              <input type='text' name='' value='e-mail:*' class='contact-us-input' onfocus='contact_us_input_focus(this, "e-mail:*")' onblur='contact_us_input_blur(this, "e-mail:*")' />
              <textarea id='contact-us-textarea' class='mceNoEditor' onfocus='contact_us_input_focus(this, "message:*")' onblur='contact_us_input_blur(this, "message:*")'>message:*</textarea>
              </form>
              </div> */ ?>
        </div>
    </div>
</div>

<div class='bottom group'>
    <div class='bottom1'>
        &copy; <?php echo date('Y') > 2011 ? '2011-' . date('Y') : 2011 ?> OPEN TAPS. &nbsp;
        <?php
        echo l('copyright_jumpstart', array(
            ':link' => '<a target = "_blank" href="http://www.jumpstart.ge/" title="JumpStart Georgia" style="text-decoration: underline">',
            ':endlink' => '</a>'
        ))
        ?>
    </div>
    <div class="bottom2">
    	<?php if ( Storage::instance()->show_export ): ?>
    		<!-- href="http://www.web2pdfconvert.com/convert"-->
	        <span id="admin_button_logout"><a id="the-export"> <?php echo l('the_export') ?></a></span>&nbsp;&nbsp;|&nbsp;
        <?php endif; ?>
        <?php if (userloggedin()): ?>
            <span id="admin_button_logout" style="cursor: pointer" onclick="window.location = '<?php echo href() ?>logout';">LOG OUT</span>&nbsp;&nbsp;|&nbsp;
            <span id="admin_button" style="cursor: pointer" onclick="window.location = '<?php echo href() ?>admin';">ADMINISTRATION</span>&nbsp;&nbsp;|&nbsp;
        <?php endif; ?>
        <span id="about_us_button"><?php echo strtoupper(l('about_us')) ?></span> &nbsp;&nbsp;|&nbsp;&nbsp;
        <span id="contact_us_button"><?php echo strtoupper(l('contact_us')) ?><span style='cursor: pointer'></span><img width='10px' src='<?php echo href() ?>images/contact-line.gif' id='contact_us_toggle' /></span>
    </div>
</div>
