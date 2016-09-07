<?php

class Menu {
    
    private $CI = null;
    
    private $menu = [];
    
    private $submenu = [];
    
    private $url = [];
    
    private $urlNameToId = [];
    
    private $urlIdToLink = [];
    
    const TABLE_MENU = 'infinite_mlm_menu';
    const TABLE_SUBMENU = 'infinite_mlm_sub_menu';
    const TABLE_URL = 'infinite_urls';
    
    const PERM_ADMIN = 'perm_admin';
    const PERM_EMPL = 'perm_emp';
    const PERM_USER = 'perm_dist';
    
    public function __construct() {
        $this->CI =& get_instance();
        
        try {
            $this->menu = $this->CI->db->select(self::TABLE_MENU . '.*, ' . self::TABLE_URL . '.link, ' . self::TABLE_URL . '.target')
                    ->from(self::TABLE_MENU)
                    ->join(self::TABLE_URL, self::TABLE_MENU . '.link_ref_id = ' . self::TABLE_URL . '.id', 'LEFT')
                    ->where(self::TABLE_MENU .'.status', 'yes')->get()->result();
            $this->submenu = $this->CI->db->select(self::TABLE_SUBMENU . '.*, ' . self::TABLE_URL . '.link, ' . self::TABLE_URL . '.target')
                    ->from(self::TABLE_SUBMENU)
                    ->join(self::TABLE_URL, self::TABLE_SUBMENU . '.sub_link_ref_id = ' . self::TABLE_URL . '.id', 'LEFT')
                    ->where('sub_status', 'yes')->get()->result();
            // used to handle old request in case of errors
            $this->url = $this->CI->db->where('status', 'yes')->get(self::TABLE_URL)->result();
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            show_error($e->getMessage());
        }
    }
    
    /**
     * Return url id by it link.
     * @param string $string
     * @return int
     */
    public function UrlToId($string)
    {
        if (isset($this->urlNameToId[$string])) {
            return $this->urlNameToId[$string];
        }
        foreach ($this->url as $url) {
            if ($url->link != $string) continue;
            
            $this->urlNameToId[$string] = $url->id;
            return $url->id;
        }
        return 0;
    }
    
    /**
     * Return url link by it id.
     * @param int $int
     * @return string
     */
    public function IdToUrl($int)
    {
        if (isset($this->urlIdToLink[$int])) {
            return $this->urlIdToLink[$int];
        }
        foreach ($this->url as $url) {
            if ($url->id != $int) continue;
            
            $this->urlIdToLink[$int] = $url->link;
            return $url->link;
        }
        return '';
    }
    
    /**
     * Return target for menu link
     * @param int $int
     * @return string
     */
    public function IdToTarget($int)
    {
        foreach ($this->url as $url) {
            if ($url->id != $int) continue;
            
            return $url->target;
        }
        return 'none';
    }
    
    /**
     * Return menu array that user can access
     * @param int $user
     * @param string $type
     * @param string $url
     * @return array
     */
    public function BuildMenu($user, $type, $url)
    {
        $menues = [];
        $path_reg = base_url();
        $path = $path_reg . 'user/';
        $perm = self::PERM_USER;
        $ctrl = $this->CI->router->fetch_class();
        
        if ($type == 'admin') {
            $perm = self::PERM_ADMIN;
            $path = $path_reg . 'admin/';
        } elseif($type == 'employee') {
            $perm = self::PERM_EMPL;
            $path = $path_reg . 'admin/';
            try {
                $menues = explode(',', $this->CI->db->select("module_status")
                        ->from("login_employee")
                        ->where('user_id', $user)
                        ->get()->row()->module_status);
            } catch (Exception $ex) {
                // ignore error just log it
                log_message('error', $ex->getMessage());
            }
        }
        
        $menu = array_filter($this->menu, function ($a) use ($perm, $ctrl) {
            // FIXME clean this hardcode
            return $a->{$perm} == 1 && $a->id != 36 && (
                ($perm == self::PERM_ADMIN && ($ctrl == 'ticket_system' && in_array($a->id, [66, 67, 68, 69, 70, 71, 72, 73, 24])))
                    ||
                ((($perm == self::PERM_ADMIN && $ctrl != 'ticket_system') || $perm == self::PERM_EMPL) && !in_array($a->id, [66, 67, 68, 69, 70, 71, 72, 73]))
                    ||
                ($perm == self::PERM_USER)
            );
        });
        
        usort($menu, function ($a, $b) {
            if ($a->main_order_id == $b->main_order_id) {
                return $a->id > $b->id ? 1 : -1;
            }
            return $a->main_order_id > $b->main_order_id ? 1 : -1;
            }
        );
        
        foreach ($menu as $item) {
            
            $item->children = [];
            foreach ($this->submenu as $sub) {
                if ($sub->sub_refid == $item->id && $sub->{$perm} == 1 && ($perm != self::PERM_EMPL || ($perm == self::PERM_EMPL && in_array("{$item->id}#{$sub->sub_id}", $menues)))) {
                    $sub->text = $this->CI->lang->line($item->id . '_' . $sub->sub_id . '_' . $sub->sub_link_ref_id);
                    $sub->selected = $url == $sub->link;
                    $sub->link = $path . $sub->link;
                    $item->children[] = $sub;
                }
            }
            
            usort($item->children, function($a, $b){
                if ($a->sub_order_id == $b->sub_order_id) {
                    return $a->sub_id > $b->sub_id ? 1 : -1;
                }
                return $a->sub_order_id > $b->sub_order_id ? 1 : -1;
            });
            
            $item->selected = $url == $item->link || count(array_filter($item->children, function($a) {
                return $a->selected;
            }));
            $item->allow = $perm != self::PERM_EMPL || (in_array("m#{$item->id}", $menues) || count($item->children));
            
            // FIXME death to hardcode
            if ($item->link_ref_id == 19 || $item->link_ref_id == 4) {//register/user_register & login/logout
                $item->link = $path_reg . $item->link;
            } elseif ($item->link_ref_id != '#') {
                $item->link = $path . $item->link;
            } else {
                $item->link = 'javascript:void(0);';
            }
            
            $item->text = $this->CI->lang->line($item->id . '_' . $item->link_ref_id);
        }

        return array_filter($menu, function ($a) {return $a->allow;});
    }
    
}