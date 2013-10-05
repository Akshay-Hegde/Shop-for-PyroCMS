<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
/*
 * SHOP for PyroCMS
 * 
 * Copyright (c) 2013, Salvatore Bordonaro
 * All rights reserved.
 *
 * Author: Salvatore Bordonaro
 * Version: 1.0.0.051
 *
 *
 *
 * 
 * See Full license details on the License.txt file
 */
 
/**
 * SHOP			A full featured shopping cart system for PyroCMS
 *
 * @author		Salvatore Bordonaro
 * @version		1.0.0.051
 * @website		http://www.inspiredgroup.com.au/
 * @system		PyroCMS 2.1.x
 *
 */
class Categories extends Public_Controller 
{

	public function __construct() 
	{
		parent::__construct();
		
		// Retrieve some core settings
		$this->use_css =  Settings::get('nc_css');
		$this->shop_title = Settings::get('ss_name');		//Get the shop name
		$this->shopsubtitle = Settings::get('ss_slogan');		//Get the shop subtitle
		$this->limit = Settings::get('ss_qty_perpage_limit');
		
		// NC Markup theme
		$this->nc_page_layout = Settings::get('nc_markup_theme'); /*standard or legacy*/
		$this->nc_page_layout_path = 'categories/'.$this->nc_page_layout.'/categories';		

		
		// Load required classes
		$this->load->model('products_front_m');
		$this->load->model('categories_m');
		
		// Apply default CSS if required
		if ($this->use_css) _setCSS($this->template);
		
	}

	/**
	 * Display  a list of all categories
	 * 
	 * @param  integer $offset [description]
	 * @return [type]          [description]
	 */
	public function index($offset =0, $limit = 6) 
	{

		$data->categories = $this->categories_m
							->limit($limit)
							->offset($offset)
							->get_all($limit);
				

		$data->pagination = create_pagination('shop', $this->categories_m->count_all(), $limit, 2);
		$data->shop_title = $this->shop_title;
		
		//
		// Pass the layout name as views may require it for includes
		//
		$data->nc_layout =  $this->nc_page_layout;
		
		
		$this->template
			->set_breadcrumb($this->shop_title)
			->title($this->module_details['name'])
			->build($this->nc_page_layout_path, $data);



	
	}
	

   /**
	* List all products by a category
	*
	*
	*/
	public function category( $category = 0, $offset = 0, $limit = 6 ) 
	{
	
		//initialize
		$data = (object) array();

		//id or slug
		$field = ( is_numeric($category) ) ? 'id' : 'slug' ;
		
		// get the category
		$category = $this->pyrocache->model( 'categories_m', 'get_by', array($field , $category) );
	
		//if the category exist
		if($category)
		{

			$filter['category_id'] = $category->id;

			// Count the items
			$total_items = $this->products_front_m->count_by_filter($filter);

			//Get the items for the display
			$data->items = $this->products_front_m->shop_filter($filter, $limit, $offset);		

			//build the uri path
			$uri = base_url() . 'shop/category/' . $category->slug;
			//$uri2 =  'shop/category/' . $category->slug ;

			//$data->pagination = create_pagination( $uri2, $total_items, $limit, 4);
			$data->pagination2 = nc_pagination( $uri , $total_items, $limit);

		}
		else
		{
			$data->items = NULL;
			
		}

		
		$this->build_page($data);

	}



	private function build_page($data)
	{

		// Pass the layout name as views may require it for includes
		$data->nc_layout =  $this->nc_page_layout;
		
		
		$this->template
			->title($this->module_details['name'].' |' .lang('products'))
			->set_breadcrumb($this->shop_title)
			->build('products/'.$this->nc_page_layout.'/products', $data);
	}



}