</main>

<?php
$linkedin = get_option('linkedin');
?>

<footer class="mainfooter">
    <div class="wrap cf">
        <div class="fl">
            <div class="address-col">
                <div class="ac-title"><?php _e('Office in','splashdev') ?> <span id="_addressLocality4" itemprop="addressLocality"><?php _e('Vienna','splashdev') ?></span></div>
                <address itemscope itemtype="http://schema.org/LocalBusiness">
<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" itemref="_addressLocality4">

<span itemprop="postalCode">1040</span>,
<span itemprop="streetAddress">Johann-Strauss-Gasse 3</span></span><br/>
                    <a class="foot-tel" href="tel:+436642301788">
                        <span itemprop="telephone">+43 664 2301788</span></a><br/>
                    <span itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
<span itemprop="dayOfWeek" itemscope itemtype="http://schema.org/DayOfWeek">

<span itemprop="name"><?php _e('Mo-Fr','splashdev') ?></span> </span></span>10:00 - 19:00 (UTC+1)
                </address>
                <a href="" class="map-link open_modal show_map" data-latitude="48.189522" data-longitude="16.366266" data-modalclass="modal_map"><span class="icon-location"></span><?php _e('Show on map','splashdev') ?></a>
            </div>
            <div class="address-col">
                <div class="ac-title"><?php _e('Office in','splashdev') ?>
                    <span id="_addressLocality12" itemprop="addressLocality"><?php _e('Bucharest','splashdev') ?></span></div>
                <address itemscope itemtype="http://schema.org/LocalBusiness">
<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" itemref="_addressLocality12">


<span itemprop="postalCode">020011</span>,
<span itemprop="streetAddress">C.A. Rosetti 17, Sector 2</span></span><br/>
                    <a href="tel:+40757022541" class="foot-tel">
                        <span itemprop="telephone">+40 757 022541</span></a><br/>
                    <span itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
<span itemprop="dayOfWeek" itemscope itemtype="http://schema.org/DayOfWeek">

<span itemprop="name"><?php _e('Mo-Fr','splashdev') ?></span> </span></span>10:00 - 19:00 (UTC+1)
                </address>
                <a href="" class="map-link open_modal show_map" data-modalclass="modal_map" data-latitude="44.441235" data-longitude="26.101086"><span class="icon-location"></span><?php _e('Show on map','splashdev') ?></a>
            </div>
        </div>
        <div class="fr">
            <div class="socials-list">
                <?php if(!empty($linkedin)) { ?>
                    <a href="<?php echo $linkedin; ?>" target="_blank" class="soc-item icon-linkedin"></a>
                <?php } ?>
            </div>
        </div>
    </div>
</footer>