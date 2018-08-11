<?php
function get_domain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
    }
    return false;
}

function build_menu()
{
    $menu = json_decode(file_get_contents(__DIR__ . "/../../system/storage/menu.json"), true);
    foreach ($menu as $node) {
        if (!empty($node['title']) && !empty($node['url'])) {
            $getMenu = isset($_GET['menu']) ? $_GET['menu'] : '';
            $checkParent = (isset($node['children']) && !empty($node['children'])) ? check_in_child_array($getMenu, $node['children']) : '';
            $parentSelected = ($checkParent) ? $selected = 'style="color: red;"' : null;
            echo "<li class='nav-item' " . $parentSelected . "><a class='nav-link smooth-scroll' href='" . $node['url'] . "'>" . $node['title'] . "</a></li>";
        }
    }
}

function check_in_child_array($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item['link'] === $needle : $item == $needle) || (is_array($item) && check_in_child_array($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

function social_links()
{
    $social_links = json_decode(file_get_contents(__DIR__ . "/../../system/storage/template.json"), true);
    foreach ($social_links as $link => $key) {
        if (!empty($key)) {
            switch ($link) {
                case 'facebook':
                    echo '<a href="https://facebook.com/' . $key . '"><i class="fab fa-facebook-f"></i></a>';
                    break;
                case 'twitter':
                    echo '<a href="https://twitter.com/' . $key . '"><i class="fab fa-twitter"></i></a>';
                    break;
                case 'youtube':
                    echo '<a href="https://youtube.com/' . $key . '"><i class="fab fa-youtube"></i></a>';
                    break;
                case 'google':
                    echo '<a href="https://plus.google.com/' . $key . '"><i class="fab fa-google-plus-g"></i></a>';
                    break;
                case 'instagram':
                    echo '<a href="https://instagram.com/' . $key . '"><i class="fab fa-instagram fa-fw fa-2x"></i></a>';
                    break;
            }
        }
    }
}

function list_languages()
{
    foreach (glob(__DIR__ . "/../../language/*.php") as $filename) {
        if (basename($filename) != "index.php") {
            $language = str_replace(".php", null, basename($filename));
            if (language_exists($language) === true) {
                echo '<a class="dropdown-item" href="?lang=' . $language . '">' . $language . '</a>';
            }
        }
    }
}