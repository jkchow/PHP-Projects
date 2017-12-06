//操作cookie

function getCookie(name)
{
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while (i < clen)
    {
        var j = i + alen;
        if (document.cookie.substring(i, j) == arg)
            return getCookieVal(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    }
    return "";
}

function setCookie(name, value)
{
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;
    var expDay = (argc > 2) ? argv[2] : -1;
    try
    {
        expDay = parseInt(expDay);
    }
    catch(e)
    {
        expDay = -1;
    }
    if(expDay < 0) {
        setCookieVal(name, value);
    } else {
        var expDate = new Date();
        // The expDate is the date when the cookie should expire, we will keep it for a month
        expDate.setTime(expDate.getTime() + (expDay * 24 * 60 * 60 * 1000));
        setCookieVal(name, value, expDate);
    }
}

function deleteCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    // This cookie is history
    var cval = getCookie(name);
    document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}

function getCookieVal(offset)
{
    var endstr = document.cookie.indexOf(";", offset);
    if (endstr == -1)
        endstr = document.cookie.length;
    return decodeURIComponent(document.cookie.substring(offset, endstr));
}

function setCookieVal(name, value)
{
    var argv = setCookieVal.arguments;
    var argc = setCookieVal.arguments.length;
    var expires = (argc > 2) ? argv[2] : null;
    var path = (argc > 3) ? argv[3] : null;
    var domain = (argc > 4) ? argv[4] : null;
    var secure = (argc > 5) ? argv[5] : false;
    document.cookie = name + "=" + encodeURIComponent(value) +
                      ((expires == null || expires < 0) ? "" : ("; expires=" + expires.toGMTString())) +
                      ((path == null) ? "" : ("; path=" + path)) +
                      ((domain == null) ? "" : ("; domain=" + domain)) +
                      ((secure == true) ? "; secure" : "");
}