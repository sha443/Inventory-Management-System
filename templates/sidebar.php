<div class="sidebar" data-color="blue" data-image="assets/img/sidebar-4.jpg">
    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="http://www.kazimobilehome.com" class="simple-text">
                    Kazi Mobile Home
                </a>
                <h6> Dumuria Branch, Khulna</h6>
            </div>

            <ul class="nav">
            <?php
            function DashboardMenu($fileName)
            {
                $xml = simplexml_load_file('./templates/'.$fileName);
                $menu = "";
                foreach($xml->items as $item)
                {
                    if(basename($_SERVER['PHP_SELF'])==$item->link)
                    {
                        $menu .= '<li class="active"> <a href="'.$item->link.'"><i class="'.$item->icon.'"></i> '.$item->title.'</a></li>';
                    }
                    else
                    {
                        $menu .= '<li> <a href="'.$item->link.'"><i class="'.$item->icon.'"></i> '.$item->title.'</a></li>';
                    }
                }
                return $menu;

                }

                if(isset($_SESSION[$adminToken]))
                {
                    echo DashboardMenu('menu.xml');
                }
                elseif (isset($_SESSION[$userToken]))
                {
                    echo DashboardMenu('menu_user.xml');
                }

            ?>
				
            </ul>
    	</div>
    </div>
