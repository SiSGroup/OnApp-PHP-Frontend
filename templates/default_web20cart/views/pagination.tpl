    <div style="position:inherit" id="pagination">
        {if isset($page)}
            {$cpage=$page}
        {else}
            {$cpage=1}
        {/if}

        {$pagedisprange=3}

        {$pagescount=$pages_quantity}

        {$stpage=$cpage-$pagedisprange}

        {if $stpage<1}
            {$stpage=1}
        {/if}

        {$endpage=$cpage+$pagedisprange}

        {if $endpage>$pagescount}
            {$endpage=$pagescount}
        {/if}

        {if $cpage>1}
            <a href="{$_ALIASES[$alias]}?page=1">{'FIRST_'|onapp_string}</a>
            <a href="{$_ALIASES[$alias]}?page={$cpage-1}">{'PREVIOUS_'|onapp_string}</a>
        {/if}

        {if $stpage>1}
            ...
        {/if}

        {$i=$stpage}

        {while $i<=$endpage}
            {if $i==$cpage}
               <em>{$i}</em>
            {else}
                <a href='{$_ALIASES[$alias]}?page={$i}'>{$i}</a>
            {/if}
            {$i=$i+1}
        {/while}

        {if $endpage<$pagescount}
           ...
        {/if}

        {if $cpage<$pagescount}
            <a href="{$_ALIASES[$alias]}?page={$cpage+1}">{'NEXT_'|onapp_string}</a>
            <a href="{$_ALIASES[$alias]}?page={$pagescount}">{'LAST_'|onapp_string}</a>
        {/if}
    </div>