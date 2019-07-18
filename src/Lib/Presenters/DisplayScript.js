'use strict';

// Set web store
if ( typeof ( Storage ) !== "undefined" )
{
    if ( !localStorage.performanceToolDisplay )
        localStorage.performanceToolDisplay = 'show';

    if ( localStorage.performanceToolDisplay === 'hide' )
        performanceDisplayToggle( false );
}


function performanceDisplayToggle( show )
{
    var x = document.getElementById( 'hiddenContent' );
    var y = document.getElementById( 'performance-tool' );
    var z = document.getElementById( 'performance-btn-close' );

    var status = null;

    if ( x.style.display === 'none' || show === true )
    {
        x.style.display = 'block';
        y.style.height = '300px';
        y.style.maxWidth = '500px';
        z.innerHTML = '&#9660;';
        status = 'show';
    }
    else
    {
        x.style.display = 'none';
        y.style.height = '40px';
        y.style.maxWidth = '36px';
        z.innerHTML = '&#9650;';
        status = 'hide';
    }

    if ( typeof ( Storage ) !== "undefined" && show === null )
        localStorage.performanceToolDisplay = status;
}