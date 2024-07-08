<?php
// This class handles different levels of pagination across website (both ajax and normal)
class pagination {
	    
	// Main Pagination Logic
    function simple_pagination_links($totalpages,$totallinks,$selectedpage) 
     {
         $i = 0;
         $arr = array();
         if ($totalpages < $totallinks)
         {
             for( $i=1; $i<=$totalpages; $i++)
             {
                 $arr[] = $i;
             }
         }
         else
         {
            $startindex  = $selectedpage;
            $lowerbound = $startindex - floor($totallinks / 2);
            $upperbound = $startindex + floor($totallinks / 2);
             if ($lowerbound < 1)
             {
                 //calculate the difference and increment the upper bound
                $upperbound = $upperbound + (1 - $lowerbound);
                $lowerbound = 1;
             }
             //if upperbound is greater than total page is
             if ($upperbound > $totalpages)
             {
                //calculate the difference and decrement the lower bound
                $lowerbound = $lowerbound - ($upperbound - $totalpages);
                $upperbound = $totalpages;
             }
             for($i=$lowerbound;$i<=$upperbound;$i++)
             {
                 $arr[] = $i;
             }
           
           
         }
        return $arr;
       
     }
	 
	 // Advance pagination logic
    function advance_pagination_links($totalpages, $selectedpage)
    {
        $i = 0;
        $value = 0;
        $arr = array();
        $lower_arr = array();
        $upper_arr = array();
        
		$indexer = array("4","40","50","400","500","4000","5000","40000","50000");
		$patter = array("1", "1", "1", "4", "40", "50", "400", "500", "4000", "5000", "40000");
        if ($selectedpage == 1)
        {
			// 15 links
			for($i = 1; $i <= 16; $i++)
			{
				if($i <= 7)
				  $value = $i;
				else
  				  $value = $value + $indexer[$i-8];
				if($value > $totalpages)
				   $value = $totalpages;
                if(!in_array($value,$arr))
				  $arr[] = $value;
			}
        }
		
        if ($selectedpage > 1)
        {   
		    if ($totalpages <= 16)
			{
			    for($i = 1; $i <= 16; $i++)
				{
				    $value = $i;
					if($value > $totalpages)
					   $value = $totalpages;
					if(!in_array($value,$arr))
					  $arr[] = $value;
				}
			}
			else
			{
				for ($i = 0; $i <= 7; $i++)
				{	
					if($value == 0)
					   $value = $selectedpage - $patter[$i];			
					else
					   $value = $value - $patter[$i];
					
					if($value > 0)
					{
					   if(!in_array($value,$lower_arr))
					     $lower_arr[] = $value;
					}
					 
				}
				$value = 0;
				for ($i = 0; $i <= 7; $i++)
				{
					if($value == 0)
					   $value = $selectedpage + $patter[$i];			
					else
					   $value = $value + $patter[$i];
					
					if($value > $totalpages)
					  $value = $totalpages;  
					   
					if(!in_array($value,$upper_arr))
					   $upper_arr[] = $value;
				}
				//// add lower array values
				for ($i = 0; $i <= count($lower_arr) - 1; $i++)
				{
					$rev_index = (count($lower_arr) - 1) - $i;
					$arr[] = $lower_arr[$rev_index];
				}
				//// add selected record
				$arr[] = $selectedpage;
				//// add upper array values
				for ($i = 0; $i <= count($upper_arr) - 1; $i++)
				{
					$arr[] = $upper_arr[$i];
				}
			}
        }
        return $arr;
    }
}
?>