<?php
class resourcesModel extends model
{
	/**
     * upload a file.
     * 
     * @access public
     * @return void
     */
    public function upload()
    {
        $file = '';

        $file_temp = fixer::input('post')
                        ->remove('files,labels')
                        ->get();

	    $file_title = $this->loadModel('file')->saveUpload('sharing', 0, $file_temp->extra, $file_temp->acl);
	    $file = $this->dao->select('*')->from(TABLE_FILE)->where('id')->eq(key($file_title))->fetch();
	    unset($file->id);
    }

    /**
     * get file by acl.
     * 
     * @access public
     * @return void
     */
    public function getFilesByACL($acl = '', $orderBy = '', $pager = null, 
        $paramtitle = '', $paramaddedBy = '')
    {
    	if(!$acl) $acl = array(3);
        if (!$orderBy) $orderBy = 'id_desc';

        $paramaddedByIDs = $this->loadModel('user')->getAccountByName($paramaddedBy);

		$files = $this->dao->select('t1.*, t2.roleid')
            ->from(TABLE_FILE)->alias(t1)
            ->leftJoin(TABLE_USER)->alias(t2)
            ->on('t1.addedBy=t2.account')
			->where('t1.acl')->in($acl)
            ->andWhere('t1.deleted')->eq(0)
            ->andWhere('t2.college_id')->eq($this->session->userinfo->collegeid)
            ->beginIF($paramtitle != '')->andWhere('t1.title')->like('%' . $paramtitle . '%')->fi()
            ->andWhere('t1.addedBy')->in($paramaddedByIDs)
            ->orderBy($orderBy)
            ->page($pager)
	    	->fetchAll();

        foreach ($files as &$file) 
        {
            $file->filename = $file->title.$file->extension;
        }

        foreach ($files as $file) 
        {
            $is_first = true;
            $max = count($files);
            for($i = 0; $i < $max; $i++)
            {
                if($files[$i]->filename == $file->filename)
                {
                    if(!$is_first)
                    {
                        unset($files[$i]);
                    }
                    $is_first = false;
                }
            }
        }
	    if($files) return $files;
    }

    /**
     * check the user priv.
     * 
     * @access public
     * @return void
     */
    public function checkPriv($file, $user = 0)
    {
        if(!$user) $user = $this->session->user->account;
        if($file->addedBy == $user or $this->session->userinfo->roleid != 'student') return true;
        else
            return false;
    }
}