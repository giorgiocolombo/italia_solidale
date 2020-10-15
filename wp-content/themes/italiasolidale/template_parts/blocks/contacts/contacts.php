<div class="contacts_info">

    <?php if( get_field('telefono') || get_field('fax') ): ?>
        <div class="contacts_item contacts_phone">
            <img src="<?php echo ITAS_INCLUDES.'/img/phone.svg' ?>" alt="">
            <div class="white_contacts">
                <p class="contacs_info_section_name">Telefono</p>
                <div class="links">
                    <?php if( get_field('telefono') ): ?>
                        <p>Telefono: <a href="tel:<?php echo the_field('telefono') ?>"><?php echo the_field('telefono') ?></a></p>
                    <?php endif; ?>
                    <?php if( get_field('fax') ): ?>
                        <p>Fax: <a><?php echo the_field('fax') ?></a></p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if( get_field('email') || get_field('pec') ): ?>
        <div class="contacts_item contacts_email">
            <img src="<?php echo ITAS_INCLUDES.'/img/mail.svg' ?>" alt="">
            <div class="white_contacts">
                <p class="contacs_info_section_name">E-mail</p>
                <div class="links">
                    <?php if( get_field('email') ): ?>
                        <p>E-mail: <a href="mailto:<?php echo the_field('email') ?>"><?php echo the_field('email') ?></a></p>
                    <?php endif; ?>
                    <?php if( get_field('pec') ): ?>
                        <p>Pec: <a href="mailto:<?php echo the_field('pec') ?>"><?php echo the_field('pec') ?></a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>
