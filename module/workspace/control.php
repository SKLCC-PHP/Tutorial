<?php
class workspace extends control
{

    /**
     * Construct function, load user models auto.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('task');
        $this->loadModel('project');
        $this->loadModel('tutorial');
    }


    /**
     * Index page, to browse.
     *
     * @param  string $locate     locate to browse page or not. If not, display all products.
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('task'));
    }

    /**
     * Browse a product.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function MyCalendar()
    {
        $this->display();
    }

    /**
     * Browse a product.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function task()
    { 
        $this->locate($this->createLink('task', 'viewTask'), 'parent');
    }

    /**
     * Browse a product.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function viewProblem()
    {
        $this->locate($this->createLink('problem', 'viewProblem', 'viewtype=all'), 'parent');
    }

    /**
     * View a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function viewAchievement()
    {
        $this->locate($this->createLink('achievement', 'viewAchievement'), 'parent');
    }

    /**
     * View a product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function viewProject()
    {
        $this->locate($this->createLink('project', 'viewProject'), 'parent');
    }

    /**
     * Browse a product.
     * 
     * @param  int    $productID 
     * @param  string $browseType 
     * @param  int    $param 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function viewConclusion()
    {
        $this->locate($this->createLink('conclusion', 'viewConclusion'), 'parent');
    }

    public function viewTutorialSystem()
    {
        $this->locate($this->createLink('tutorial', 'viewTutorialSystem'), 'parent');
    }

    public function viewNotice()
    {
        $this->locate($this->createLink('notice', 'viewNotice'), 'parent');
    }
}