$(function() {

    /*redirect page based on what sort button was clicked on (date or relevance)*/
    $("#date").on("click", { redirect: "date", opp: "rel" }, redirectPage);
    $("#rel").on("click", { redirect: "rel", opp: "date" }, redirectPage);

    function redirectPage(event) { 
        var redirect = event.data.redirect;
        console.log(redirect);

        var opp = event.data.opp;
        console.log(opp);

        var url = window.location.href;
        console.log(url);

        if (url.indexOf('?') == -1) {
            var sort = '?sort=';    
        } else {
            var sort = '&sort=';
        }

        console.log(sort);

        /*  search for word in the url
        if not found then redirect the user*/
        if (url.indexOf('=' + redirect) == -1) {
            if (url.indexOf('=' + opp) != -1) {
                var Path = url.replace('=' + opp, '=' + redirect);
                window.location.assign(Path);   
            }else {
                window.location.assign(url + sort + redirect);
            }
        }
    }

    /*Disable date/rel button if the url has date/rel in there*/
    if ((window.location.href).indexOf('sort') != -1) {

        if ((window.location.href).indexOf('=date') != -1) {

            $("#date").attr( "disabled", "disabled" );
            $("#rel").removeAttr("disabled");

        }else if ((window.location.href).indexOf('=rel') != -1){    
            $("#rel").attr( "disabled", "disabled" );
            $("#date").removeAttr("disabled");
        }

    }else {

        $("#date").removeAttr("disabled");
        $("#rel").removeAttr("disabled");

    }

    /*redirect user based on what select name='start' option they picked*/
    $('select[name="start"]').on('change', function () {
        //console.log('change works for select start');
        var pagClicked = $('select[name="start"] option:selected').val();
        //console.log(pagClicked);
        var numResults = $('select[name="num"] option:selected').val();
        //console.log(numResults);
        var startValue = (parseInt(pagClicked) -1) * parseInt(numResults);
        //console.log(startValue);

        //start value from current page
        var sValPage = $('input[name="hStart"]').val();

        var url = window.location.href;
        console.log(url);

        if ((url).indexOf('start=') == -1) {
            window.location.assign(url + '&start=' + startValue);   
        }else {
            var Path = url.replace('start=' + sValPage, 'start=' + startValue);
            window.location.assign(Path);   
        }
            
    }); 

    /*Select the correct number from select name='start'*/
    if ((window.location.href).indexOf('start=') != -1) {
        var url = window.location.href;

        var numIndex = (url).indexOf('start=');

        //start value from current page
        var sValPage = $('input[name="hStart"]').val();

        var numResults = $('select[name="num"] option:selected').val();

        var pagVal = sValPage/numResults + 1;

        if (numIndex != -1) {
            ($('select[name="start"] option'))
            .each(function() { this.selected = (this.text == pagVal) });

        }
    }

    /*Select the correct number from select name='num'*/
    var url = window.location.href;

    var numIndex = (url).indexOf('num=');

    //get the value of num= from the url
    var returnedNum = (url).substr(numIndex + 4,2);

    if (numIndex != -1) {
        console.log(returnedNum);
        ($('select[name="num"] option'))
        .each(function() { this.selected = (this.text == returnedNum); });

    }

    /*if num is in url, then redirect user automatically*/
    if ((window.location.href).indexOf('num=') != -1) {
        $('select[name="num"]').on('change', function () {

            //num value from current page
            var nValPage = $('input[name="hNum"]').val();
            var numResults = $('select[name="num"] option:selected').val();

            var url = window.location.href;
            console.log(url);

            if ((url).indexOf('num=') == -1) {
                window.location.assign(url + '&num=' + numResults);   
            }else {
                var Path = url.replace('num=' + nValPage, 'num=' + numResults);
                window.location.assign(Path);   
            }


        });     
    }

});