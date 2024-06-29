let main = (function () {

    function loadRemote(url, id_to_replace) {

        $.get(url, function (html) {
            $(id_to_replace).html(html);

        }).done(function () {
        }).fail(function (jqXHR, textStatus, errorThrown) {
        }).always(function () {

        });
    }

    function initAjax() {
        $('[data-ajax=true]').click(function (e) {
            e.preventDefault();
            let url = $(this).attr("href");
            let data = {url: url};
            showDialog(data)
        });
    }


    function showDialog(data) {

        $.get(data.url, function (html) {

            $('.modal').html();
            $('.modal').html(html);
            $('.modal').modal('show');
           
        }).done(function () {
        }).fail(function (jqXHR, textStatus, errorThrown) {
          
        }).always(function () {
         
        });
    }


    function submitAjaxForm() {
    $("#modal-form-submit").submit(function (e) {
     
        e.preventDefault();
      
        let button = $("button[type=submit][clicked=true]");
     
        let form = $("#modal-form-submit");
        let url = form.attr('action');
     
        let data = form.serializeArray(); // convert form to array
        data.push({name: "submit", value: button.val()});

        $.ajax({
            method: "POST",
            url: url,
            data: $.param(data)
        }).done(function (data, textStatus, jqXHR) {
          

    var liveToast = new window.bootstrap.Toast(document.getElementById('liveToast'));
      liveToast && liveToast.show();

      $('.modal').modal('hide');
      $('.modal').html('');

      let dfurl = data.url;
      main.loadRemote(dfurl, data.target)


            if (data && data.message) {
                if (data.target && data.url) {
                    let loadUrl = data.url;
                    if (data.params) {
                        loadUrl = loadUrl + '?' + data.params;
                    }

                    $(data.target).load(loadUrl, function () {
                        if (data.callback) eval(data.callback);
                    });
                }

            } else if(data.action && data.action == 'reload-page'){
                location.reload();
            } else {
            }

        }).fail(function (jqXHR, textStatus, errorThrown) {
       
        }).always(function (data, textStatus, jqXHR) {
      
        });
    })
}


 function numberDecimalForm() {

        $('.comma-separated').toArray().forEach(function(field){
            new Cleave(field, {
                numeral: true,
                numeralDecimalScale: 2
            })
        });
    }
    


    function init() {
        submitAjaxForm();
        numberDecimalForm();
    }

    function initSelect2() {
        $(".select2").select2({
            placeholder: "Select an option",
            allowClear: true
        });

        $(".status").select2({
            placeholder: "Select Status",
            allowClear: true
        });

        $(".file").select2({
            placeholder: "Select a File",
            allowClear: true
        });

        $(".externalawyer").select2({
            placeholder: "Select External Lawyer",
            allowClear: true
        });

    }


    return {
        loadRemote: loadRemote,
        initAjax: initAjax,
        showDialog: showDialog,
        init: init,
        numberDecimalForm: numberDecimalForm,
        initSelect2: initSelect2,
    };
})();

