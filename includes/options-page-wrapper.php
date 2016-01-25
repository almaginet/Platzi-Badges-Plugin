<div class="wrap">
    <div id="icon-options-general" class="icon32"></div>
    <h1>Platzi Badges</h1>
    <?php if ( isset( $error ) ) : ?>
        <div class="error">
            <p><strong>Error:</strong> <?php echo $error['message']; ?></p>
        </div>
    <?php endif; ?>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <?php if ( ! isset( $platzi_profile ) ) : ?>
                        <div class="postbox">
                            <div class="handlediv" title="Click to toggle"><br></div>
                            <!-- Toggle -->
                            <h2 class="hndle"><span>Let's Get Started!</span>
                            </h2>
                            <div class="inside">
                                <form action="" method="post">
                                    <table class="form-table">
                                        <tr class="">
                                            <th scope="row">
                                                <label for="username">
                                                    Platzi username
                                                    <span class="description">
                                                        (Required)
                                                    </span>
                                                </label>
                                            </th>
                                            <td>
                                                <input id="username" name="username" type="text" value="<?php echo ( isset( $error['username'] ) ? $error['username']  : '' ); ?>" class="regular-text" />
                                            </td>
                                        </tr>
                                    </table>
                                    <p class="submit">
                                        <input class="button-primary" type="submit" value="Save" />
                                    </p>
                                </form>
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    <?php else : ?>
                        <div class="postbox">
                            <h2 class="hndle">Careers</h2>
                            <?php
                                $badges_careers = isset( $platzi_profile->badges->careers ) ? $platzi_profile->badges->careers : '';
                            ?>
                            <div class="inside">
                                <?php if ( $badges_careers ) : ?>
                                    <ul class="platzi-badges-list">
                                        <?php foreach ( $badges_careers as $badge ) : ?>
                                            <li class="platzi-badges-list__item">
                                                <img src="<?php echo $badge->url; ?>" alt="<?php echo $badge->name; ?>" width="100">
                                                <span><?php echo $badge->name; ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                        <div class="postbox">
                            <h2 class="hndle">Courses</h2>
                            <?php
                                $badges_courses = isset( $platzi_profile->badges->courses ) ? $platzi_profile->badges->courses: '';
                            ?>
                            <div class="inside">
                                <?php if ( $badges_courses ) : ?>
                                    <ul class="platzi-badges-list">
                                        <?php foreach ( $badges_courses as $badge ) : ?>
                                            <li class="platzi-badges-list__item">
                                                <img src="<?php echo $badge->url; ?>" alt="<?php echo $badge->name; ?>" width="100">
                                                <span><?php echo $badge->name; ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    <?php endif; ?>
                </div>
                <!-- .meta-box-sortables .ui-sortable -->
            </div>
            <!-- post-body-content -->
            <?php if ( isset( $platzi_profile ) ) : ?>
                <!-- sidebar -->
                <div id="postbox-container-1" class="postbox-container">
                    <div class="meta-box-sortables">
                        <div class="postbox">
                            <div class="handlediv" title="Click to toggle"><br></div>
                            <!-- Toggle -->
                            <?php
                                $user = $platzi_profile->user;
                                $avatar = ( isset( $user->avatar ) ) ? $user->avatar : '';
                                $badge = ( isset( $user->badge ) ) ? $user->badge : '';
                                $name = ( isset( $user->name ) ) ? $user->name : '';
                                $country = ( isset( $user->country ) ) ? $user->country : '';
                                $url = ( isset( $user->url ) ) ? $user->url : '';
                                $twitter = ( isset( $user->twitter ) ) ? $user->twitter : '';
                                $facebook = ( isset( $user->facebook ) ) ? $user->facebook : '';
                            ?>
                            <h2 class="hndle"><span><?php echo ( ! empty( $name ) ? $name : '' ); ?></span></h2>
                            <div class="inside platzi-block">
                                <div class="platzi-user">
                                    <?php if ( $avatar ) : ?>
                                        <div class="platzi-user__avatar">
                                            <img src="<?php echo $avatar ?>" width="150">
                                            <?php if ( $badge ) : ?>
                                                <span class="platzi-user__badge"><img src="<?php echo $badge; ?>" width="40"></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="platzi-user__meta">
                                        <?php if ( $country ) : ?>
                                            <span class="platzi-user__country"><?php echo $country; ?></span>
                                        <?php endif; ?>
                                        <?php if ( $url ) : ?>
                                            <span class="platzi-user__url">
                                                <a href="<?php echo $url; ?>" target="_blank">
                                                    <span class="dashicons dashicons-admin-links"></span>
                                                </a>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ( $twitter ) : ?>
                                            <span class="platzi-user__twitter">
                                                <a href="<?php echo $twitter; ?>" target="_blank">
                                                    <span class="dashicons dashicons-twitter"></span>
                                                </a>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ( $facebook ) : ?>
                                            <span class="platzi-user__facebook">
                                                <a href="<?php echo $facebook; ?>" target="_blank">
                                                    <span class="dashicons dashicons-facebook-alt"></span>
                                                </a>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <form action="" method="post">
                                    <input name="_method" type="hidden" value="put">
                                    <p>
                                        <label for="platzi-username">Platzi username</label>
                                    </p>
                                    <p>
                                        <input id="platzi-username" name="username" type="text" value="<?php echo $platzi_username; ?>" />
                                    </p>
                                    <p class="submit">
                                        <input class="button-primary" type="submit" value="Update" />
                                    </p>
                                </form>
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    </div>
                    <!-- .meta-box-sortables -->
                </div>
                <!-- #postbox-container-1 .postbox-container -->
            <?php endif; ?>
        </div>
        <!-- #post-body .metabox-holder .columns-2 -->
        <br class="clear">
    </div>
    <!-- #poststuff -->
</div> <!-- .wrap -->
