<?php

class video_model extends inf_model {

    private $_table = 'video';
    
    /**
     * Video iframe width, note that aspect ratio of 16/9 best to be maintained
     * @var int 
     */
    private $_width = 480;
    /**
     * Video iframe height, note that aspect ratio of 16/9 best to be maintained
     * @var int 
     */
    private $_height = 270;
    
    private $_allowedTags = ['rel', 'controls', 'showinfo'];
    
    public function __construct() {
        parent::__construct();

        if(!$this->db->table_exists($this->_table)) {
            $this->db->query("
CREATE TABLE IF NOT EXISTS `{$this->table_prefix}video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `resolution` varchar(20) NOT NULL,
  `rel` int(1) NOT NULL DEFAULT '0',
  `controls` int(1) NOT NULL DEFAULT '1',
  `showinfo` int(1) NOT NULL DEFAULT '0',
  `on_dashboard` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
"
            );
        }
    }

    /**
     * Return list of video registered to site
     * @return array Array with all videos
     */
    public function getVideos() {
        return $this->db->get($this->_table)->result();
    }
    
    /**
     * Return requested video by id
     * @param int $id
     * @param bool $array Return result as array or object
     * @return object|array
     * @throws Exception On invalid video
     */
    public function getVideo($id, $array = false) {
        if (is_nan($id)) {
            throw new Exception("Invalid video id");
        }
        $query = $this->db->get_where($this->_table, ['id' => $id], 1);
        if ($query->num_rows() == 0) {
            throw new Exception("There is no video with id - " . $id);
        }
        return $array ? $query->row_array() : $query->row();
    }
    
    /**
     * Return video object that represent dashboard video
     * @return object Video object
     */
    public function getDashboardVideo() {
        $video = $this->db->get_where($this->_table, ['on_dashboard' => 1], 1)->row();
        if ($video) {
            $params = [];
            foreach (['rel', 'controls', 'showinfo'] as $param) {
                if (!$video->{$param}) {
                    $params[] = $param . '=0';
                }
            }
            
            $video->src = 'https://www.youtube.com/embed/' . $this->_parseVideoUrl($video->url) . (count($params) > 0 ? ('?' . implode('&amp;', $params)) : '');
            $res = explode('|', $video->resolution);
            //do resolution manipulations
            $video->w = !empty($res[0]) ? intval($res[0]) : $this->_width;
            $video->h = !empty($res[1]) ? intval($res[1]) : $this->_height;
        }
        return $video;
    }
    
    /**
     * Check if supplied url is actually youtube video
     * @param string $url 
     * @return bool
     */
    public function _parseVideoUrl($url) {
        $match = [];
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return $match[1];
        }
        return null;
    }

    protected function allowedTags($arr) {
        // array_filter flag was implemented in php 5.6.0
        // return array_filter($arr, function($a){return in_array($a, $this->_allowedTags);}, ARRAY_FILTER_USE_KEY)
        if (!is_array($arr) || count($arr) < 1) {
            return [];
        }
        $tmp = [];
        foreach ($this->_allowedTags as $tag) {
            if (array_key_exists($tag, $arr)) {
                $tmp[$tag] = !empty($arr[$tag]);
            }
        }
        return $tmp;
    }
    
    /**
     * Registers new video to database
     * @param string $title
     * @param string $url
     * @param bool $active Show this video on dashboard if true will deactivate old video from dashboard
     * @param array $tags
     * @return bool
     */
    public function addVideo($title, $url, $active, $tags = []) {
        if ($active) {
            $this->db->set('on_dashboard', 0)->update($this->_table);
        }
        $arr = array_merge([
            'title' => $title,
            'url' => $url,
            'on_dashboard' => $active ? 1 : 0,
            'resolution' => $this->_width . '|' . $this->_height, // hardcoded for the time being, change if required
        ], $this->allowedTags($tags));
        return $this->db->insert($this->_table, $arr);
    }
    
    /**
     * Update registered video
     * @param int $id Video id
     * @param string $title
     * @param string $url
     * @param bool $active Show this video on dashboard if true will deactivate old video from dashboard
     * @param array $tags
     * @return bool
     */
    public function editVideo($id, $title, $url, $active, $tags = []) {
        if (is_nan($id)) {
            throw new Exception("Invalid video id");
        }
        if ($active) {
            $this->db->set('on_dashboard', 0)->update($this->_table);
        }
        $arr = array_merge([
            'title' => $title,
            'url' => $url,
            'on_dashboard' => $active ? 1 : 0,
            'resolution' => $this->_width . '|' . $this->_height, // hardcoded for the time being, change if required
        ], $this->allowedTags($tags));
        return $this->db->where('id', $id)->update($this->_table, $arr);
    }
    
    /**
     * Removes video
     * @param int $id
     * @throws Exception on Invalid video
     */
    public function removeVideo($id)
    {
        if (is_nan($id)) {
            throw new Exception("Invalid video id");
        }
        $this->db->delete($this->_table, ['id' => $id]);
    }
    
    /**
     * Put selected video to dashboard, it rewrite previous video
     * @param int $id
     * @throws Exception On invalid video
     */
    public function activateVideo($id)
    {
        if (is_nan($id)) {
            throw new Exception("Invalid video id");
        }
        $this->db->set('on_dashboard', 0)->update($this->_table);
        $this->db->where('id', $id)->update($this->_table, ['on_dashboard' => 1]);
    }
    
    /**
     * Removes selected video from dashboard
     * @param int $id
     * @throws Exception On invalid video
     */
    public function deactivateVideo($id)
    {
        if (is_nan($id)) {
            throw new Exception("Invalid video id");
        }
        $this->db->where('id', $id)->update($this->_table, ['on_dashboard' => 0]);
    }
    
}
