<?php
/**
 * General Widget structure for different users list.
 *
 * @version		$Rev: 225 $
 * @author		Jordi Canals
 * @package		AOC
 * @subpackage	Library
 * @link		http://alkivia.org
 * @license		http://www.gnu.org/licenses/gpl.html GNU General Public License v3

	Copyright (C) 2009 Jordi Canals <alkivia@jcanals.net>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
 	the Free Software Foundation, either version 3 of the License, or
 	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 	GNU General Public License for more details.

 	You should have received a copy of the GNU General Public License
 	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Widget class for users lists.
 * Always shows the same output format and control.
 * Must define the methods startUp() and widget()
 *
 * @package AOC
 * @subpackage Library
 * @since 0.8
 */
final class SidepostsWidget extends WP_Widget {

    /**
     * Plugin ID and translation textDomain.
     * @var string
     */
    private $pid;

    /**
     * Class constructor.
     * @see WP_Widget::__construct()
     */
    public function __construct() {
        global $SidePosts;
        $this->pid = $SidePosts->id;     // Translation textdomain.

		$options = array('classname' => 'widget_sideposts', 'description' => __('A widget to move posts to the sidebar.', $this->pid) );
        parent::__construct($this->pid, 'SidePosts', $options );
    }

	/**
	 * Widget Output
	 * @see WP_Widget::widget()
	 */
    public function widget( $args, $instance ) {
        global $SidePosts;
        $SidePosts->savePost();

		extract( $args, EXTR_SKIP );

		$category = (int) $instance['category'];
		if ( 0 == $category ) {
			_e('Category not selected.', $this->pid);
			return;
		} elseif ( is_category($category) ) {
            return;    // Don't show the widget when browsing the category archives.
        }

		if ( -99 == (int) $category && ! current_user_can('read_private_posts') ) {
			return;								// Widget is for private posts and user cannot see them
		}

		$numposts = (int) $instance['numposts'];
		if ( 1 > $numposts ) {		// Defaults to 3 posts on sidebar
			$numposts = 3;
		} elseif ( 20 < $numposts ) {	// No more than 20 posts.
			$numposts = 20;
		}

    $show_feeds = (int) $instance['show_feeds'];

    $show_read_more = (int) $instance['show_read_more'];

		$qargs = array( 'showposts' => $numposts );
		if ( -99 == (int) $category ) {
            $qargs['post_status'] = 'private';
            $qargs['caller_get_posts'] = 1;
		} else {
            $qargs['cat'] = $category;
		}
		if ( is_single() ) {
            $qargs['post__not_in'] = array($SidePosts->savedID());
		}

		$q = new WP_Query($qargs);
		if ( $q->have_posts() ) {
    		echo $before_widget;
	    	if ( !empty($instance['title']) ) {
		    	echo $before_title. $instance['title'] . $after_title;
    		}
	    	echo '<ul>';

		    while ( $q->have_posts() ) {
				$q->the_post();

				echo '<li>';
				echo '<h3><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3>';

				if ( 'title' != $instance['show']) {
					global $post;
					// $date_string = '<span class="sideposts_date">'. mysql2date(get_option('date_format'), $post->post_date) . ' | ' . get_the_time() .'</span>';
					// echo '<br />' . apply_filters($this->pid . '_date',  $date_string);

					switch ( $instance['show'] ) {
						case 'posts' :
							global $more;
							$more = false;
							the_content('<p>' . __('Read more &raquo;', $this->pid) . '</p>');
							break;
						case 'ex-thumb' :
							echo '<p>'. $SidePosts->excerptThumbnail($instance) . get_the_excerpt() . '</p>';
							// echo '<p><a href="'. get_permalink() .'">'. __('Read full post &raquo;', $this->pid) .'</a></p>';
							break;
						case 'excerpt' :
							the_excerpt();
							// echo '<p><a href="'. get_permalink() .'">'. __('Read full post &raquo;', $this->pid) .'</a></p>';
							break;
						case 'photoblog' :
						    echo '<p>' . $SidePosts->mediumImage($instance) . '</p>';
						    the_excerpt();
						    echo '<p>';
						    comments_popup_link( __('No Comments', $this->pid),
						                         __('1 Comment', $this->pid),
						                         __('% Comments', $this->pid),
						                         'sideposts-comments',
						                         __('Comments closed', $this->pid));
						    echo '</p>';
						    break;
					}
				}

				echo '</li>';
			}

      if ($show_feeds) {
        if ( -99 != (int) $category ) {
            echo '<li>';
            echo '<a href="'
            . get_category_feed_link($category) .'"><img style="border:0;float:right;" src="'
            . $SidePosts->getURL() . 'rss.png" alt="RSS" /></a>';

            echo '<a href="' . get_category_link($category) .'">';
            _e('Archive for', $this->pid);
            echo ' '. $instance['title'] .'</a> &raquo;</li>'; // get_the_category_by_ID($category)
          }
      }

      if ($show_read_more) {
				echo '<a class="right read-more" href="'. get_permalink() .'">&raquo; Read More</a>';
        echo '<div class="clear"></div>';
      }

	    echo '</ul>';
		  echo $after_widget;

    	$SidePosts->restorePost(); // Revert to the previous post status.
		}
    }

    /**
     * Widget Control form.
     * @see WP_Widget::form()
     */
    public function form( $instance ) {
        $defaults = array (
			    'title'      => '',
				'category'   => 0,
				'numposts'   => 3,
				'show'       => 'posts',
				'thumbnail'  => 100,
                'rightalign' => 0,
                'feeds'		 => 0
        );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = attribute_escape($instance['title']);
	?>
		<p><?php _e('Title:', $this->pid); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></p>
		<p><?php _e('Category:', $this->pid); ?>
			<select name="<?php echo $this->get_field_name('category'); ?>" id="<?php echo $this->get_field_id('category') ?>" class="widefat">
				<option value="-99"<?php  selected(-99, (int) $instance['category']); ?>><?php _e('-- PRIVATE POSTS --', $this->pid) ?></option>
				<?php
				$categories	= get_terms('category');
				foreach ( $categories as $cat ) {
					echo '<option value="' . $cat->term_id .'"';
					selected((int) $cat->term_id, (int) $instance['category']);
					echo '>' . $cat->name . '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<?php _e('Number of posts:', $this->pid); ?> <input style="width: 30px;" id="<?php echo $this->get_field_id('numposts'); ?>" name="<?php echo $this->get_field_name('numposts'); ?>" type="text" value="<?php echo $instance['numposts']; ?>" />
			<br />
			<small><?php printf(__('(At most %d)', $this->pid), 20); ?></small>
		</p>
		<p>
			<?php _e('Show:', $this->pid); ?><select name="<?php echo $this->get_field_name('show'); ?>" id="<?php echo $this->get_field_id('show'); ?>" class="widefat">
				<option value="posts" <?php selected('posts', $instance['show']); ?>><?php _e('Full Post', $this->pid); ?></option>
				<option value="excerpt" <?php selected('excerpt', $instance['show']); ?>><?php _e('Post Excerpt', $this->pid); ?></option>
				<option value="ex-thumb" <?php selected('ex-thumb', $instance['show']); ?>><?php _e('Excerpts with thumbnails', $this->pid); ?></option>
				<option value="photoblog" <?php selected('photoblog', $instance['show']); ?>><?php _e('Photo Blog', $this->pid); ?></option>
				<option value="title"<?php selected('title', $instance['show']); ?>><?php _e('Only Post Title', $this->pid); ?></option>
			</select>
		</p><p>
			<input type="checkbox" id="<?php echo $this->get_field_id('feeds'); ?>" name="<?php echo $this->get_field_name('feeds'); ?>" value="1"<?php checked(1, $instance['feeds']); ?>" />
			<?php _e('Show category on all feeds', $this->pid); ?>
		</p><p>
      <input type="checkbox" id="<?php echo $this->get_field_id('show_feeds'); ?>" name="<?php echo $this->get_field_name('show_feeds'); ?>" value="1"<?php checked(1, $instance['show_feeds']); ?>" />
      <?php _e('Show feeds', $this->pid); ?>
    </p><p>
      <input type="checkbox" id="<?php echo $this->get_field_id('show_read_more'); ?>" name="<?php echo $this->get_field_name('show_read_more'); ?>" value="1"<?php checked(1, $instance['show_read_more']); ?>" />
      <?php _e('Show read more link', $this->pid); ?>
		</p><p>
			<?php _e('Thumbnail width:', $this->pid); ?>
			<input style="width: 50px;" id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="text" value="<?php echo $instance['thumbnail']; ?>" />
			<?php _e('pixels', $this->pid)?>
		</p><p>
			<input type="checkbox" id="<?php echo $this->get_field_id('rightalign'); ?>" name="<?php echo $this->get_field_name('rightalign'); ?>" value="1"<?php checked(1, $instance['rightalign']); ?>" />
			<?php _e('Align thumbnail to right', $this->pid); ?>
		</p>
	<?php
    }

    /**
     * Widget data validation.
     * @see WP_Widget::update()
     */
    public function update ( $newInstance, $oldInstance ) {
        $instance = $oldInstance;

		$instance['title'] = strip_tags(stripslashes($newInstance['title']));
		$instance['category'] = (int) $newInstance['category'];
		$instance['numposts'] = intval($newInstance['numposts']);
		$instance['show'] = strip_tags(stripslashes($newInstance['show']));
		$instance['thumbnail'] = intval($newInstance['thumbnail']);
		$instance['rightalign'] = intval($newInstance['rightalign']);
		$instance['feeds'] = intval($newInstance['feeds']);
    $instance['show_feeds'] = intval($newInstance['show_feeds']);
    $instance['show_read_more'] = intval($newInstance['show_read_more']);

		return $instance;
    }
}
