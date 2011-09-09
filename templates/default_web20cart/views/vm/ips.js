
var select = document.getElementById('period');
select.onchange = function() {
    var id = this.value;
    var options = '<option value=""></option>';
    for( i in IPs[id] ) {
        if( id )
            options += '<option value="'+i+'">'+IPs[id][i]+'</option>';
    }
    document.getElementById( 'ips' ).innerHTML = options;
};