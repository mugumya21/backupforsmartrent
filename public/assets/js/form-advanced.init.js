jQuery(document).ready(function(){$('[data-toggle="select2"]').select2({
    dropdownParent: $('#myModal')
})}),$('[data-plugin="switchery"]').each(function(a,n){new Switchery($(this)[0],$(this).data())});