{include file="default/views/header.tpl"}


<h1>Hourly</h1> 
<div class='chart'>

    <script type="text/javascript" src="{$smarty.const.ONAPP_HOSTNAME}/javascripts/Highcharts-2.1.9/js/highcharts.js"></script>
    <div id="chart6d1e14212e"></div>


    <script type="text/javascript"> 

        {literal}
      //<![CDATA[

        new Highcharts.Chart({series: {/literal}{$data}{literal}}], title: {text: 'Hourly', x: -20}, credits: {enabled: false}, chart: {height: 300, renderTo: 'chart6d1e14212e', width: 732, defaultSeriesType: 'line', zoomType: 'x'}, tooltip: {shared: true, crosshairs: true}, xAxis: {type: 'datetime', labels: {formatter: function() { return Highcharts.dateFormat("%e %b %H:%M", this.value); }}}, yAxis: {title: {text: null}}, plotOptions: {series: {marker: {states: {hover: {enabled: true}}, enabled: false, lineWidth: 0}}}, lang: {decimalPoint: '.', thousandsSep: 3, downloadPNG: 'Download PNG image', weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], downloadJPEG: 'Download JPEG image', resetZoomTitle: 'Reset zoom level 1:1', exportButtonTitle: 'Export to raster or vector image', resetZoom: 'Reset zoom', loading: 'Loading....', downloadPDF: 'Download PDF document', months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], printButtonTitle: 'Print the chart', downloadSVG: 'Download SVG vector image', shortMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']}});
 
      //]]

   
        </script> 
    {/literal}

</div>

{include file="default/views/vm/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}