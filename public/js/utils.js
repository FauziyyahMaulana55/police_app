// function get cookie
function getCookie(name){
    const value = `; ${document.cookie}`;
    const part = value.split(`; ${name}=`);
    return part.length === 2 ? part.pop().split(';').shift() : null;
}

 window.getCookie = getCookie;
