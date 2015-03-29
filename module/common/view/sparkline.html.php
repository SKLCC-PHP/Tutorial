<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<style>
.projectline {padding: 2px!important}
</style>
<!--[if lte IE 8]>
<?php
js::import($jsRoot . 'chartjs/excanvas.min.js');
?>
<![endif]-->
<?php js::import($jsRoot . 'chartjs/chart.line.min.js');?>
<script>
jQuery.fn.projectLine = function(setting)
{
    $(this).each(function()
    {
        var $e = $(this);
        var options = $.extend({values: $e.attr('values')}, $e.data(), setting),
            height = $e.height() - 4,
            values = [],
            maxWidth = $e.width() - 4;
        var strValues = options.values.split(',');
        for(var i in strValues)
        {
            var v = parseFloat(strValues[i]);
            if(v != NaN) values.push(v);
        }
        
        var width = Math.min(maxWidth, Math.max(10, values.length*maxWidth/30));
        var canvas = $e.children('canvas');
        if(!canvas.length)
        {
            $e.append('<canvas class="projectline-canvas"></canvas>');
            canvas = $e.children('canvas');
            if(navigator.userAgent.indexOf("MSIE 8.0")>0) G_vmlCanvasManager.initElement(canvas[0]);
        }
        canvas.attr('width', width).attr('height',height);
        $e.data('projectLineChart',new Chart(canvas[0].getContext("2d")).Line({
            labels : values,
            datasets: [{
                fillColor : "rgba(0,0,255,0.25)",
                strokeColor : "rgba(0,0,255,1)",
                pointColor : "rgba(255,136,0,1)",
                pointStrokeColor : "#fff",
                data : values
            }]
        }));
    });
}

$(function(){$('.projectline').projectLine();});
</script>
