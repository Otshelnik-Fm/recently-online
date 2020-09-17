<?php

/*

  ╔═╗╔╦╗╔═╗╔╦╗
  ║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
  ╚═╝ ╩ ╚  ╩ ╩

 */


/* кто был недавно */
/*
  Array
  (
  [0] => Array
  (
  [ID] => 1
  [display_name] => Анжелика
  [user_nicename] => otshelnik-fm
  [user_email] => otshelnik-fm@yandex.ru
  [meta_value] => http://test-recall.otshelnik-fm.ru/wp-content/uploads/rcl-uploads/avatars/1.jpg
  [time_action] => 2019-07-10 13:44:56
  )

  )
 */
function rco_get_data_db( $atts ) {
    global $wpdb;

    $where = "actions.time_action > date_sub('" . current_time( 'mysql' ) . "', interval " . $atts['period'] . " HOUR)";
    // опция "исключить онлайн"
    if ( $atts['exclude-online'] === 'yes' ) {
        $offset = ' - INTERVAL ' . rcl_get_option( 'timeout', '10' ) . ' MINUTE';
        $where  = "( actions.time_action BETWEEN NOW() - INTERVAL " . $atts['period'] . " HOUR AND '" . current_time( 'mysql' ) . "' " . $offset . " )";
    }

    $datas = $wpdb->get_results( "
            SELECT wp_users.ID,wp_users.display_name,wp_users.user_nicename,user_email,meta_value,actions.time_action
            FROM " . $wpdb->users . " AS wp_users
            LEFT JOIN " . $wpdb->prefix . "rcl_user_action AS actions
            ON wp_users.ID = actions.user
            LEFT JOIN " . $wpdb->usermeta . " AS t_meta
            ON wp_users.ID=t_meta.user_id
            AND meta_key IN ('rcl_avatar', 'ulogin_photo')
            WHERE " . $where . "
            ORDER BY actions.time_action DESC
            LIMIT 0,9999
        ", ARRAY_A );

    return $datas;
}

// считаем сколько
function rco_get_count_db( $atts ) {
    global $wpdb;

    $where = "time_action > date_sub('" . current_time( 'mysql' ) . "', interval " . $atts['period'] . " HOUR)";
    // опция "исключить онлайн"
    if ( $atts['exclude-online'] === 'yes' ) {
        $offset = ' - INTERVAL ' . rcl_get_option( 'timeout', '10' ) . ' MINUTE';
        $where  = "( time_action BETWEEN NOW() - INTERVAL " . $atts['period'] . " HOUR AND '" . current_time( 'mysql' ) . "' " . $offset . " )";
    }

    $datas = $wpdb->get_var( "
        SELECT COUNT(ID)
        FROM " . $wpdb->prefix . "rcl_user_action
        WHERE " . $where . "
" );

    return $datas;
}

add_shortcode( 'otfm_online', 'rco_who_online' );
function rco_who_online( $attr ) {
    $out = '';

    $atts = shortcode_atts( array(
        'exclude-online' => 'no', // yes, no
        'period'         => 24,
        ), $attr, 'otfm_online' );

    $datas = rco_get_data_db( $atts );

    // нет
    if ( ! $datas ) {
        return 'Никого не было';
    }

    $out .= '<div class="userlist mini-list">';
    foreach ( $datas as $data ) {
        $human_time = rcl_get_useraction( $data['time_action'] );
        $time       = '';
        $dop_class  = 'rco_offline';
        if ( $human_time ) {
            $time = ' - не в сети: ' . $human_time;
        } else {
            $dop_class = 'rco_online';
        }

        $out .= '<div class="user-single ' . $dop_class . '" data-user-id="' . $data['ID'] . '">';
        $out .= '<div class="thumb-user">';
        $out .= '<a title="' . $data['display_name'] . $time . '" href="' . get_author_posts_url( $data['ID'], $data['user_nicename'] ) . '">';
        $out .= rco_get_avatar( $data, 50 );
        // значки "Кто в сети" нужны только если выводим и тех кто онлайн
        if ( $atts['exclude-online'] === 'no' ) {
            $out .= rco_status_ico( $data['time_action'] );
        }
        $out .= '</a>';
        $out .= '</div>';
        $out .= '</div>';
    }
    $out .= '</div>';

    return $out;
}

function rco_get_avatar( $data, $size ) {
    $img = '';
    if ( $data['meta_value'] ) {
        $url_img = '';
        if ( is_numeric( $data['meta_value'] ) ) {
            $image_attributes = wp_get_attachment_image_src( $data['meta_value'], [ $size, $size ] );
            $url_img          = $image_attributes[0];
        } else {
            $url_img = $data['meta_value'];
        }

        $time = ( isset( $data['time_action'] ) ) ? $data['time_action'] : '1';

        $img .= '<img '
            . 'class="avatar" '
            . 'src="' . $url_img . '?ver=' . tag_escape( $time ) . '" '
            . 'alt="user_' . $data['ID'] . '_avatar" '
            . 'loading="lazy">';
    } else {
        $img .= get_avatar( $data['user_email'], $size );
    }

    return $img;
}

function rco_status_ico( $action ) {
    $last_action = rcl_get_useraction( $action );

    if ( ! $last_action )
        return '<span class="status_user online"><i class="rcli fa-circle"></i></span>';
    else
        return '<span class="status_user offline" title="Не в сети ' . $last_action . '"><i class="rcli fa-circle"></i></span>';
}

add_shortcode( 'otfm_count_online', 'rco_count_who_online' );
function rco_count_who_online( $attr ) {
    $atts = shortcode_atts( array(
        'exclude-online' => 'no', // yes, no
        'period'         => 24,
        ), $attr, 'otfm_count_online' );

    $datas = rco_get_count_db( $atts );

    // нет
    if ( ! $datas ) {
        return 0;
    }

    return $datas;
}
