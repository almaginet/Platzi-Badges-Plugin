<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
    Total badges careers: <strong><?php echo count( $careers ); ?></strong>
</p>
<p>
    Total badges courses: <strong><?php echo count( $courses ); ?></strong>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of badges to show:</label>
    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
</p>
<p>
    <input class="checkbox" type="checkbox"<?php checked( $show_careers ); ?> id="<?php echo $this->get_field_id( 'show_careers' ); ?>" name="<?php echo $this->get_field_name( 'show_careers' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_careers' ); ?>">Display careers?</label>
</p>
<p>
    <input class="checkbox" type="checkbox"<?php checked( $show_courses ); ?> id="<?php echo $this->get_field_id( 'show_courses' ); ?>" name="<?php echo $this->get_field_name( 'show_courses' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_courses' ); ?>">Display courses?</label>
</p>
<p>
    <input class="checkbox" type="checkbox"<?php checked( $show_titles ); ?> id="<?php echo $this->get_field_id( 'show_titles' ); ?>" name="<?php echo $this->get_field_name( 'show_titles' ); ?>" />
    <label for="<?php echo $this->get_field_id( 'show_titles' ); ?>">Display badge title?</label>
</p>
