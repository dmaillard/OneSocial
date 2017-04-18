<?php
do_action('bp_before_member_messages_loop');
global $bp;
$user_compose_draft_ids = bbm_draft_user_compose_drafts();

if ( bp_has_message_threads(bp_ajax_querystring('messages') . 'drafts=true') || !empty($user_compose_draft_ids) ) :
    ?>

    <?php do_action('bp_before_member_messages_threads'); ?>

    <div class="messages-options-nav">
        <?php bbm_messages_options(); ?>
    </div><!-- .messages-options-nav -->

    <table id="message-threads" class="messages-table drafts">
        <thead>
            <tr>
                <th scope="col" class="thread-checkbox bulk-select-all"><input id="select-all-messages" type="checkbox"><strong></strong><label class="bp-screen-reader-text" for="select-all-messages"><?php _e( 'Select all', 'onesocial' ); ?></label></th>
                <th scope="col" class="thread-from"><?php _e( 'From', 'onesocial' ); ?></th>
                <th scope="col" class="thread-info"><?php _e( 'Subject', 'onesocial' ); ?></th>

                <?php

                /**
                 * Fires inside the messages box table header to add a new column.
                 *
                 * This is to primarily add a <th> cell to the messages box table header. Use
                 * the related 'bp_messages_inbox_list_item' hook to add a <td> cell.
                 *
                 * @since 2.3.0
                 */
                //do_action( 'bp_messages_inbox_list_header' ); ?>

                <th scope="col" class="thread-options"><?php _e( 'Date', 'buddypress-inbox' ); ?></th>

            </tr>
        </thead>

        <tbody>
        <?php while (bp_message_threads()) : bp_message_thread(); ?>
            <?php $bbm_draft_id = bbm_draft_col_by_thread_id(bp_get_message_thread_id(), 'bbm_draft_id'); ?>
            <tr id="m-<?php bp_message_thread_id(); ?>" class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else: ?> read<?php endif; ?>">
                <td class="bulk-select-check">
                     <label for="bp-message-thread-<?php bp_message_thread_id(); ?>">
                     <input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php echo $bbm_draft_id; ?>" class="message-check" value="<?php echo $bbm_draft_id; ?>" /><strong></strong>
                     <span class="bp-screen-reader-text"><?php _e( 'Select this message', 'onesocial' ); ?></span></label>
                </td>

                <td class="thread-from">
                    <div class="table">
                        <div class="table-cell"><?php bp_message_thread_avatar( array( 'width' => 60, 'height' => 60 ) ); ?></div>
                        <div class="table-cell">
                            <span class="to"><?php _e('To:', 'onesocial'); ?></span>
                            <?php
                            $get_to = bp_get_message_thread_to();
                            if(!empty($get_to)){
                                bp_message_thread_to();
                            }else{
                                _e('Draft', 'onesocial');
                            }
                            ?>
                        </div>
                    </div>
                </td>

                <td class="thread-info">
                    <p>
                        <a href="<?php bp_message_thread_view_link(); ?>" title="<?php esc_attr_e("View Message", "onesocial"); ?>">
                            <?php
                            $get_subject = bp_get_message_thread_subject();
                            if(!empty($get_subject)){
                                bp_message_thread_subject();
                            }else{
                                _e('Draft', 'onesocial');
                            }
                            ?>
                        </a>
                    </p>
                    <p class="thread-excerpt">
                        <?php
                        $get_excerpt = bp_get_message_thread_excerpt();
                        if(!empty($get_excerpt)){
                            bp_message_thread_excerpt();
                        }else{
                            _e('Draft', 'onesocial');
                        }
                        ?>
                    </p>
                </td>

                <td class="thread-options">
                    <?php $draft_date = bbm_draft_col_by_thread_id(bp_get_message_thread_id(), 'draft_date'); ?>
                    <?php echo buddyboss_format_time(strtotime($draft_date)); ?>
                </td>

                <?php do_action('bp_messages_inbox_list_item'); ?>

            </tr>

        <?php endwhile; ?>

        <?php
        if(!empty($user_compose_draft_ids)):
            foreach($user_compose_draft_ids as $single):
                $draft_detail = $single;
                $recipient_user_id = bp_is_username_compatibility_mode()
                    ? bp_core_get_userid( $draft_detail->recipients )
                    : bp_core_get_userid_from_nicename( $draft_detail->recipients );

                $draft_compose_url = trailingslashit(bp_displayed_user_domain() . $bp->messages->slug).'compose';
                $draft_compose_url = esc_url(add_query_arg( 'draft_id', $draft_detail->bbm_draft_id, $draft_compose_url ));

                ?>
                <tr id="m-<?php echo $draft_detail->bbm_draft_id ?>" class="<?php bp_message_css_class(); ?><?php if (bp_message_thread_has_unread()) : ?> unread<?php else: ?> read<?php endif; ?>">

                    <td class="bulk-select-check">
                         <label for="bp-message-thread-<?php bp_message_thread_id(); ?>">
                         <input type="checkbox" name="message_ids[]" id="bp-message-thread-<?php echo $bbm_draft_id; ?>" class="message-check" value="<?php echo $draft_detail->bbm_draft_id; ?>" />
                         <span class="bp-screen-reader-text"><?php _e( 'Select this message', 'onesocial' ); ?></span></label>
                    </td>

                    <td class="thread-from">
                        <?php echo get_avatar( $recipient_user_id, 25 ); ?>
                        <span class="to"><?php _e( 'To:', 'onesocial' ); ?></span>
                        <?php
                        $get_to = $draft_detail->recipients;
                        if(!empty($get_to)){
                            echo !empty($recipient_user_id) ? bp_core_get_userlink( $recipient_user_id ) : $get_to;
                        }else{
                            _e('Draft', 'onesocial');
                        }
                        ?>
                    </td>

                    <td class="thread-info">
                        <p>
                            <a href="<?php echo $draft_compose_url; ?>" title="<?php esc_attr_e("View Message", "onesocial"); ?>">
                                <?php
                                $get_subject = $draft_detail->draft_subject;
                                if(!empty($get_subject)){
                                    echo $get_subject;
                                }else{
                                    _e('Draft', 'onesocial');
                                }
                                ?>
                            </a>
                        </p>
                        <p class="thread-excerpt">
                            <?php
                            $get_excerpt = wp_trim_words($draft_detail->draft_content, 5);
                            if(!empty($get_excerpt)){
                                echo $get_excerpt;
                            }else{
                                _e('Draft', 'onesocial');
                            }
                            ?>
                        </p>
                    </td>

                    <?php do_action('bp_messages_inbox_list_item'); ?>


                    <td class="thread-options">
                        <span class="activity">
                            <?php  echo buddyboss_format_time(strtotime( $draft_detail->draft_date )); ?>
                        </span>
                    </td>
                </tr>
            <?php
            endforeach;
        endif;
        ?>
        </tbody>
    </table><!-- #message-threads -->

    <?php do_action('bp_after_member_messages_threads'); ?>

    <?php do_action('bp_after_member_messages_options'); ?>

<?php else: ?>

    <div id="message" class="info">
        <p><?php _e('Sorry, no messages were found.', 'onesocial'); ?></p>
    </div>

<?php endif; ?>

<?php
do_action('bp_after_member_messages_loop');