<?php

class Gallery_model extends Master_model
{

    public function __construct()
    {
        parent::__construct();
        $this->table = 'gallery';
    }

    public function getGalleries()
    {
        return $this->db->get('gallery')->result();
    }

    public function getImages($gal_id, $limit = false)
    {
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get_where('images', array('gallery_id' => $gal_id))->result();
    }

    public function typesImage($ty)
    {
        return  $this->db->order_by('id', 'DESC')->get_where('ai_media', array('type_img' => $ty))->result();
    }
}
