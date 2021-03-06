<?php
 
class User_Perms_Model extends CI_Model
{
    public $fid;
    public $rights;
    public $deptPermsObj;
    public $fileObj;
    public $error;
    public $chosenMode;
    public $fileData;
 
    public $USER_MODE = 0;
    public $FILE_MODE = 1;

    /**
         * @param int $id
         * @param PDO $connection
         */
    public function __construct($doc = null)
    {
        if ($doc !== null) {
            $this->setDocumentObj($doc);
        }
        $this->deptPermsObj = new Dept_Perms_Model($this->session->department);
    }
        
    public function setDocumentObj($doc)
    {
        $this->fileData = new Document_Model($doc);
    }

    /**
         * return an array of user whose permission is >= view_right
         * @param bool $limit
         * @return array
         */
    public function getCurrentViewOnly($limit = true, $offset = null)
    {
        return $this->loadDataUserPerm($this->config->item('VIEW_RIGHT'), $limit, $offset);
    }

    /**
         * return an array of user whose permission is >= none_right
         * @param bool $limit
         * @return array
         */
    public function getCurrentNoneRight($limit = true, $offset = null)
    {
        return $this->loadDataUserPerm($this->config->item('NONE_RIGHT'), $limit, $offset);
    }

    /**
         * return an array of user whose permission is >= read_right
         * @param bool $limit
         * @return array
         */
    public function getCurrentReadRight($limit = true, $offset = null)
    {
        return $this->loadDataUserPerm($this->config->item('READ_RIGHT'), $limit, $offset);
    }

    /**
         * return an array of user whose permission is >= write_right
         * @param bool $limit
         * @return array
         */
    public function getCurrentWriteRight($limit = true, $offset = null)
    {
        return $this->loadDataUserPerm($this->config->item('WRITE_RIGHT'), $limit, $offset);
    }

    /**
         * return an array of user whose permission is >= admin_right
         * @param bool $limit
         * @return array
         */
    public function getCurrentAdminRight($limit = true, $offset = null)
    {
        return $this->loadDataUserPerm($this->config->item('ADMIN_RIGHT'), $limit, $offset);
    }

    /**
         * All of the functions above provide an abstraction for loadDataUserPerm($right).
         * If your user does not want to or does not know the numeric value for permission,
         * use the function above.  LoadData_UserPerm($right) can be invoke directly.
         * @param integer $right The "Right" that is being checked.
         * @param integer $right The permissions level you are checking for
         * @param boolean $limit boolean Should we limit the query to max_query size?
         * @return array
         */
    public function loadDataUserPerm($right, $limit = null, $offset = null)
    {
            
        if ($this->session->admin) {
            $this->db->select('id');
            $this->db->limit($limit);
            $this->db->offset($offset);
            $this->db->where('publishable', 1);
            $result = $this->db->get('documents');
        } elseif ($this->userObj->isReviewer()) {
            if ($offset !== null) {
                $offset = 'OFFSET ' . $offset;
            } else {
                $offset = '';
            }
            if ($limit !== null) {
                $limit = 'LIMIT ' . $limit;
            } else {
                $limit = '';
            }
                // If they are a reviewer, let them see files in all departments they are a reviewer for
                
                $result = $this->db->query("SELECT d.id
                        FROM
                            " . $this->db->dbprefix('documents') ." as d,
                           ". $this->db->dbprefix('dept_reviewer'). " as dr
                        WHERE (
                            d.publishable = 1 
                        AND
                            dr.dept_id = d.department
                        AND
                            dr.user_id = {$this->session->id}   )                       
					{$limit} {$offset}");

        } else {
            if ($offset !== null) {
                $offset = 'OFFSET ' . $offset;
            } else {
                $offset = '';
            }
            if ($limit !== null) {
                $limit = 'LIMIT ' . $limit;
            } else {
                $limit = '';
            }
                $result = $this->db->query("
                  SELECT
                    up.fid as id
                  FROM
                    ". $this->db->dbprefix('documents')." as d,
                   ".$this->db->dbprefix('user_perms') ." as up
                  WHERE (
            up.uid = {$this->session->id}
                    AND
                    d.id = up.fid
                    AND
            up.rights >= {$right}
                    AND
                    d.publishable = 1)
			{$limit} {$offset}");
        }
           
        if ($result->num_rows() > 0) {
            return $result->result_array();
        }
                
        return false;
    }

    /**
         * return whether if this user can view $dataId
         * @param int $dataId
         * @return bool
         */
    public function canView($dataId)
    {
        if (!$this->isForbidden($dataId)) {
            if ($this->canUser($dataId, $this->config->item('VIEW_RIGHT')) or
                $this->deptPermsObj->canView($dataId) or $this->canAdmin($dataId)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
         * return whether if this user can read $dataId
         * @param $dataId
         * @return bool
         */
    public function canRead($dataId)
    {
        if (!$this->isForbidden($dataId)) {
            if ($this->canUser($dataId, $this->config->item('READ_RIGHT')) or
             $this->deptPermsObj->canRead($dataId) or $this->canAdmin($dataId)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
         * return whether if this user can modify $dataId
         * @param $dataId
         * @return bool
         */
    public function canWrite($dataId)
    {
        if (!$this->isForbidden($dataId)) {
            if ($this->canUser($dataId, $this->config->item('WRITE_RIGHT')) or
             $this->deptPermsObj->canWrite($dataId) or $this->canAdmin($dataId)) {
                return true;
            } else {
                false;
            }
        }

    }

    /**
         * return whether if this user can admin $dataId
         * @param $dataId
         * @return bool
         */
    public function canAdmin($dataId)
    {
        if (!$this->isForbidden($dataId)) {
            if ($this->canUser($dataId, $this->config->item('ADMIN_RIGHT')) or
             $this->deptPermsObj->canAdmin($dataId) or $this->fileData->isOwner($this->session->id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
         * return whether if this user is forbidden to have acc
         * @param $dataId
         * @return bool
         */
    public function isForbidden($dataId)
    {
        $this->db->select('rights');
        $this->db->where('uid', $this->session->id);
        $query = $this->db->get('user_perms');

        if ($query->num_rows() == 1) {
            list ($right) = $query->result_array();
                
            if ($right == $this->config->item('FORBIDDEN_RIGHT')) {
                return true;
            } else {
                return false;
            }
        }
    }
        
    /**
         * This function is used by all the canRead, canView, etc... abstract functions.
         * Users may invoke this function directly if they are familiar of the numeric permision values.
         * If they are an "Admin" or "Reviewer" for this file return true right away
         * @param integer $dataId The ID number of the file in question
         * @param integer $right The number of the "right" ID that is being checked
         * @return true They CAN perform the right
         */
    public function canUser($dataId, $right)
    {
        if ($this->session->admin or $this->userObj->isReviewerForFile($dataId)) {
            return true;
        }
            
        $this->db->select();
        $this->db->where('uid', $this->session->id);
        $this->db->where('fid', $dataId);
        $this->db->where('rights', $rights);
        $query = $this->db->get('user_perms');

        switch ($query->num_rows()) {
            case 1:
                return true;
                break;
            case 0:
                return false;
                break;
            default:
                $this->error = "non-unique uid: {$this->session->id}";
                break;
        }
    }

    /**
         * return this user's permission on the file $dataId
         * @param int $dataId
         * @return int|string
         */
    public function getPermission($dataId)
    {
        if ($this->config->item('root_id') == $this->session->id) {
            return 4;
        }
            $this->db->select('rights');
            $this->db->where('uid', $this->session->id);
            $this->db->where('fid', $dataId);
            $query = $this->db->get('user_perms');
        

        if ($query->num_rows() == 1) {
            return $query->result_array();
        } elseif ($query->num_rows() == 0) {
            return -999;
        }
    }

    /**
         * @param int $userId
         * @param int $dataId
         * @return string
         */
    public function getPermissionForUser($userId, $dataId)
    {
        $this->db->select('rights');
        $this->db->where('uid', $userId);
        $this->db->where('fid', $dataId);
        $query = $this->db->get('user_perms');
        return $query;
    }
}
