{include file="default_web20cart/views/header.tpl"}
    
   <div id="log_details">
           {if isset($contents)}
               <pre>{$contents}</pre>
           {else}
               <p>No output generated</p>
           {/if}       
   </div>
    
{include file="default_web20cart/views/navigation.tpl"}
{include file="default_web20cart/views/footer.tpl"}