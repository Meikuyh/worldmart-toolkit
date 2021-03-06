<?php
if (!class_exists('Worldmart_Toolkit_Shortcode_Title')){
    class Worldmart_Toolkit_Shortcode_Title extends  Worldmart_Toolkit_Shortcode{

        public $shortcode = 'title';

        public  static function generate_css( $atts ){
            $css = '';
            return $css;
        }

        public function output_html( $atts, $content = null ){
            $atts = function_exists('vc_map_get_attributes') ? vc_map_get_attributes('worldmart_title', $atts) : $atts;
            $style = '';
            $banner_image = '';
            $desc = '';
            $title= '';
            $el_class = '';
            $title_custom_id = '';
            $css = '';
            $link = '';
            
            /* Extract shortcode parameters.*/
            extract($atts);
            
            $css_class   = array('worldmart-title');
            $css_class[] = $style;
            
            if( $el_class ) 
                $css_class[] = $el_class;
            
            if( $title_custom_id )
                $css_class[] = $title_custom_id;

            if ( function_exists( 'vc_shortcode_custom_css_class' ) ){
                $css_class[] = ' ' . apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
            }

            $links = Array(
                'url'    => '',
                'title'  => '',
                'target' => '',
                'rel'    => '',
            );

            if( $link ){
                $links = wp_parse_args( vc_build_link( $link ), $links );
            }
            ob_start();
            if( $style == 'special' ){ ?>
                <div class="wrap-section-title <?php echo esc_attr( implode(' ', $css_class) );?>">
                    <?php if( $banner_image ){ ?>
                        <div class="banner-box">
                            <figure>
                                <img src="<?php echo wp_get_attachment_url($banner_image) ;?>" alt="<?php echo esc_attr($title); ?>">
                            </figure>
                        </div>
                    <?php } ?>
                    <div class="text-content">
                        <?php if($title){ ?>
                            <h1 class="title"><?php esc_html_e($title,'worldmart-toolkit'); ?></h1>
                        <?php } ?>
                        <?php if( $desc ){ ?>
                            <p class="title-desc"><?php esc_html_e($desc,'worldmart-toolkit') ;?></p>
                        <?php } ?>
                    </div>
                </div>
            <?php } else { ?>
                <?php if( $title ){ ?>
                    <h3 class="<?php echo esc_attr( implode(' ', $css_class) );?>">
                        <?php if(!empty($links['url'])) : ?>
                            <a href="<?php echo esc_url($links['url']); ?>" class="custom_link" rel="<?php echo esc_attr($links['rel']); ?>" title="<?php echo esc_attr($links['title']);?>" target="<?php echo esc_attr($links['target']); ?>" >
                                <span><?php esc_html_e( $title ,'worldmart-toolkit');?></span>
                            </a>
                        <?php else: ?>
                            <span><?php esc_html_e( $title ,'worldmart-toolkit');?></span>
                        <?php endif; ?>
                    </h3>
                <?php } ?>
            <?php } ?>

            <?php
            $html = ob_get_clean();
            return apply_filters( 'worldmart_toolkit_shortcode_title', force_balance_tags( $html ), $atts ,$content );
        }
    }
}