<?php

class order_history_model extends inf_model {

    private $_table = 'order_history';

    public function __construct() {

    }

    public function getPendingOrderDay($until = null)
    {
        try {
            $this->db->select('date');
            $this->db->limit(1);
            $this->db->where('status !=', 3);
            if ($until) {
                $this->db->where('date <=', $until . '23:59:59');
            }
            $this->db->order_by('date', 'ASC');
            $r = $this->db->get($this->_table)->row();
            $d = $r ? explode(' ', $r->date) : null;
            return $d[0];
        } catch (Exception $e) {
            log_message('warning', 'There is no more days in order');
            return null;
        }
    }
    
    public function getOrdersByDay($date)
    {
        echo '<br>getOrdersByDay: ' . $date;
        $this->db->select('id,user_id,bv,quantity,date,package');
        $this->db->where('status !=', 3);
        $this->db->where('date BETWEEN \'' . $date . ' 00:00:01\' AND \'' . $date . ' 23:59:59\'');
        return $query = $this->db->get($this->_table)->result_array();
    }
    
    public function markOrder($id, $status = 1)
    {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        return $this->db->update($this->_table);
    }
    
    public function markAllOrder($status)
    {
        $this->db->set('status', $status);
        return $this->db->update($this->_table);
    }
    
    /**
     * Return all orders with pending status
     * @return array
     */
    public function getNewOrders()
    {
        $this->db->select('id,order_id,user_id,bv,quantity,date,package');
        $this->db->where('status', 0);
        return $this->db->get($this->_table)->result_array();
    }
    
    /**
     * Returns summed yield for requested qualifiing period
     * @param string|null $day day to check in Y-m-d format if null current day will be used
     *  if $day month > 6 than it's january-june period
     *  if $day month < 7 than it's last year july-december period 
     * @return int
     */
    public function getWorldwideYield($day = null)
    {
        //so lets calc depending in what date we have received.
        $date = new DateTime(is_null($day) ? 'now' : $day);
        if (intval($date->format('m')) > 6) {
            $end = $date->format('Y-06-01 23:59:59');
            $start = $date->format('Y-01-01 00:00:01');
        } else {
            $end = (intval($date->format('Y')) - 1) . '-12-01 23:59:59';
            $start = (intval($date->format('Y')) - 1) . '-01-07 00:00:01';
        }

        $this->db->select_sum('bv');
        $this->db->where('date BETWEEN', "{$this->db->escape($start)} AND {$this->db->escape($end)}", false);
        try {
            return $this->db->get($this->_table)->row()->bv;
        } catch (Exception $e) {
            //this can simply mean we have no orders return 0
            return 0;
        }
        
    }
    
}
