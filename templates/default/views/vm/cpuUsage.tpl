{include file="default/views/header.tpl"}


<h1>Hourly</h1> 
<div class='chart'><script type="text/javascript" src="{$smarty.const.ONAPP_HOSTNAME}/charts/swfobject.js"></script>
      <div id="chart6d1e14212e"><strong>You need to upgrade your Flash Player</strong></div> 
      <script type="text/javascript"> 
      var flashvars6d1e14212e = {};
      flashvars6d1e14212e.path = "{$smarty.const.ONAPP_HOSTNAME}/charts/";
      flashvars6d1e14212e.chart_settings = encodeURIComponent('<?xml version="1.0" encoding="UTF_8"?> <settings> <plot_area> <margins> <top>10</top> <left>60</left> <right>60</right> <bottom>0</bottom> </margins> </plot_area> <legend> <x>330</x> </legend> <graphs> <graph gid="1"> <line_width>2</line_width> <title><![CDATA[CPU Usage (Cores)]]></title> <color>#000099</color> <color_hover>#000099</color_hover> <selected>true</selected> </graph> </graphs> <values> <y_left> <text_size>9</text_size> <min>0</min> <color>#999999</color> <max>1</max> </y_left> <x> <color>#999999</color> </x> </values> <indicator> <x_balloon_text_color>#FFFFFF</x_balloon_text_color> <line_alpha>50</line_alpha> <color>#999999</color> <selection_color>#0000DD</selection_color> <selection_alpha>20</selection_alpha> </indicator> <font_size>10</font_size> <font>Tahoma</font> <height>300</height> <balloon> <only_one>true</only_one> </balloon> <decimals_separator>.</decimals_separator> <axes> <y_left> <color>#999999</color> <width>1</width> </y_left> <x> <color>#999999</color> <width>0</width> </x> </axes> <background_color>#ffffff</background_color> <grid> <y_right> <enabled>false</enabled> </y_right> <x> <enabled>true</enabled> </x> </grid> <width>700</width> </settings> ');
      flashvars6d1e14212e.chart_data = encodeURIComponent("<chart><xaxis>{$xaxis}</xaxis><graphs><graph gid='1'>{$yaxis}</graph></graphs></chart>");
      flashvars6d1e14212e.chart_id = "chart6d1e14212e";
      flashvars6d1e14212e.wmode = "opaque";
      var params6d1e14212e = {};
      params6d1e14212e.wmode = "opaque";
      var attributes6d1e14212e = {};
      attributes6d1e14212e.id = "chart6d1e14212e";
      attributes6d1e14212e.name = "chart6d1e14212e";
      swfobject.embedSWF("{$smarty.const.ONAPP_HOSTNAME}/charts/amline/amline.swf", "chart6d1e14212e", "700", "300", "8", "", flashvars6d1e14212e, params6d1e14212e, attributes6d1e14212e);
      // ]]>
      </script> 
      </div>

{include file="default/views/vm/navigation.tpl"}
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}