<?php

class Content_m extends CI_Model {
	public function __construct() {
        parent::__construct();
		$this->load->library('Db_trans');
    }
	
	function get_category($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('post_categories');
		
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('category');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_category_by_id($id){
		$this->db->select('*');
		$this->db->from('post_categories');
		$this->db->where('id', $id);
		$this->db->order_by('category');

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_root_category($category_part){
		$this->db->select('*');
		$this->db->from('post_categories');
		$this->db->where('parent_id', '0');
		$this->db->where('category_part', $category_part);
		$this->db->order_by('category');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_categories_under_root($root_id){
		$query = $this->db->query(
				'select  id,
				        category,
				        slug,
				        parent_id 
				from    (select * from post_categories
				         order by parent_id, id) base,
				        (select @pv := "'.$root_id.'") tmp
				where   find_in_set(parent_id, @pv) > 0
				and     @pv := concat(@pv, ",", id)'
			);

		// print_r($this->db->last_query());

		return $this->db_trans->return_select($query);
	}

	function get_mapped_post_categories($post_id){
		$this->db->select('a.*, b.category, b.slug');
		$this->db->from('post_categories_mapping a');
		$this->db->join('post_categories b', 'a.category_id = b.id');
		$this->db->where('a.post_id', $post_id);
		$this->db->order_by('a.id desc');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
	
	function get_post_data($filter_array, $limit="all"){
		$this->db->select('a.*, b.category as category_name, b.slug, first_name, last_name, m.file_name');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id', 'left');
		$this->db->join('users c', 'a.author = c.user_id', 'left');
		$this->db->join('media_files m', 'a.primary_image=m.id', 'left');
		$this->db->where($filter_array);
		$this->db->order_by('id desc');
		if($limit<>"all")
			$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_product_detail_by_post_id($post_id){
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('post_id', $post_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_post_image($media_id){
		$this->db->select('*');
		$this->db->from('media_files');
		$this->db->where('id', $media_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_post_additional_images($post_id){
		$this->db->select('a.*, b.file_name');
		$this->db->from('post_media a');
		$this->db->join('media_files b', 'a.media_id=b.id');
		$this->db->where('a.post_id', $post_id);
		$this->db->order_by('a.entry_datetime desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_category_data($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('post_categories');
		
		if($filter_by <> null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('parent_id, category');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_all_options(){
		$query = $this->db->get('options');

		return $this->db_trans->return_select($query);
	}

	function get_option_by_param($param){
		$this->db->select('*');
		$this->db->from('options');
		$this->db->where('parameter_name', $param);
		$query = $this->db->get();

		return $this->db_trans->return_select_first_row($query);
	}

	function get_option_by_group($group){
		$this->db->select('*');
		$this->db->from('options');
		$this->db->where('parameter_group', $group);
		$this->db->order_by('id');
		$query = $this->db->get();

		return $this->db_trans->return_select($query);
	}

	function get_post_by_root_category($slug, $limit_start=null, $limit_end=null){ // khusus product
		$this->db->select('a.*, b.category as category_name, b.slug');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id');
		$this->db->where('b.slug', $slug);
		$this->db->order_by('a.id desc');
		if($limit_start<>null)
			$this->db->limit($limit_end, $limit_start);

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);	
	}
	
	function get_root_category_by_post_id($post_id){
		$this->db->select('c.slug');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id');
		$this->db->join('post_categories c', 'b.parent_id=c.id');
		$this->db->where('a.id', $post_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_product_category_noroot(){
		$this->db->select('*');
		$this->db->from('post_categories');
		$this->db->where('category_part', 'product');
		$this->db->where('parent_id <>', '0');
		$this->db->order_by('category');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_rte_category_only_product_exist(){
		$query = $this->db->query('select pc.* from post_categories pc
				join post_categories pcb on pc.parent_id=pcb.id
				where pcb.slug = "ready-to-eat" and pc.id in (select distinct category from posts p)');

		return $this->db_trans->return_select($query);
	}

	function count_post_category_slug($slug){
		$this->db->select('count(*) as total_post', 'false');
		$this->db->from('posts p');
		$this->db->join('post_categories pc', 'p.category=pc.id');
		$this->db->where('type', 'post');
		$this->db->where('slug', $slug);

		$query = $this->db->get();

		return $query->row()->total_post;
	}

	function get_post_category_slug($slug, $limit_start=0, $limit_end=10){ // post umum
		$this->db->select('p.*, pc.category as category_name, pc.slug, m.file_name, c.first_name, c.last_name');
		$this->db->from('posts p');
		$this->db->join('post_categories pc', 'p.category=pc.id');
		$this->db->join('users c', 'p.author = c.user_id', 'left');
		$this->db->join('media_files m', 'p.primary_image=m.id', 'left');
		$this->db->where('type', 'post');
		$this->db->where('slug', $slug);
		$this->db->order_by('creation_datetime desc');
		$this->db->limit($limit_end, $limit_start);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query;
		else
			return false;
	}

	function grouping_blog_month(){
		$query = $this->db->query("select date_format(creation_datetime, '%M %Y') as group_date, count(*) as count from posts
					where type='post' 
					group by date_format(creation_datetime, '%M %Y')");

		if($query->num_rows() > 0)
			return $query->result();
		else
			return false;
	}

	function get_page_by_url($url){
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('url', $url);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return $query->row();
		else
			return false;
	}

	function get_media($filter_by=null, $filter_value=null){
		$this->db->select('*');
		$this->db->from('media_files');
		if($filter_by<>null)
			$this->db->where('id', $media_id);
		$this->db->order_by('id desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function check_media_in_post($media_id){
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('primary_image', $media_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	function check_media_in_post_media($media_id){
		$this->db->select('*');
		$this->db->from('post_media');
		$this->db->where('media_id', $media_id);

		$query = $this->db->get();

		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}

	function get_coupons($filter_by=null, $filter_value=null){
		$this->db->select('cc.*, (select count(0) from orders o where o.coupon_taken=cc.coupon_code) as taker_count');
		$this->db->from('coupon_codes cc');
		if($filter_by<>null)
			$this->db->where($filter_by, $filter_value);
		$this->db->order_by('start_time desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_mapped_categories_under_root($slug){
		$this->db->select('pc.id, pc.category, pc.slug, count(0) as total_category');
		$this->db->from('posts p');
		$this->db->join('post_categories_mapping pcm', 'p.id = pcm.post_id');
		$this->db->join('post_categories pc', 'pcm.category_id = pc.id');
		$this->db->join('post_categories pc_pc', 'p.category = pc_pc.id');
		$this->db->where('pc_pc.slug', $slug);
		$this->db->group_by('pc.id');
		$this->db->order_by('pc.category');

		$query = $this->db->get();
		// print_r($this->db->last_query());
		
		return $this->db_trans->return_select($query);
	}

	function get_keyword_result($keyword){ // khusus product
		// compile keyword as string
		$words = explode(' ', $keyword);
		$key_string = '';
		foreach($words as $word)
			$key_string .= 'title like "%'.$word.'%" or ';

		$key_string = rtrim($key_string, ' or ');

		$this->db->select('a.*, b.category as category_name, b.slug');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id');
		$this->db->where('type', 'product');
		$this->db->where($key_string);
		$this->db->order_by('a.id desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);	
	}

	function get_comments_of_post($post_id){
		$this->db->select('*');
		$this->db->from('post_comments pc');
		$this->db->join('users u', 'pc.user_id = u.user_id');
		$this->db->where('pc.post_id', $post_id);
		$this->db->order_by('pc.entry_timestamp desc');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);	
	}

	function get_post_data_limited($type, $limit_start, $limit_end){
		$this->db->select('a.*, b.category as category_name, b.slug, first_name, last_name');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id', 'left');
		$this->db->join('users c', 'a.author = c.user_id', 'left');
		$this->db->where('type', $type);
		$this->db->order_by('id desc');
		$this->db->limit($limit_end, $limit_start);
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_product_marked_as_banner($marking, $value){
		$this->db->select('a.*, b.category as category_name, b.slug, first_name, last_name');
		$this->db->from('posts a');
		$this->db->join('post_categories b', 'a.category=b.id', 'left');
		$this->db->join('users c', 'a.author = c.user_id', 'left');
		$this->db->join('products pr', 'a.id = pr.post_id');
		$this->db->where($marking, $value);
		$this->db->order_by('id desc');
		
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_email_distribution($filter=null){
		$this->db->select('*');
		$this->db->from('email_distributions');
		
		if($filter_by <> null)
			$this->db->where($filter);
		$this->db->order_by('category');
		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_faq_categories(){
		$this->db->select('pcb.*');
		$this->db->from('post_categories pca');
		$this->db->join('post_categories pcb', 'pca.id = pcb.parent_id');
		$this->db->where('pca.slug', 'faq');
		$this->db->order_by('pcb.id');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_faq_posts($lang=null){
		$this->db->select('p.*, pc.*, pc.category as category_name, p.id as post_id');
		$this->db->from('posts p');
		$this->db->join('post_categories pc', 'p.category = pc.id');
		$this->db->where('p.type', 'faq');
		// $this->db->select('pcb.*, p.*, p.id as post_id, pcb.id as category_id, pcb.category as category_name');
		// $this->db->from('post_categories pca');
		// $this->db->join('post_categories pcb', 'pca.id = pcb.parent_id');
		// $this->db->join('posts p', 'pcb.id = p.category');
		// $this->db->where('pca.slug', 'faq');
		if($lang<>null)
			$this->db->where('p.lang_id', $lang);
		$this->db->order_by('pc.id, p.list_order');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_messages_contact(){
		$this->db->order_by('entry_date desc');
		$query = $this->db->get('contact_form_messages');

		return $this->db_trans->return_select($query);
	}

	function get_menu_by_part($part)
	{
		$this->db->select('*');
		$this->db->from('appearance_menu');
		$this->db->where('menu_part', $part);
		$this->db->order_by('parent_id, ordinal');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_parent_menu($part)
	{
		$this->db->select('*');
		$this->db->from('appearance_menu');
		$this->db->where('menu_part', $part);
		$this->db->where('level', '0');
		$this->db->order_by('ordinal');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_child_menu($part, $parent_id, $level)
	{
		$this->db->select('*');
		$this->db->from('appearance_menu');
		$this->db->where('menu_part', $part);
		$this->db->where('level', $level);
		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('ordinal');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_menu_by_id($id)
	{
		$this->db->select('*');
		$this->db->from('appearance_menu');
		$this->db->where('id', $id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function check_menu_has_child($id)
	{
		$this->db->select('*');
		$this->db->from('appearance_menu');
		$this->db->where('parent_id', $id);

		$query = $this->db->get();

		return $query->num_rows();
	}

	function get_top_navigator_by_user_level($user_level){
		$this->db->select('*')
		 		 ->from('navigators')
		 		 ->where('user_level', $user_level)
		 		 ->where('parent_menu', '*')
		 		 ->where('menu_id <>', '*')
		 		 ->order_by('ordinal');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function check_navigator_has_child($menu_id, $user_level){
		$this->db->select('*')
		 		 ->from('navigators')
		 		 ->where('user_level', $user_level)
		 		 ->where('parent_menu', $menu_id)
		 		 ->where('menu_id <>', '*')
		 		 ->order_by('ordinal');

		$query = $this->db->get();
		
		return $query->num_rows();
	}

	function get_child_navigator($menu_id, $user_level){
		$this->db->select('*')
		 		 ->from('navigators')
		 		 ->where('user_level', $user_level)
		 		 ->where('parent_menu', $menu_id)
		 		 ->order_by('ordinal');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}

	function get_parent_navigator($child_menu_id, $user_level){
		$this->db->select('b.*')
		 		 ->from('navigators a')
		 		 ->join('navigators b', 'a.parent_menu = b.menu_id')
		 		 ->where('a.user_level', $user_level)
		 		 ->where('a.menu_id', $child_menu_id);

		$query = $this->db->get();
		
		return $this->db_trans->return_select_first_row($query);
	}

	function get_email_templates($filter_array=null){
		$this->db->select('*');
		$this->db->from('email_templates');
		if($filter_array<>null)
			$this->db->where($filter_array);
		$this->db->order_by('title');

		$query = $this->db->get();
		
		return $this->db_trans->return_select($query);
	}
}