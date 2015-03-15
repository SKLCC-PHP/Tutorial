/* Load the products of the roject. */
function loadProducts(project)
{
    link = createLink('project', 'ajaxGetProducts', 'projectID=' + project);
    $('#productBox').load(link);
}

/* Set doc type. */
function setType(type)
{
    if(type == 'url')
    {
        $('#urlBox').show();
        $('#fileBox').hide();
        $('#contentBox').hide();
    }
    else if(type == 'text')
    {
        $('#urlBox').hide();
        $('#fileBox').hide();
        $('#contentBox').show();
    }
    else
    {
        $('#urlBox').hide();
        $('#fileBox').show();
        $('#contentBox').hide();
    }
}

$(document).ready(function()
{
    $("#submenucreate").modalTrigger({type: 'iframe', width: 500});
    $("#submenuedit").modalTrigger({type: 'iframe', width: 500});
});

$(function() 
{ 
    /* Set the heights of every block to keep them same height. */
    projectBoxHeight = $('#projectbox').height();
    productBoxHeight = $('#productbox').height();
    if(projectBoxHeight < 180) $('#projectbox').css('height', 180);
    if(productBoxHeight < 180) $('#productbox').css('height', 180);

    row2Height = $('#row2').height() - 10;
    row2Height = row2Height > 200 ? row2Height : 200;
    $('#row2 .block').each(function(){$(this).css('height', row2Height);})
});

