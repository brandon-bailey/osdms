<?php

class Search_Model extends CI_Model
{

    public function liveSearch($search)
    {
        $searchString = preg_replace("/[^A-Za-z0-9]/", " ", $search);

        if (strlen($searchString) >= 1 && $searchString !== ' ') {
            if (!$this->session->admin) {
                $this->db->where('owner', $this->session->id);
                $this->db->or_where('department', $this->session->department);
            }
            $this->db->select();
            $this->db->like('realname', $searchString, 'both');
            $this->db->or_like('description', $searchString, 'both');
            $this->db->where('publishable', 1);
            $this->db->limit(10);
            $query = $this->db->get('documents');

            if ($query->num_rows() !== 0) {
                foreach ($query->result() as $row) {
                    $fileDataObj = new Document_Model($row->id);
                    $data[] = array(
                        'id' => $row->id,
                        'realname' => $row->realname,
                        'category' => $fileDataObj->getCategoryName(),
                        'owner' => $fileDataObj->getOwnerName(),
                        'description' => $row->description,
                        'thumbnail' => $fileDataObj->getThumbnail(),
                        'detailsLink' => site_url() . 'details/' . $row->id,
                    );
                }
                echo json_encode($data);
            } else {
                $output = array(
                    'status' => 'error',
                    'msg' => 'No Results Found',
                );

                echo json_encode($output);
            }
        }
    }
}
