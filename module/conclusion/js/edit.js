$(function() 
{
    $("#story, #mailto").chosen(defaultChosenOptions);
    $('.iframe').modalTrigger({width:900, type:'iframe', afterHide:function(){parent.location.href=parent.location.href;}});
})

/**
 * Load module, stories and members. 
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadAll(projectID)
{
    if(!changeProjectConfirmed)
    {
         firstChoice = confirm(confirmChangeProject);
         changeProjectConfirmed = true;    // Only notice the user one time.
    }
    if(changeProjectConfirmed || firstChoice)
    {
        loadModuleMenu(projectID); 
        loadProjectStories(projectID);
        loadProjectMembers(projectID);
    }
}

/**
 * Load module of the project. 
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadModuleMenu(projectID)
{
    link = createLink('tree', 'ajaxGetOptionMenu', 'rootID=' + projectID + '&viewtype=task');
    $('#moduleIdBox').load(link);
}

/**
 * Load stories of the project. 
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadProjectStories(projectID)
{
    link = createLink('story', 'ajaxGetProjectStories', 'projectID=' + projectID + '&productID=0&moduleID=0&storyID=' + oldStoryID);
    $('#storyIdBox').load(link, function(){$('#story').chosen();});
}

/**
 * Load team members of the project. 
 * 
 * @param  int    $projectID 
 * @access public
 * @return void
 */
function loadProjectMembers(projectID)
{
    link = createLink('project', 'ajaxGetMembers', 'projectID=' + projectID);
    $('#assignedToIdBox').load(link);
}

/* empty function. */
function setPreview(){}
