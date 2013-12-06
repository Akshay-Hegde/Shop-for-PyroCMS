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

include_once( dirname(__FILE__) . '/'. 'twoducks_base.php');

class Twoducks_ShippingMethod extends Twoducks_base
{

	public $name =  'Two Ducks Custom Shipping'; 
	public $desc = 'Australia wide - Shipping';
	public $author = 'inspiredgroup.com.au';
	public $website = 'http://inspiredgroup.com.au';
	public $version = '1.0';
	public $image = '';


	public $fields = array(	
		array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'options[shipping_min]',
			'label' => 'Shipping Charge Per Order',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
		array(
			'field' => 'options[shipping_max]',
			'label' => 'Handling',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		),
		array(
			'field' => 'options[handling]',
			'label' => 'Handling',
			'rules' => 'trim|max_length[5]|is_numeric|required'
		)				
	);
	
	
	public function __construct() 
	{
		parent::__construct();
	}

	
	public function form($options) { return $options; }

	public function run($options)  { return $options; }



	public function calc($options, $items, $from_address = array(), $to_address = array() )
	{


		$this->add('Start calc for:' . $this->title);

		$cost = 0;

		$shippable_item_count = 0; //if no shiipable items - return free shpping

		foreach ($items as $item)
		{	

			$shippable_item_count++;


			if( ($item['ignor_shipping']==1) OR ($item['ignor_shipping']=='1') )
			{
				continue;
			}




			//default calculation method
			$func = 'calc_cards';

			switch ($item->user_data) 
			{

				case 'cards':
					$func = 'calc_cards';
					break;

				case 'invitations':
					$func = 'calc_invitations';
					break;	


				case 'invitation-pack':
					$func = 'calc_invitation_pack';
					break;	


				case 'tags':
					$func = 'calc_tags';
					break;


				case 'birth':
					$func = 'calc_birth';
					break;

				case 'personalized-xmas-postcards':
					$func = 'calc_pxmascards';
					break;
					
				case 'name-charts':
					$func = 'calc_name_charts';
					break;


				case 'posters':
					$func = 'calc_posters';
					break;


				case 'flash-cards':
					$func = 'calc_flash_cards';
					break;

					
				case 'calandar':
					$func = 'calc_calandar';
					break;


				case 'prints':
					$func = 'calc_prints';
					break;

				case 'gift-wrap':
					$func = 'calc_gift_wrap';
					break;
					

				case 'free-shipping':
				default:
					break;

			}

			

			//now we have the calc method, go there and calc
			$cost += $this->$func($item);

		}


	
		//
		// trim shipping does 1 of 2 things.
		// It will round up if shipping is too low,
		// or round down if shipping is too high
		//
		$this->trim_shipping($cost, $options, $shippable_item_count);


		//now we add on the framed charts as they do not reuire trimming
		foreach ($items as $item)
		{	
			if($item->user_data == 'name-charts')
			{

				$cost += $this->calc_framed_name_charts($item);
			}

		}

		$this->add_handling_charge($cost,$options);


		$this->add('shippable count: ' .$shippable_item_count);
	 
		return $cost; 

	}





	/**
	 * Trims shipping cost - only call after your shipping calcs
	 * 
	 * @param  [type] $cost [description]
	 * @return [type]       [description]
	 */
	private function trim_shipping(&$cost, $options, $items_count=0)
	{

		if($items_count == 0)
		{
			$cost = 0;
		}
		else
		{

			$handling = $options['handling'];
			$min_shipping = $options['shipping_min'];
			$max_shipping = $options['shipping_max'];


			$this->add( "Before Trim:" . $cost   );

			//
			// Add handling
			//
			//$cost += $handling;

			//check min
			$cost = ($cost < $min_shipping)?  $min_shipping : $cost ;

			if($max_shipping > 0)
			{
				//check max
				$cost =  ($cost > $max_shipping)?  $max_shipping : $cost ; 
			}

			$this->add( "After Trim:" . $cost   );

		}

	}

	private function add_handling_charge(&$cost,$options)
	{
		$handling = $options['handling'];


		if($cost == 0)
		{
			$cost = 0;
		}

		if($cost > 25.00)
		{
			return;
		}
	
		$cost += $handling;
	
	}
	
}
