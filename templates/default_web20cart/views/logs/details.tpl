{include file="default_web20cart/views/header.tpl"}
    
   <div id="log_details">
           {if isset($logs_obj->_log_output)}
              <pre> {$logs_obj->_log_output}</pre>
           {else}
               <p>No output generated</p>
           {/if}     
   </div>
    
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}