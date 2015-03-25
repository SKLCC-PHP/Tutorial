
<?php
class groupModel extends model
{
    /**
     * Create a group.
     * 
     * @access public
     * @return bool
     */
    public function create()
    {
        $group = fixer::input('post')->specialChars('name, desc')->get();
        $group->rank = $this->post->rank;
        return $this->dao->insert(TABLE_GROUP)->data($group)->batchCheck($this->config->group->create->requiredFields, 'notempty')->exec();
    }

    /**
     * Update a group.
     * 
     * @param  int    $role_name 
     * @access public
     * @return void
     */
    public function update($role_name)
    {
        $group = fixer::input('post')->specialChars('name, desc')->get();
        return $this->dao->update(TABLE_GROUP)->data($group)->batchCheck($this->config->group->edit->requiredFields, 'notempty')->where('role')->eq($role_name)->exec();
    }

    /**
     * Copy a group.
     * 
     * @param  int    $role_name 
     * @access public
     * @return void
     */
    public function copy($role_name)
    {
        $group = fixer::input('post')->specialChars('name, desc')->remove('options')->get();
        $this->dao->insert(TABLE_GROUP)->data($group)->check('name', 'unique')->check('name', 'notempty')->exec();
        if($this->post->options == false) return;
        if(!dao::isError())
        {
            $new_role_name = $this->post->role;
            $options    = join(',', $this->post->options);
            if(strpos($options, 'copyPriv') !== false) $this->copyPriv($role_name, $new_role_name);
            if(strpos($options, 'copyUser') !== false) $this->copyUser($role_name, $new_role_name);
        }
    }

    /**
     * Copy privileges.
     * 
     * @param  string    $fromGroup 
     * @param  string    $toGroup 
     * @access public
     * @return void
     */
    public function copyPriv($fromGroup, $toGroup)
    {
        $privs = $this->dao->findByGroup($fromGroup)->from(TABLE_GROUPPRIV)->fetchAll();
        foreach($privs as $priv)
        {
            $priv->group = $toGroup;
            $this->dao->insert(TABLE_GROUPPRIV)->data($priv)->exec();
        }
    }

    /**
     * Copy user.
     * 
     * @param  string    $fromGroup 
     * @param  string    $toGroup 
     * @access public
     * @return void
     */
    public function copyUser($fromGroup, $toGroup)
    {
        $users = $this->dao->findByGroup($fromGroup)->from(TABLE_USER)->fetchAll();
        foreach($users as $user)
        {
            $user->group = $toGroup;
            $this->dao->insert(TABLE_USER)->data($user)->exec();
        }
    }

    /**
     * @author iat
     * @date 20140829
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_GROUP)->where('status')->eq(1)->orderBy('id')->fetchAll();
    }

    /**
     * Get group pairs.
     * 
     * @access public
     * @return array
     */
    public function getPairs()
    {
        return $this->dao->select('id, name')->from(TABLE_GROUP)->fetchPairs();
    }

    /**
     * Get group by id.
     * 
     * @param  int    $role_name 
     * @access public
     * @return object
     */
    public function getByID($role_name)
    {
        return $this->dao->select('*')->from(TABLE_GROUP)
                    ->where('role')->eq($role_name)
                    ->fetch();
    }

    /**
     * Get group by account.
     * 
     * @param  string    $account 
     * @access public
     * @return array
     */
    public function getByAccount($account)
    {
        return $this->dao->select('t2.*')->from(TABLE_USER)->alias('t1')
            ->leftJoin(TABLE_GROUP)->alias('t2')
            ->on('t1.roleid = t2.role')
            ->where('t1.account')->eq($account)
            ->fetchAll('role');
    }

    /**
     * Get privileges of a groups.
     * 
     * @param  int    $role_name 
     * @access public
     * @return array
     */
    public function getPrivs($role_name)
    {
        $privs = array();
        $stmt  = $this->dao->select('module, method')->from(TABLE_GROUPPRIV)->where('`group`')->eq($role_name)->orderBy('module')->query();
        while($priv = $stmt->fetch()) $privs[$priv->module][$priv->method] = $priv->method;
        return $privs;
    }

    /**
     * Get user pairs of a group.
     * 
     * @param  int    $role_name 
     * @access public
     * @return array
     */
    public function getUserPairs($role_id)
    {
        return $this->dao->select('account, realname')
            ->from(TABLE_USER)
            ->where('roleid')->eq($role_id)
            ->andWhere('deleted')->eq(0)
            ->andWhere('college_id')->eq($this->session->userinfo->collegeid)
            ->orderBy('account')
            ->fetchPairs();
    }

    /**
     * Delete a group.
     * 
     * @param  int    $role_name 
     * @param  null   $null      compatible with that of model::delete()
     * @access public
     * @return void
     */
    public function delete($role_name, $null = null)
    {
        $this->dao->delete()->from(TABLE_GROUP)->where('role')->eq($role_name)->exec();
        $this->dao->delete()->from(TABLE_GROUPPRIV)->where('`group`')->eq($role_name)->exec();
    }

    /**
     * Update privilege of a group.
     * 
     * @param  int    $role_name 
     * @access public
     * @return bool
     */
    public function updatePrivByGroup($role_name, $menu, $version)
    {
        /* Set priv when have version. */
        if($version)
        {
            $noCheckeds = trim($this->post->noChecked, ',');
            if($noCheckeds)
            {
                $noCheckeds = explode(',', $noCheckeds);
                foreach($noCheckeds as $noChecked)
                {
                    /* Delete no checked priv*/
                    list($module, $method) = explode('-', $noChecked);
                    $this->dao->delete()->from(TABLE_GROUPPRIV)->where('`group`')->eq($role_name)->andWhere('module')->eq($module)->andWhere('method')->eq($method)->exec();
                }
            }

            /* Replace new. */
            if($this->post->actions)
            {
                foreach($this->post->actions as $moduleName => $moduleActions)
                {
                    foreach($moduleActions as $actionName)
                    {
                        $data         = new stdclass();
                        $data->group  = $role_name;
                        $data->module = $moduleName;
                        $data->method = $actionName;
                        $this->dao->replace(TABLE_GROUPPRIV)->data($data)->exec();
                    }
                }
            }
            return true;
        }

        /* Delete old. */
        $this->dao->delete()->from(TABLE_GROUPPRIV)->where('`group`')->eq($role_name)->andWhere('module')->in($this->getMenuModules($menu))->exec();

        /* Insert new. */
        if($this->post->actions)
        {
            foreach($this->post->actions as $moduleName => $moduleActions)
            {
                foreach($moduleActions as $actionName)
                {
                    $data         = new stdclass();
                    $data->group  = $role_name;
                    $data->module = $moduleName;
                    $data->method = $actionName;
                    $this->dao->insert(TABLE_GROUPPRIV)->data($data)->exec();
                }
            }
        }
        return true;
    }

    /**
     * Update privilege by module.
     * 
     * @access public
     * @return void
     */
    public function updatePrivByModule()
    {
        if($this->post->module == false or $this->post->actions == false or $this->post->groups == false) return false;

        foreach($this->post->actions as $action)
        {
            foreach($this->post->groups as $group)
            {
                $data         = new stdclass();
                $data->group  = $group;
                $data->module = $this->post->module;
                $data->method = $action;
                $this->dao->replace(TABLE_GROUPPRIV)->data($data)->exec();
            }
        }
        return true;
    }

    // /**
    //  * Update users.
    //  * 
    //  * @param  int    $role_name 
    //  * @access public
    //  * @return void
    //  */
    // public function updateUser($role_name)
    // {
    //     /* Delete old. */
    //     $this->dao->delete()->from(TABLE_USERGROUP)->where('`group`')->eq($role_name)->exec();

    //     /* Insert new. */
    //     if($this->post->members == false) return;
    //     foreach($this->post->members as $account)
    //     {
    //         $data          = new stdclass();
    //         $data->account = $account;
    //         $data->group   = $role_name;
    //         $this->dao->insert(TABLE_USERGROUP)->data($data)->exec();
    //     }
    // }
    
    /**
     * Sort resource.
     * 
     * @access public
     * @return void
     */
    public function sortResource()
    {
        $resources = $this->lang->resource;
        $this->lang->resource = new stdclass();

        /* sort moduleOrder. */
        ksort($this->lang->moduleOrder, SORT_ASC);
        foreach($this->lang->moduleOrder as $moduleName)
        {
            $resource = $resources->$moduleName;
            unset($resources->$moduleName);
            $this->lang->resource->$moduleName = $resource;
        }
        foreach($resources as $key => $resource)
        {
            $this->lang->resource->$key = $resource;
        }
        
        /* sort methodOrder. */
        foreach($this->lang->resource as $moduleName => $resources)
        {
            $resources    = (array)$resources;
            $tmpResources = new stdclass();

            if(isset($this->lang->$moduleName->methodOrder))
            {
                ksort($this->lang->$moduleName->methodOrder, SORT_ASC);
                foreach($this->lang->$moduleName->methodOrder as $key)
                {
                    if(isset($resources[$key]))
                    {
                        $tmpResources->$key = $resources[$key];
                        unset($resources[$key]);
                    }
                }
                if($resources)
                {
                    foreach($resources as $key => $resource)
                    {
                        $tmpResources->$key = $resource;
                    }
                }
                $this->lang->resource->$moduleName = $tmpResources;
                unset($tmpResources);
            }
        }
    }

    /**
     * Check menu have module 
     * 
     * @param  string    $menu 
     * @param  string    $moduleName 
     * @access public
     * @return void
     */
    public function checkMenuModule($menu, $moduleName)
    {
        if(empty($menu)) return true;
        if($menu == 'other' and (isset($this->lang->menugroup->$moduleName) or isset($this->lang->menu->$moduleName))) return false;
        if($menu != 'other' and !($moduleName == $menu or (isset($this->lang->menugroup->$moduleName) and $this->lang->menugroup->$moduleName == $menu))) return false;
        return true;
    }

    /**
     * Get modules in menu
     * 
     * @param  string    $menu 
     * @access public
     * @return void
     */
    public function getMenuModules($menu)
    {
        $modules = array();
        foreach($this->lang->resource as $moduleName => $action)
        {
            if($this->checkMenuModule($menu, $moduleName)) $modules[] = $moduleName;
        }
        return $modules;
    }
}
