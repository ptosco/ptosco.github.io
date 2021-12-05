<?php

/*

##################################################################################
# Advanced TOC Script for CMSimple v2.4 - v2.5 by www.cmsimple-styles.com        #
#--------------------------------------------------------------------------------#
# please do not remove the links on the template!                                #
# if you want to remove them, buy a template license!                            #
# please visit www.cmsimple-styles.com  for more information.                    #
##################################################################################

*/

function advancedtoc($start, $end)
    {
    global $h, $hc, $hl, $s, $l;

    $hcmen = array();
    $hcI = 0; 
    for ($i=0; $i < $hl-1; $i++)
    {
	$hcmem[$hcI++] = $hc[$i];
	if ($hc[$i+1] > $hc[$i] +1 )
	{
	    for ($j=$hc[$i]+1; $j <= $hc[$i+1]; $j++)
	    {
		if  (! (strpos( $h[$j] ,   'ruler:'  ) === false ) 
		     ||  !(strpos( $h[$j] , 'category:'  ) === false )
		     ||  !(strpos( $h[$j] , 'link:'  ) === false )
	         ||  !(strpos( $h[$j] , 'link_blank:'  ) === false )			 		 
			 
			 )
		  $hcmem[$hcI++]=$j;
	    }
	}
    }
    $hcmem[$hcI++] = $hc[count($hc)-1];
    $hlmem=count($hcmem);
    $ta=array();

    if (isset($start) && !isset($end))
        $end=$start;

    if (!isset($end))   $end=3;   if (!isset($start))   $start=1;

    for ($i=0; $i < $hlmem; $i++)
        {

        if ($l[$hcmem[$i]] == 1)
            {
            if ($start == 1)
                $ta[]=$hcmem[$i];

            $r1=$r2=$i;
            }

        if ($s == $hcmem[$i])
            {
            $s3=true;

            for ($j=$r1 + 1; $j < $hlmem; $j++)
                {
                if ($l[$hcmem[$j]] == 1)
                    break;

                if ($l[$hcmem[$j]] == 2)
                    {
                    if ($start < 3 && $end > 1)
                        $ta[]=$hcmem[$j];

                    $r2=$j;
                    $s3=false;
                    }

                if ($s == $hcmem[$j])
                    {
                    for ($k=$r2 + 1; $k < $hlmem; $k++)
                        {
                        if ($l[$hcmem[$k]] == 3)
                            {
                            if ($end > 2)
                                $ta[]=$hcmem[$k];
                            }
                        else
                            {
                            $s3=false;
                            break;
                            }
                        }
                    }

                if ($l[$hcmem[$j]] == 3 && $l[$s] == 1 && $s3)
                    if ($end > 2)
                        $ta[]=$hcmem[$j];
                }
            }
        }

    return wbli($ta, $start, $hcmem, $hlmem);
    }

function aWithClass($i, $x, $clsname)
 {
    global $sn, $u;
	$elip = $x;
	$title = '';	   
	if ( (strpos( $x, 'link:'  ) === false ) && (strpos( $x, 'link_blank:'  ) === false ) ) 
    {
	   if (strlen($x) > 21) {
	     $elip = substr($x,0,20) . '...';	
	     $title = ' Title = "'. $x  .'"';    
	   }
        return '<a onMouseOver="this.className=\''.$clsname.'over\'" onMouseOut="this.className=\''.$clsname.'\'" class="'.
	     $clsname.'" href="' . $sn . '?' . $u[$i].'" ' . $title . '>' .$elip. '</a>' ;
	}
	else
	{
	     list ($item,$url)= split('@',$x); 
		 if (strpos( $x, 'link_blank:'  ) === false )  
         {
		    $item =  str_replace('link:','',$item);
	        if (strlen($item) > 21) {
   	          $title = ' Title = "'. $item  .'"';     
	          $item = substr($item,0,20) . '...';	   
	  
	        }
	        return '<a onMouseOver="this.className=\''.$clsname.'over\'" onMouseOut="this.className=\''.$clsname.'\'" class="'.
	        $clsname.'" href="' . $url. '" ' . $title . '>' .$item. '</a>' ;
		 }
		 else
		 {
		   $item =  str_replace('link_blank:','',$item);
	       if (strlen($item) > 21) {
	         $title = ' Title = "'. $item  .'"';    
	         $item = substr($item,0,20) . '...';	    

	       }
	       return '<a onMouseOver="this.className=\''.$clsname.'over\'" onMouseOut="this.className=\''.$clsname.'\'" class="'.
	       $clsname.'" href="' . $url. '" ' . $title . ' target="_" >' .$item. '</a>' ;
		 } 
	}

}

function wbli($ta, $st, $hc, $hl)

    {

    global $s,  $l, $h;

    if (count($ta) == 0)
        return;

    $t='';
    if ($st == 'submenu' || $st == 'search')
        $t.='<ul class="' . $st . '">';
    $b=0;
    if ($st == 1 || $st == 2 || $st == 3)
        {
        $b=$st - 1;
        $st='menulevel';
        }

    $j    =0;
    $le   =0;
    $lf[0]=$lf[1]=$lf[2]=$lf[3]=false;

    for ($i=0; $i < $hl; $i++)
        {

        if (!isset($ta[$j]))
            break;

        if ($hc[$i] != $ta[$j])
            continue;

        $tf=($s != $ta[$j]);
   
     if ($st == 'menulevel' || $st == 'sitemaplevel')
            {
            for ($k=(isset($ta[$j - 1]) ? $l[$ta[$j - 1]] : $b); $k < $l[$ta[$j]]; $k++)
                $t.='<ul class="' . $st . ($k + 1) . '">';
            }
        $t.='<li class="';

        if (!$tf)
            $t.='s';

        $t.='navitem';

	    $sU = '';

        if (isset($hc[$i + 1]))	
            if ($l[$hc[$i + 1]] > $l[$ta[$j]])  {
                $t.='s';
				$sU='u';
			}

        $t.='">';

  if  (! (strpos( $h[$ta[$j]] ,   'category:'  ) === false )) 
  {
     $t.='<div class="menuspacer">'.str_replace('category:'  , '', $h[$ta[$j]]) .'</div>';
  } 
  else 
  {
    if  (! (strpos( $h[$ta[$j]] ,   'ruler:'  ) === false )) 
    {
        $t.='<div class="menuruler"></div>';
   }
   else
   {	
     $sA = 'i';
      if ($s == $ta[$j])  $sA =  'a';
      if (((isset($ta[$j +1]) ? $l[$ta[$j +1]] : $b) > $l[$ta[$j]]) && ( $l[$s] > $l[$ta[$j]])  )  $sA = 'o';  

      $sN = '' . $l[$ta[$j]];

      $sP = '' ;
      if ((isset($ta[$j -1]) ? $l[$ta[$j -1]] : $b) < $l[$ta[$j]])  $sP = 'b' ;
      if ((isset($ta[$j +1]) ? $l[$ta[$j +1]] : $b) < $l[$ta[$j]]) $sP = 'e' ;

      $sStyleName = $sU.$sA.$sN.$sP; 
  	  
      $t.=aWithClass($ta[$j], $h[$ta[$j]] ,$sStyleName );
     }
 }

        if ($st == 'menulevel' || $st == 'sitemaplevel')
            {
            if ((isset($ta[$j + 1]) ? $l[$ta[$j + 1]] : $b) > $l[$ta[$j]])
                $lf[$l[$ta[$j]]]=true;
            else
                {
                $t.='</li>';
                $lf[$l[$ta[$j]]]=false;
                }

            for ($k=$l[$ta[$j]]; $k > (isset($ta[$j + 1]) ? $l[$ta[$j + 1]] : $b); $k--)
                {
                $t.='</ul>';

                if ($lf[$k - 1])
                    {
                    $t.='</li>';
                    $lf[$k - 1]=false;
                    }
                }

            ;
            }
        else
            $t.='</li>';
        $j++;
        }

    if ($st == 'submenu' || $st == 'search')
        $t.='</ul>';
    return $t;
    }
?>
