
function in_array (needle, haystack, argStrict) {
    var key = '',
        strict = !! argStrict;

    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }
    return false;
}

function paginate ( page ) {
    item_id = 1
    var style
    roles_html = ''
    
    if ( page != 1 ) {
        from = ( page -1 ) * items_per_page + 1
        untill = ( page -1 ) * items_per_page + items_per_page
    }
    else{
        from = 1
        untill = items_per_page
    }

    for ( permission in permission_array) {
        style = ( item_id < from || item_id > untill ) ? 'style = "position:absolute; left: -2011px"' : ''

        checked = in_array( permission_array[permission].id, checked_role_ids_js ) ? 'checked="true"' : ''
         
        roles_html += '<div id="role_'+ item_id + '" ' + style + '>\n\
                           <dl>\n\
                               <dt></dt>\n\
                               <dd>\n\
                                   <input type="hidden" name="role[_permission_ids][]" value="0" />\n\
                                   <input id = "checkbox_'+ item_id +'" onclick = "update_checked_role_ids_js(' + item_id + ')" value="' + permission_array[permission].id +'" type="checkbox" name="role[_permission_ids][]" ' + checked + ' />\n\
                                   <span style="font-weight:normal">'+ permission_array[permission]._label +'</span> <b>( ' + permission_array[permission].identifier + ')</b>\n\
                               </dd>\n\
                          </dl>\n\
                      </div>'
        item_id++
    }
    
    document.getElementById('all_roles').innerHTML = roles_html;

    //insert pagination html
    cpage = page
    pagedisprange=3
    stpage=cpage - pagedisprange

    if ( stpage < 1 ) {
        stpage = 1
    }

    endpage = cpage + pagedisprange

    if ( endpage > pagescount ) {
        endpage = pagescount
    }

    prenavigation = ( cpage > 1 ) ? '<a style="cursor:pointer" onclick = "paginate( 1 )">First</a><a style="cursor:pointer" onclick = "paginate( cpage-1 )">Previous</a>' : ''

    dots = ( stpage > 1 ) ? '...' : ''

    i = stpage

    pagination_html = prenavigation + dots + ''

    while ( i <= endpage ) {
        html_to_add = ( i == cpage ) ? '<em style="cursor:pointer">' + i + '</em>' : '<a style="cursor:pointer" onclick = "paginate( '+ i +' )">' + i + '</a>'
        pagination_html += html_to_add
        i++
    }
    
    end_dots = ( endpage < pagescount ) ? '...' : ''

    pagination_html += end_dots

    after_pagination = ( cpage < pagescount ) ? '<a style="cursor:pointer" onclick = "paginate( cpage+1 )">Next</a><a style="cursor:pointer" onclick = "paginate( pagescount )" >Last</a>' : ''

    pagination_html += after_pagination

    document.getElementById('pagination').innerHTML = pagination_html;

}

function update_checked_role_ids_js ( item_id ) {
    if ( document.getElementById( 'checkbox_' + item_id ).checked ) {
        checked_role_ids_js.push( item_id )
    }
    else {
        var idx = checked_role_ids_js.indexOf( item_id )
        if ( idx != -1 ) {
            checked_role_ids_js.splice( idx, 1 )
        }
    }
}