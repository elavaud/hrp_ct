/* 
 * JS file containing all the functions used during the submission or the edition of clinical trials.
 * Step 3: INVESTIGATIONAL DRUG PRODUCT INFORMATION
 */

function addDrugInfo(){
    var drugHtml = '<div class="drugSupp" id="articleDrugs-X">' + $('#articleDrugs-0').html() + '</div>';
    if ($(".drugSupp").length){
        var selectName = $('div.drugSupp:last').attr('id');
        var selectNameStartRemoved = selectName.replace('articleDrugs-', '');
        var fieldId = parseInt(selectNameStartRemoved) + 1;
    } else {    
        var fieldId = 1;
    }     
    drugHtml = drugHtml.replace('articleDrugs-X', 'articleDrugs-'+fieldId);
    for (i = 0; i < 30; i++) { 
        drugHtml = drugHtml.replace('articleDrugs-0', 'articleDrugs-'+fieldId);
    }
    for (i = 0; i < 30; i++) { 
        drugHtml = drugHtml.replace('articleDrugs[0', 'articleDrugs['+fieldId);
    }
    if ($(".drugSupp").length){
        $('div.drugSupp:last').after(drugHtml);
    } else {
        $('#articleDrugs-0').after(drugHtml);
    }
    $('div.drugSupp:last').find('.hiddenInputs').remove('');
    $('div.drugSupp:last').find('tr.showHideHelpField').remove('');
    $('div.drugSupp:last').find('a.showHideHelpButton').remove('');    
    $('#articleDrugs-'+fieldId+'-type').removeAttr('disabled');   
    $('#articleDrugs-'+fieldId+'-type').append('<option value=""></option>');
    $('#articleDrugs-'+fieldId+'-type').val('');            
    $('#articleDrugs-'+fieldId).find('.removeDrug').show();
    $('#articleDrugs-'+fieldId).find('.removeDrug').click(function(){$(this).closest('div').remove();});   
    $('#articleDrugs-'+fieldId+'-title').html(fieldId+1);
    $('#articleDrugs-'+fieldId+'-name').val('');
    $('#articleDrugs-'+fieldId+'-brandName').val('');
    $('#articleDrugs-'+fieldId+'-administration').val('');
    $('#articleDrugs-'+fieldId+'-administration').change(function(e) {var id = e.target.id;showOrHideOherAdministrationField(id);});
    showOrHideOherAdministrationFields();
    $('#articleDrugs-'+fieldId+'-form').val('');
    $('#articleDrugs-'+fieldId+'-form').change(function(e) {var id = e.target.id;showOrHideOherFormField(id);});
    showOrHideOherFormFields();
    $('#articleDrugs-'+fieldId+'-strength').val('');
    $('#articleDrugs-'+fieldId+'-storage').val('');
    $('#articleDrugs-'+fieldId+'-pharmaClass').val('');
}

function showOrHideOherAdministrationField(id){
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-administration', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#articleDrugs-'+fieldId+'-otherAdministrationField').show();
        if($('#articleDrugs-'+fieldId+'-otherAdministration').val() === "NA") {
            $('#articleDrugs-'+fieldId+'-otherAdministration').val("");
        }
    } else {
        $('#articleDrugs-'+fieldId+'-otherAdministrationField').hide();
        $('#articleDrugs-'+fieldId+'-otherAdministration').val("NA");
    }
}

function showOrHideOherAdministrationFields(){
    $("select[id*='-administration']").each(
        function() {
           showOrHideOherAdministrationField($(this).attr("id"));
        }
    );
}

function showOrHideOherFormField(id){
    var idStartRemoved = id.replace('articleDrugs-', '');
    var idStartAndEndRemoved = idStartRemoved.replace('-form', '');
    var fieldId = parseInt(idStartAndEndRemoved);
    var value = $("#"+id).val();
    if (value === 'OTHER') {
        $('#articleDrugs-'+fieldId+'-otherFormField').show();
        if($('#articleDrugs-'+fieldId+'-otherForm').val() === "NA") {
            $('#articleDrugs-'+fieldId+'-otherForm').val("");
        }
    } else {
        $('#articleDrugs-'+fieldId+'-otherFormField').hide();
        $('#articleDrugs-'+fieldId+'-otherForm').val("NA");
    }
}

function showOrHideOherFormFields(){
    $("select[id*='-form']").each(
        function() {
           showOrHideOherFormField($(this).attr("id"));
        }
    );
}