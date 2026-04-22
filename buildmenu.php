<?php

use \Tsugi\Util\U;

function buildMenu() {
    global $CFG;
    $R = $CFG->apphome . '/';
    $T = $CFG->wwwroot . '/';
    $adminmenu = isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true";
    $showCalendarDueUi = isset($_SESSION['id'])
        && U::isNotEmpty($CFG->lessons)
        && \Tsugi\Grades\GradeUtil::showDueDates(U::get($_SESSION, 'context_id', 0));
    $set = new \Tsugi\UI\MenuSet();
    $set->setHome($CFG->servicename, $CFG->apphome);
    $set->addLeft('Lessons', $R.'lessons');
    if ( isset($_SESSION['id']) ) {
        $set->addLeft('Assignments', $R.'assignments');
    } else {
        // $set->addLeft('OER', $R.'materials');
    }
    $set->addLeft('Book', $R . 'book');
    $set->addLeft('Courses', $R.'coursesredirect.php');
    
    if ( isset($_SESSION['id']) ) {
        $submenu = new \Tsugi\UI\Menu();
        $submenu->addLink('Playground', $R.'play');
        $submenu->addLink('Online Compilers', $R.'compilers');
        $submenu->addLink('JSLinux', 'https://bellard.org/jslinux/vm.html?url=alpine-x86.cfg&mem=192');
        $submenu->addLink('EmScriptEn', "https://emscripten.org");
        $set->addLeft('Write C', $submenu);
        $submenu = new \Tsugi\UI\Menu();
        $submenu->addLink('Profile', $R.'profile');
        if ( isset($CFG->google_map_api_key) ) {
            $submenu->addLink('Map', $R.'map');
        }
    
        // $submenu->addLink('Badges', $R.'badges');
        $submenu->addLink('Materials', $R.'materials');
        $submenu->addLink('Announcements', $R.'announcements');
        $submenu->addLink('Notifications', $R.'notifications');
        $submenu->addLink('Grades', $R.'grades');
        $submenu->addLink('Pages', $R.'pages');
        $submenu->addLink('Courses', $R.'coursesredirect.php');
        $submenu->addLink('LMS Integration', $T . 'settings');

        if ( isset($CFG->google_classroom_secret) ) {
            $submenu->addLink('Google Classroom', $T.'gclass/login');
        }
        $submenu->addLink('Old Courses', $R . 'archive');
        $submenu->addLink('Free App Store', 'https://www.tsugicloud.org');
        $submenu->addLink('Rate this course', 'https://www.class-central.com/mooc/7363/python-for-everybody');
        $submenu->addLink('Privacy', $R.'privacy');
        $submenu->addLink('Service Level', $R.'service');
        if ( isset($_COOKIE['adminmenu']) && $_COOKIE['adminmenu'] == "true" ) {
            $submenu->addLink('Administer', $T . 'admin/');
        }
        $submenu->addLink('Logout', $R.'logout');

        if ( isset($_SESSION['avatar']) ) {
            $set->addRight('<img src="'.$_SESSION['avatar'].'" alt="'.htmlentities(__('User profile menu')).'" title="'.htmlentities(__('User Profile Menu - Includes logout')).'" style="height: 2em;"/>', $submenu);
            // htmlentities($_SESSION['displayname']), $submenu);
        } else {
            $set->addRight(htmlentities($_SESSION['displayname']), $submenu);
        }
    } else {
        $set->addRight('Login', $R.'login');
    }

    if ( isset($_SESSION['id']) ) {
        $set->addRight('<tsugi-notifications api-url="'. htmlspecialchars($T . 'api/notifications.php') . '" notifications-view-url="'. htmlspecialchars($R . 'notifications') . '" announcements-view-url="'. htmlspecialchars($R . 'announcements') . '"></tsugi-notifications>', false);
        if ( $showCalendarDueUi ) {
            $set->addRight(
                '<tsugi-calendar-due api-url="'. htmlspecialchars($R . 'calendar/json') . '" lessons-url="'. htmlspecialchars($R . 'lessons') . '"></tsugi-calendar-due>',
                false,
                true,
                'hidden-xs tsugi-wc-nav-item'
            );
        }
        if ( isset($CFG->tdiscus) && $CFG->tdiscus ) {
            $set->addRight(
                '<tsugi-discussions api-url="'. htmlspecialchars($R . 'discussions/json') . '" discussions-url="'. htmlspecialchars($R . 'discussions') . '"></tsugi-discussions>',
                false,
                true,
                'hidden-xs tsugi-wc-nav-item'
            );
        }
    } else {
        $set->addRight('Old Courses', $R . 'archive');
    }


    return($set);
}

