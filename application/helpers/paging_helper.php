<?php
	function create_paging_links($numrows, $rowsPerPage, $pageNum, $self)
	{		
		$self .= "page_size=" . $rowsPerPage;
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);
		// print the link to access each page
		//$self = $_SERVER['PHP_SELF'];
		$nav = '';
		if($maxPage <= 9)
		{
			for($page = 1; $page <= $maxPage; $page++)
			{
				if ($page == $pageNum)
				{
					 $nav .= "<a class='paging-number paging-selected' href='javascript:void(0)'><span>$page</span></a>\n";   // no need to create a link to current page
				}
				else
				{	
					$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
				}
			}
		}
		else
		{
			if($pageNum <= 6)
			{
				for($page = 1; $page <= 6; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='javascript:void(0)'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
					}
				}
				$last2 = $maxPage - 1;
				$nav .= "&nbsp;...&nbsp;";
				for($page = $last2; $page <= $maxPage; $page++)
				{
					$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
				}
			}
			else if($maxPage - $pageNum <= 3)
			{
				for($page = 1; $page <= 2; $page++)
				{
					$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
				}
				$nav .= "&nbsp;...&nbsp;";
				for($page = $maxPage-4; $page <= $maxPage; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
					}
				}
			}
			else
			{
				for($page = 1; $page <= 2; $page++)
				{
					$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
				}
				$nav .= "&nbsp;...&nbsp;";
				for($page = $pageNum-1; $page <= $pageNum+1; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
					}
				}
				$nav .= "&nbsp;...&nbsp;";
				$last2 = $maxPage - 1;
				for($page = $last2; $page <= $maxPage; $page++)
				{
					$nav .= "<a class='paging-number' href='$self&page=$page&page_size=$rowsPerPage'><span>$page</span></a>\n";
				}
			}			
			
		}	
		
		// creating previous and next link
		// plus the link to go straight to
		// the first and last page
		
		//echo $pageNum;
		if ($pageNum > 1)
		{
			$page = $pageNum - 1;
			$prev = "<a class='paging-item-image paging-previous' href='$self&page=$page&page_size=$rowsPerPage'></a>\n";
			$first = "<a class='paging-item-image paging-first' href='$self&page=1&page_size=$rowsPerPage'></a>\n";
		} 
		else
		{
			$prev  = '&nbsp;'; // we're on page one, don't print previous link
			$first = '&nbsp;'; // nor the first page link
		}
		
		if ($pageNum < $maxPage)
		{
			$page = $pageNum + 1;
			//echo $page;
			$next = "<a class='paging-item-image paging-next' href='$self&page=$page&page_size=$rowsPerPage'></a>\n";			
			$last = "<a class='paging-item-image paging-last' href='$self&page=$maxPage&page_size=$rowsPerPage'></a>\n";
		} 
		else
		{
			$next = '&nbsp;'; // we're on the last page, don't print next link
			$last = '&nbsp;'; // nor the last page link
		}
				
		$result = $first . $prev . $nav . $next . $last;
        
		return $result;        
	}
	
	function create_paging_links_ajax($numrows, $rowsPerPage, $pageNum, $self)
	{		
		$self .= "&page_size=" . $rowsPerPage;
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);		
		if ($maxPage < 2){			
			return "";
		}		
		// print the link to access each page
		//$self = $_SERVER['PHP_SELF'];
		$nav = '';
		if($maxPage <= 9)
		{
			for($page = 1; $page <= $maxPage; $page++)
			{
				if ($page == $pageNum)
				{
					 $nav .= "<a class='paging-number paging-selected' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";   // no need to create a link to current page
				}
				else
				{	
					$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
				}
			}
		}
		else
		{
			if($pageNum <= 6)
			{
				for($page = 1; $page <= 6; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
					}
				}
				$last2 = $maxPage - 1;
				$nav .= "&nbsp;...&nbsp;";
				for($page = $last2; $page <= $maxPage; $page++)
				{
					$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
				}
			}
			else if($maxPage - $pageNum <= 3)
			{
				for($page = 1; $page <= 2; $page++)
				{
					$nav .= "<a class='paging-number' href='javascript:void(0)'onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
				}
				$nav .= "&nbsp;...&nbsp;";
				for($page = $maxPage-4; $page <= $maxPage; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='javascript:void(0)'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
					}
				}
			}
			else
			{
				for($page = 1; $page <= 2; $page++)
				{
					$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
				}
				$nav .= "&nbsp;...&nbsp;";
				for($page = $pageNum-1; $page <= $pageNum+1; $page++)
				{
					if($page == $pageNum)
					{
						$nav .= "<a class='paging-number paging-selected' href='javascript:void(0)'><span>$page</span></a>\n";
					}
					else
					{
						$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
					}
				}
				$nav .= "&nbsp;...&nbsp;";
				$last2 = $maxPage - 1;
				for($page = $last2; $page <= $maxPage; $page++)
				{
					$nav .= "<a class='paging-number' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'><span>$page</span></a>\n";
				}
			}			
			
		}	
		
		// creating previous and next link
		// plus the link to go straight to
		// the first and last page
		
		//echo $pageNum;
		if ($pageNum > 1)
		{
			$page = $pageNum - 1;
			$prev = "<a class='paging-item-image paging-previous' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'></a>\n";
			$first = "<a class='paging-item-image paging-first' href='javascript:void(0)' onclick='change_paging(\"$self&page=1&page_size=$rowsPerPage\")'></a>\n";
		} 
		else
		{
			$prev  = '&nbsp;'; // we're on page one, don't print previous link
			$first = '&nbsp;'; // nor the first page link
		}
		
		if ($pageNum < $maxPage)
		{
			$page = $pageNum + 1;
			//echo $page;
			$next = "<a class='paging-item-image paging-next' href='javascript:void(0)' onclick='change_paging(\"$self&page=$page&page_size=$rowsPerPage\")'></a>\n";			
			$last = "<a class='paging-item-image paging-last' href='javascript:void(0)' onclick='change_paging(\"$self&page=$maxPage&page_size=$rowsPerPage\")'></a>\n";
		} 
		else
		{
			$next = '&nbsp;'; // we're on the last page, don't print next link
			$last = '&nbsp;'; // nor the last page link
		}
				
		$result = $first . $prev . $nav . $next . $last;
        
		return $result;        
	}
	
	function paging_bar($numrows, $rowsPerPage, $pageNum, $controller, $view, $query = null)
	{
		$CI = &get_instance();
		$total_pages = ceil($numrows / $rowsPerPage);		
		if ($total_pages < 2){
			return "";
		}
		$html = "";		
		if ($total_pages != 0) {
			$paging_link = create_paging_links_ajax($numrows, $rowsPerPage, $pageNum, base_url($controller . $view . "?" . $query));			
			$html = '<div class="input-box paging-bar">
				<span class="right">' . $paging_link . 
				'</span>						
				<span class="page-number right mr12">' . $CI->lang->line('page') .  ' 
					<select id="ddl_page" onchange="change_page(this,\'' . $controller . '\', \'' . $view . '\')">';
						for($i = 1; $i <= $total_pages; $i++){
							$html .= '<option ' . ($pageNum == $i ? "selected='selected'" : "") .'>' . $i . '</option>';
						}					
					$html .= '</select> / ' . $total_pages . '
				</span>
				<span class="right mr2">
					<span>' . $CI->lang->line('num_records_per_page') .  '</span>
					<select id="ddl_page_size" onchange="change_page_size(this,\'' . $controller . '\', \'' . $view . '\')">';
						for ($i = PAGE_SIZE_DEFAULT; $i <= 150; $i += PAGE_SIZE_DEFAULT){
							$html .= '<option ' . ($rowsPerPage == $i ? "selected='selected'" : "") . '>' . $i . '</option>';
						}
					$html .= '</select>
				</span>
				<div class="clear"></div>
			</div>';
		}
		return $html;
	}

	function create_normal_paging_link($numrows, $rowsPerPage, $pageNum, $self, $is_ajax = false)
	{	
		// how many pages we have when using paging?
		$maxPage = ceil($numrows/$rowsPerPage);		
		$result = "";
		if ($maxPage > 1){	
			// print the link to access each page
			//$self = $_SERVER['PHP_SELF'];
			$nav = '';
			if($maxPage <= 9)
			{
				for($page = 1; $page <= $maxPage; $page++)
				{
					if ($page == $pageNum)
					{
						 $nav .= " <strong>$page</strong> ";   // no need to create a link to current page
					}
					else
					{	
						$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
					}
				}
			}
			else
			{
				if($pageNum <= 6)
				{
					for($page = 1; $page <= 6; $page++)
					{
						if($page == $pageNum)
						{
							$nav .= "<strong>$page</strong>";
						}
						else
						{
							$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
						}
					}
					$last2 = $maxPage - 1;
					$nav .= "&nbsp;...&nbsp;";
					for($page = $last2; $page <= $maxPage; $page++)
					{
						$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
					}
				}
				else if($maxPage - $pageNum <= 3)
				{
					for($page = 1; $page <= 2; $page++)
					{
						$nav .= " <a ref='" . $page . "' ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
					}
					$nav .= "&nbsp;...&nbsp;";
					for($page = $maxPage-4; $page <= $maxPage; $page++)
					{
						if($page == $pageNum)
						{
							$nav .= "<strong>$page</strong>";
						}
						else
						{
							$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
						}
					}
				}
				else
				{
					for($page = 1; $page <= 2; $page++)
					{
						$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
					}
					$nav .= "&nbsp;...&nbsp;";
					for($page = $pageNum-1; $page <= $pageNum+1; $page++)
					{
						if($page == $pageNum)
						{
							$nav .= "<strong>$page</strong>";
						}
						else
						{
							$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
						}
					}
					$nav .= "&nbsp;...&nbsp;";
					$last2 = $maxPage - 1;
					for($page = $last2; $page <= $maxPage; $page++)
					{
						$nav .= " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . ">$page</a> ";
					}
				}			
				
			}	
			
			// creating previous and next link
			// plus the link to go straight to
			// the first and last page
		
			
			if ($pageNum > 1)
			{
				$page = $pageNum - 1;
				$prev = " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . "><img align='absmiddle' src='" . base_url('images/previous.png') . "'/></a> ";
				
				$first = " <a ref='" . 1 . "' " . make_normal_paging_link_href($self, 1, $is_ajax) . ">Đầu <img align='absmiddle' src='" . base_url('images/first.png') . "'/></a> ";
			} 
			else
			{
				$prev  = '&nbsp;'; // we're on page one, don't print previous link
				$first = '&nbsp;'; // nor the first page link
			}
			
			if ($pageNum < $maxPage)
			{
				$page = $pageNum + 1;			
				$next = " <a ref='" . $page . "' " . make_normal_paging_link_href($self, $page, $is_ajax) . "><img align='absmiddle' src='" . base_url('images/next.png') . "'/></a> ";
				
				$last = " <a ref='" . $maxPage . "' ". make_normal_paging_link_href($self, $maxPage, $is_ajax) .">Cuối <img align='absmiddle' src='" . base_url('images/last.png') . "'/></a> ";
			} 
			else
			{
				$next = '&nbsp;'; // we're on the last page, don't print next link
				$last = '&nbsp;'; // nor the last page link
			}	
			
			$result = "<div class='pager'><div class='pager-list'>" .
				$first . $prev . $nav . $next . $last . 
				"</div></div>";
		}
		
		return $result;			
	}
	
	function make_normal_paging_link_href($self, $page, $is_ajax = false){
		if ($is_ajax){
			//return $self . ", " . $page . ")";
			return "href='javascript:void(0)' self='" . $self . "'";
		}
		else
		{		
			if (strpos($self, '?'))
				return "href='" . $self . "&page=" . $page . "'";
			else
				return "href='" . $self . "?page=" . $page . "'";
		}
	}
?>