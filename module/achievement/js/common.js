/* If left = 0, warning. */
function checkLeft()
{
    value = $("#left").val();
    if(isNaN(parseInt(value)) || value == 0) 
    {
        if(confirm(confirmFinish))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

$(function()
{
    $("a.extension, a.manual").modalTrigger({width:1024, height:600, type:'iframe'});
})

/**
 * Finish item use ajax.
 * 
 * @param  string url 
 * @param  string replaceID 
 * @param  string notice 
 * @access public
 * @return void
 */
function ajaxFinish(url, notice)
{
    if(confirm(notice))
    {
        $.ajax(
        {
            type:     'GET', 
            url:      url,
            dataType: 'json', 
            success:  function(data) 
            {
                if(data.result == 'success') 
                {
                    window.location.href="Task-viewTask-done.html";
                }
            }
        });
    }
}

function addMember()
{
    var tb_member = document.getElementById('memberBox');

    var tr_member = document.createElement("tr");
    tr_member.setAttribute("id", "membertr");
    var td_member = document.createElement("td");
    var input_member = document.createElement("input");
    input_member.setAttribute("type", "text");
    input_member.setAttribute("name", "member[]");
    input_member.setAttribute("id", "member[]");
    input_member.setAttribute("class", "form-control");
    
    td_member.appendChild(input_member);
    tr_member.appendChild(td_member);
    tb_member.appendChild(tr_member);
}

function deleteMember()
{
    var table = document.getElementById('memberBox');
    var len = table.rows.length;

    if(len > 1)
    {
        table.deleteRow(len-1);
    }
}