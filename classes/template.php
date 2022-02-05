<?php


class template
{
    public function template()
    {
    }

    public function load_template($template, $type = 0, $menu = null, $body = null)
    {
        $template = 'template_' . $template;

        if (!function_exists($template) && $body == null) {
            echo 'Template function <b>', $template, '</b> not found!';
            return;
        }


        switch ($type) {
            case 1:
                template_overall_header();
              //  template_header();
                if ($menu == null) {
                } else {
                    $menu_template = 'template_menu_' . $menu;
                    $menu_template();
                }
                $template();
                template_footer();
                break;
            case 2:

                $template();

                break;

            case 3:
                template_overall_header();
                template_header_client();
                if ($menu == null) {
                } else {
                    $menu_template = 'template_menu_' . $menu;
                    $menu_template();
                }
                $template();
                template_footer();
                break;


            case 4:
                template_overall_header();
                template_header_admin();
                if ($menu == null) {
                } else {
                    $menu_template = 'template_menu_' . $menu;
                    $menu_template();
                }
                $template();
                template_footer();
                break;

            case 5:

                $template();

                break;


            case 6:
                template_overall_report_header();
                $template();
                template_report_footer();
                break;


            case 7:
                template_overall_header();
                template_header();
                $template();
                template_footer();
                break;


            ///this case for email only
            case 10:
                $x = "";
                $x = templateemail_overall_header();
                $x .= templateemail_header();
                if ($body == null) {
                    $x .= $template();
                } else {
                    $x .= $body;
                }

                $x .= templateemail_footer();

                //echo $x;

                break;

            // Start koko
            case 11:
                template_overall_report_header();
                $template();
                break;

            case 12:
                $template();
                template_report_footer();
                break;
            //End koko


            case 13:
                template_overall_header();
                template_header_work();

                $template();

                template_footer();
                break;
                case 14:
                template_overall_header();
                template_header_work();

              

                template_footer();
                break;

        }

        if (isset($x)) {
            return $x;
        }
    }

    public function redirect_page($redirect_url, $redirect_message)
    {
        template_overall_header();
        template_redirect($redirect_url, $redirect_message);
        echo '
	</div>
</body>

</html>';
        exit();
    }
}
