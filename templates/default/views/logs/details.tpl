{include file="default/views/header.tpl"}
    
   <div id="log_details">
       <pre>
           {if isset($logs_obj->_log_output)}
               {$logs_obj->_log_output}
           {else}
               <p>No output generated</p>
           {/if}
       </pre>
   </div>
    
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}