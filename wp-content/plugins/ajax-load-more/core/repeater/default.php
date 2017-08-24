<?php                    
$url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumb-big');
 ?>
<div  class="col-post-3 post-excerpt ">
                            <a href="<?php echo get_permalink(); ?>" class="img-cont" style="background-image: url(<?php echo $url[0]; ?>)"></a>
                            <h3 class="post-excerpt-title"><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></h3>
                        </div>