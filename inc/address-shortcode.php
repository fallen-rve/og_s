<?php
/**
 * Gets address in Google accepted format
 *
 * @package og_s
 */

function og_s_address( $atts ) {
    $a = shortcode_atts( array(
        'default' => 'test'
    ), $atts );

    $address = og_s_get_company_info();

    ob_start(); ?>
    <p itemscope itemtype="http://schema.org/LocalBusiness">
        <?php if( $address['company_name'] ): ?><span itemprop="name"><?php echo $address['company_name']; ?></span><br/><?php endif; ?>
        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <?php if( $address['address_line_1'] ): ?><span itemprop="streetAddress"><?php echo $address['address_line_1'] . ', ' . $address['address_line_2']; ?></span>,<?php endif; ?> 
            <?php if( $address['city'] ): ?><span itemprop="addressLocality"><?php echo $address['city']; ?></span>, <?php endif; ?>
            <?php if( $address['state'] ): ?><span itemprop="addressRegion"><?php echo $address['state']; ?></span> <?php endif; ?>
            <?php if( $address['zip'] ): ?><span itemprop="postalCode"><?php echo $address['zip']; ?></span><?php endif; ?>
        </span><br/>
        <?php if( $address['email'] ): _e('Email: ', 'og_s'); ?><span itemprop="email"><?php echo antispambot( $address['email'] ); ?></span><br/><?php endif; ?>
        <?php if( $address['phone_number'] ): _e('Phone: ', 'og_s'); ?><span itemprop="telephone"><?php echo $address['phone_number']; ?></span><br/><?php endif; ?>
        <?php if( $address['fax'] ): _e( 'Fax: ', 'og_s' ); echo $address['fax']; ?><br/><?php endif; ?>
    </p>
    <?php return ob_get_clean();
}
add_shortcode( 'company_address', 'og_s_address' );