{include file="default/views/header.tpl"}
    
   <div id="log_details">
           {if isset($contents)}
               <pre>{$contents}</pre>
           {else}
               <p>No output generated</p>
           {/if}       
   </div>
    
{include file="default/views/navigation.tpl"}
{include file="default/views/footer.tpl"}