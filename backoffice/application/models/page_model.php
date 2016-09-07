<?php

class page_model extends inf_model
{
     private $page;
     private $pages;
    private $limit;
    private $URL;
    
	 function __construct()
	  {
	    parent::__construct();
          
	  }
	
	
     public function paging($page,$limit,$numrows)
    {

       
        $this->page=$page;
        $this->limit=$limit;
         $this->URL=$url;
         if (!($this->limit))
         {
            $this->limit = 25;
         } // Default results per-page.
        if (!($this->page))
         {
            $this->page = 0;
         } // Default page value.
       // echo "#############".$numrows;
        $this->pages = intval($numrows/$this->limit); // Number of results pages.
        // $this->pages now contains int of pages, unless there is a remainder from division.
        if ($numrows%$this->limit)
         {
            $this->pages++;
         } // has remainder so add one page
        $current = ($this->page/$this->limit) + 1; // Current page number.
        if (($this->pages < 1) || ($this->pages == 0))
         {
            $total = 1;
         } // If $this->pages is less than one or equal to 0, total pages is 1.
        else
         {
            $total = $this->pages;
         }
       
        return $this->page + 1;
       
    }

       
       public function setFooter($page,$limit,$current_url)

       {
           $footer="";
	   //echo "<script>alert('$page,$limit')</script>";  
           $this->page=$page;
           
        $this->limit=$limit;
            if ($this->page != 0)
             { // Don't show back link if current page is first page.
                $back_page = $this->page - $this->limit;
                $footer.="<a href='".$current_url."/from:".$back_page."/limit:".$this->limit."'> <font color='#FF0000'><b> << prev </b></font> </a> \n";
             }

            for ($i=1; $i <= $this->pages; $i++) // loop through each page and give link to it.
             {
                //echo $this->page;
                $ppage = $this->limit*($i - 1);
                $current_page = $this->page/$this->limit + 1;
 		if ($ppage == $this->page)
 		 {
                    $footer.=("<b>$i</b> \n");
		 } // If current page don't give link, just text.
		else if($i == 1 or $i == 2 or $i == $this->pages or $i == $this->pages-1)
                      {
                        $footer.="<a href='".$current_url."/from:".$ppage."/limit:".$this->limit."'>".$i."</a> \n";
		      }
		else if(($i >= $current_page-7) AND $i <= $current_page+7)
		      {
 			$footer.="<a href='".$current_url."/from:".$ppage."/limit:".$this->limit."'>".$i."</a>  \n";
 		      }
             }
            if (!((($this->page+$this->limit) / $this->limit) >= $this->pages) && $this->pages != 1)
             { // If last page don't give next link.
                $next_page = $this->page + $this->limit;
                $footer.="<a href='".$current_url."/from:".$next_page."/limit:".$this->limit."'> <font color='#FF0000'><b>next>></b></font></a>";
	     }
             $footer.= "</td>
                        </tr>
                        <tr>
                        <td colspan='2' align='right'>
                        Results per-page: <a href='".$current_url."/from:".$page."/limit:25'>25</a> |
                        <a href='".$current_url."/from:0/limit:50'>50</a> |
                        <a href='".$current_url."/from:0/limit:100'>100</a> |
                        <a href='".$current_url."/from:0/limit:200'>200</a>
                        </td>
                        </tr>";
          //return $footer;
         return  $footer;
       }
}