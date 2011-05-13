    </div>
</div>
    <div id="navigation">
        <ul>
        {foreach from=$navigation key=k item=v}
            {if isset($v["title"])}
            <li class="li_{substr_count($k,'.')}">
                <a href="{$k}"> {$v["title"]}</a>
            </li>  
            {/if}
        {/foreach}
        </ul>
    </div>

<!--<div id="extra"></div>-->
