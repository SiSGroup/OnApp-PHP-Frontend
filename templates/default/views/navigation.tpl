    </div>    

    <div id="navigation">
        <ul>
            {foreach from=$navigation key=k item=v}
                {if isset($v["title"])}
                   {if $v["show"] > 0}
                        <li class="li_{substr_count($k,'.')}">
    
    
                            <a href="{$k}"> {$v.title|onapp_string}</a>
                        </li>
                    {/if}
                {/if}
            {/foreach}
        </ul>
    </div>


