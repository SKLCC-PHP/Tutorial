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
 * Compute work days.
 * 
 * @access public
 * @return void
 */
function computeWorkDays()
{
    var begin = document.getElementById("starttime").value;
    var end = document.getElementById("deadline").value;
    
    
    if (new Date(begin) == 'Invalid Date')
    {
        alert('请正确填写日期');
        $('#starttime').val(''); 
        return;
    }
    if (!end) return;
    if (new Date(end) == 'Invalid Date')
    {
        alert('请正确填写日期');
         $('#deadline').val('');
         return;
    }
    if (begin > end)
    {
        $('#deadline').val('');
        $('#days').val('');
        alert("截止时间不能在开始时间之前！！");
        return ;
    }
    
    if (new Date() > new Date(end)) 
    {
        $('#deadline').val('');
        $('#days').val('');
        alert('截止时间必须在当期时间之后！！');
        return;
    }
    var d_bengin = begin.split('-');
    var d_end = end.split('-');

    var n_begin = new Date(d_bengin[0] + '-' + d_bengin[1] + '-' + d_bengin[2]);
    var n_end = new Date(d_end[0] + '-' + d_end[1] + '-' + d_end[2]);

    var days = parseInt(((n_end.getTime() - n_begin.getTime())/(1000*3600*24)));
    $('#days').val(days);
}

function computeWorkDate()
{
    var begin = document.getElementById('starttime').value;
    var days = document.getElementById('days').value;

    if(isNaN(days))
    {
        alert("请正确填写天数");
        $('#days').val('');
        return;
    }

    if (days < 0)
    {
        $('#deadline').val('');
        $('#days').val('');
        alert("天数不能为负!!");
        return ;
    }
    
    var cur_time = new Date();
    var deadline = new Date(begin);
    if (deadline == 'Invalid Date')
    {
        alert('请正确填写日期');
        $('#starttime').val('');
        return;
    }
    deadline = deadline.valueOf();
    deadline = deadline + days*24*60*60*1000;   
    deadline = new Date(deadline);

    if (cur_time > deadline) 
    {
        $('#deadline').val('');
        $('#days').val('');
        alert('截止时间必须在当期时间之后！！');
        return;
    }
    var end = deadline.getFullYear() + '-' + (deadline.getMonth()+1) + '-' + deadline.getDate();
    $('#deadline').val(end);
}